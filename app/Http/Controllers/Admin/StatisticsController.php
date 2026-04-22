<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    /**
     * Show the statistics page with 12 months of data.
     */
    public function index(): View
    {
        $months = [];
        $reservationsPerMonth = [];
        $revenuePerMonth = [];
        $discountsPerMonth = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabel = $date->translatedFormat('M Y');

            $months[] = $monthLabel;

            $reservationsPerMonth[] = Reservation::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();

            $revenuePerMonth[] = (int) Reservation::whereIn('status', ['active', 'completed'])
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total');

            $discountsPerMonth[] = (int) Reservation::whereIn('status', ['active', 'completed'])
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('discount_amount');
        }

        return view('admin.statistics.index', compact(
            'months',
            'reservationsPerMonth',
            'revenuePerMonth',
            'discountsPerMonth'
        ));
    }
}
