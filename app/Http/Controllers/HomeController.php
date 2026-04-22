<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the homepage with available vehicles.
     */
    public function index(): View
    {
        $vehicles = Vehicle::disponible()->latest()->take(6)->get();

        return view('frontend.home', compact('vehicles'));
    }
}
