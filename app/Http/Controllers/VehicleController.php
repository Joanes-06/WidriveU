<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleController extends Controller
{
    /**
     * Show the fleet listing with filters.
     */
    public function index(Request $request): View
    {
        $query = Vehicle::query()->where('status', 'disponible');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('brand')) {
            $query->where('brand', 'like', "%{$request->brand}%");
        }

        if ($request->filled('seats')) {
            $query->where('seats', '>=', $request->seats);
        }

        if ($request->filled('prix_max')) {
            $query->where('price_without_driver', '<=', $request->prix_max);
        }

        $sortMap = [
            'price_asc'  => ['price_without_driver', 'asc'],
            'price_desc' => ['price_without_driver', 'desc'],
            'name_asc'   => ['name', 'asc'],
        ];
        [$col, $dir] = $sortMap[$request->sort] ?? ['id', 'asc'];
        $query->orderBy($col, $dir);

        $vehicles = $query->paginate(8)->withQueryString();

        $brands = Vehicle::where('status', 'disponible')
            ->select('brand')->distinct()->orderBy('brand')->pluck('brand');

        return view('frontend.fleet', compact('vehicles', 'brands'));
    }

    /**
     * Show a single vehicle detail page.
     */
    public function show(Vehicle $vehicle): View
    {
        // Priorité : même catégorie, sinon compléter avec d'autres véhicules
        $related = collect();

        if ($vehicle->category) {
            $related = Vehicle::where('status', 'disponible')
                ->where('id', '!=', $vehicle->id)
                ->where('category', $vehicle->category)
                ->inRandomOrder()
                ->take(3)
                ->get();
        }

        if ($related->count() < 3) {
            $needed = 3 - $related->count();
            $exclude = $related->pluck('id')->push($vehicle->id);

            $fillers = Vehicle::where('status', 'disponible')
                ->whereNotIn('id', $exclude)
                ->inRandomOrder()
                ->take($needed)
                ->get();

            $related = $related->concat($fillers);
        }

        return view('frontend.vehicle-detail', compact('vehicle', 'related'));
    }
}
