<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the customer dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();

        $activeCount = $user->reservations()->where('status', 'active')->count();
        $totalCount  = $user->reservations()->count();
        $totalSpent  = $user->reservations()
            ->whereIn('status', ['active', 'completed'])
            ->sum('total');
        $totalDays   = $user->reservations()
            ->whereIn('status', ['active', 'completed'])
            ->sum('days');

        $activeReservations = $user->reservations()
            ->with(['vehicle', 'zone'])
            ->where('status', 'active')
            ->get();

        $lastReservations = $user->reservations()
            ->with(['vehicle', 'zone'])
            ->latest()
            ->take(6)
            ->get();

        return view('customer.dashboard', compact(
            'activeCount',
            'totalCount',
            'totalSpent',
            'totalDays',
            'activeReservations',
            'lastReservations'
        ));
    }
}
