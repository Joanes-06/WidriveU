<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ZoneController extends Controller
{
    public function index(): View
    {
        $zones = Zone::withCount('reservations')->latest()->get();
        return view('admin.zones.index', compact('zones'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string|max:255|unique:zones,name']);
        Zone::create(['name' => $request->name]);
        return back()->with('success', 'Zone créée avec succès.');
    }

    public function update(Request $request, Zone $zone): RedirectResponse
    {
        $request->validate(['name' => 'required|string|max:255|unique:zones,name,' . $zone->id]);
        $zone->update(['name' => $request->name]);
        return back()->with('success', 'Zone mise à jour.');
    }

    public function destroy(Zone $zone): RedirectResponse
    {
        if ($zone->reservations()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : cette zone est liée à des réservations.');
        }
        $zone->delete();
        return back()->with('success', 'Zone supprimée.');
    }
}
