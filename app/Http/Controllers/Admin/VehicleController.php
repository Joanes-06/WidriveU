<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleController extends Controller
{
    /**
     * Show the vehicles index with stats.
     */
    public function index(Request $request): View
    {
        $query = Vehicle::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('license_plate', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $vehicles = $query->latest()->paginate(15)->withQueryString();

        $statsAvailable = Vehicle::where('status', 'disponible')->count();
        $statsReserved = Vehicle::where('status', 'reservee')->count();
        $statsMaintenance = Vehicle::where('status', 'maintenance')->count();

        return view('admin.vehicles.index', compact(
            'vehicles',
            'statsAvailable',
            'statsReserved',
            'statsMaintenance'
        ));
    }

    /**
     * Show the create vehicle form.
     */
    public function create(): View
    {
        return view('admin.vehicles.create');
    }

    /**
     * Store a new vehicle.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'brand'                => 'required|string|max:255',
            'model'                => 'nullable|string|max:255',
            'category'             => 'required|string|in:' . implode(',', array_keys(\App\Models\Vehicle::CATEGORIES)),
            'year'                 => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'license_plate'        => 'nullable|string|max:20|unique:vehicles',
            'seats'                => 'required|integer|min:1|max:50',
            'fuel_type'            => 'required|in:essence,diesel,electrique,hybride',
            'transmission'         => 'required|in:manuelle,automatique',
            'description'          => 'nullable|string',
            'photo'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_2'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_3'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_4'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status'               => 'required|in:disponible,reservee,maintenance',
            'price_without_driver' => 'required|integer|min:0',
            'price_with_driver'    => 'required|integer|min:0',
        ]);

        $extra = [];
        foreach (['photo', 'image_2', 'image_3', 'image_4'] as $field) {
            if ($request->hasFile($field)) {
                $name = time() . '_' . $field . '_' . uniqid() . '.jpg';
                $dest = public_path('uploads/vehicles/' . $name);
                $this->resizeAndSave($request->file($field)->getRealPath(), $dest);
                $extra[$field] = $name;
            } else {
                $extra[$field] = null;
            }
        }

        Vehicle::create(array_merge($validated, $extra));

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Véhicule créé avec succès.');
    }

    /**
     * Show the edit vehicle form.
     */
    public function edit(Vehicle $vehicle): View
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update a vehicle.
     */
    public function update(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'brand'                => 'required|string|max:255',
            'model'                => 'nullable|string|max:255',
            'category'             => 'required|string|in:' . implode(',', array_keys(\App\Models\Vehicle::CATEGORIES)),
            'year'                 => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'license_plate'        => 'nullable|string|max:20|unique:vehicles,license_plate,' . $vehicle->id,
            'seats'                => 'required|integer|min:1|max:50',
            'fuel_type'            => 'required|in:essence,diesel,electrique,hybride',
            'transmission'         => 'required|in:manuelle,automatique',
            'description'          => 'nullable|string',
            'photo'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_2'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_3'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_4'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status'               => 'required|in:disponible,reservee,maintenance',
            'price_without_driver' => 'required|integer|min:0',
            'price_with_driver'    => 'required|integer|min:0',
        ]);

        foreach (['photo', 'image_2', 'image_3', 'image_4'] as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                if ($vehicle->$field && file_exists(public_path('uploads/vehicles/' . $vehicle->$field))) {
                    unlink(public_path('uploads/vehicles/' . $vehicle->$field));
                }
                $name = time() . '_' . $field . '_' . uniqid() . '.jpg';
                $dest = public_path('uploads/vehicles/' . $name);
                $this->resizeAndSave($request->file($field)->getRealPath(), $dest);
                $validated[$field] = $name;
            } else {
                // Keep existing value — don't overwrite
                unset($validated[$field]);
            }
        }

        // Handle image deletion (if admin checked "delete" checkboxes)
        foreach (['image_2', 'image_3', 'image_4'] as $field) {
            if ($request->boolean('delete_' . $field)) {
                if ($vehicle->$field && file_exists(public_path('uploads/vehicles/' . $vehicle->$field))) {
                    unlink(public_path('uploads/vehicles/' . $vehicle->$field));
                }
                $validated[$field] = null;
            }
        }

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Véhicule mis à jour avec succès.');
    }

    /**
     * Resize and save an image to a fixed 690×440 canvas (center-crop).
     * Uses only PHP's built-in GD library — no extra dependencies.
     */
    private function resizeAndSave(string $sourcePath, string $destPath, int $targetW = 690, int $targetH = 440): void
    {
        [$origW, $origH, $type] = getimagesize($sourcePath);

        $src = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($sourcePath),
            IMAGETYPE_PNG  => imagecreatefrompng($sourcePath),
            IMAGETYPE_WEBP => imagecreatefromwebp($sourcePath),
            IMAGETYPE_GIF  => imagecreatefromgif($sourcePath),
            default        => null,
        };

        if (!$src) {
            // Fallback: just copy the file as-is
            copy($sourcePath, $destPath);
            return;
        }

        // Scale to cover target (like object-fit: cover)
        $scaleW = $targetW / $origW;
        $scaleH = $targetH / $origH;
        $scale  = max($scaleW, $scaleH);

        $scaledW = (int) round($origW * $scale);
        $scaledH = (int) round($origH * $scale);

        // Center-crop offsets
        $offsetX = (int) round(($scaledW - $targetW) / 2);
        $offsetY = (int) round(($scaledH - $targetH) / 2);

        $canvas = imagecreatetruecolor($targetW, $targetH);

        // Preserve transparency for PNG
        if ($type === IMAGETYPE_PNG) {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
            imagefilledrectangle($canvas, 0, 0, $targetW, $targetH, $transparent);
        }

        imagecopyresampled(
            $canvas, $src,
            0, 0,
            (int) round($offsetX / $scale), (int) round($offsetY / $scale),
            $targetW, $targetH,
            (int) round($targetW / $scale), (int) round($targetH / $scale)
        );

        imagejpeg($canvas, $destPath, 88);

        imagedestroy($src);
        imagedestroy($canvas);
    }

    /**
     * Delete a vehicle.
     */
    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        if ($vehicle->reservations()->whereIn('status', ['active', 'pending'])->exists()) {
            return back()->with('error', 'Impossible de supprimer : ce véhicule a des réservations actives.');
        }

        // Delete all photos
        foreach (['photo', 'image_2', 'image_3', 'image_4'] as $field) {
            if ($vehicle->$field && file_exists(public_path('uploads/vehicles/' . $vehicle->$field))) {
                unlink(public_path('uploads/vehicles/' . $vehicle->$field));
            }
        }

        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Véhicule supprimé avec succès.');
    }
}
