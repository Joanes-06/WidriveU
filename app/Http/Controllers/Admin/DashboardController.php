<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with stats.
     */
    public function index(): View
    {
        // Vehicle stats
        $vehiclesTotal = Vehicle::count();
        $vehiclesAvailable = Vehicle::where('status', 'disponible')->count();
        $vehiclesReserved = Vehicle::where('status', 'reservee')->count();
        $vehiclesMaintenance = Vehicle::where('status', 'maintenance')->count();

        // Client stats
        $clientsCount = User::where('role', 'client')->count();

        // Reservation stats
        $reservationsActive = Reservation::where('status', 'active')->count();
        $reservationsTotal = Reservation::count();
        $reservationsWithDiscount = Reservation::where('discount_percentage', '>', 0)->count();

        // Financial stats (current month)
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $monthlyRevenue = Reservation::whereIn('status', ['active', 'completed'])
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total');

        $monthlyDiscounts = Reservation::whereIn('status', ['active', 'completed'])
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('discount_amount');

        $avgReservationDays = Reservation::whereIn('status', ['active', 'completed'])
            ->avg('days') ?? 0;

        $avgReservationValue = Reservation::whereIn('status', ['active', 'completed'])
            ->avg('total') ?? 0;

        // Occupancy rate
        $occupancyRate = $vehiclesTotal > 0
            ? round(($vehiclesReserved / $vehiclesTotal) * 100, 1)
            : 0;

        // Chart data: chauffeur vs sans chauffeur
        $chauffeurCount = Reservation::where('type', 'avec_chauffeur')->count();
        $sansChauffeurCount = Reservation::where('type', 'sans_chauffeur')->count();

        // Discount tiers breakdown
        $discountTiers = [
            'none'       => Reservation::where('discount_percentage', 0)->count(),
            'tier_7'     => Reservation::where('discount_percentage', 15)->count(),
            'tier_14'    => Reservation::where('discount_percentage', 18)->count(),
            'tier_21'    => Reservation::where('discount_percentage', 20)->count(),
        ];

        // Monthly chart data (last 12 months)
        $chartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartData[] = [
                'month'    => $date->translatedFormat('M Y'),
                'revenue'  => Reservation::whereIn('status', ['active', 'completed'])
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->sum('total'),
                'count'    => Reservation::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count(),
            ];
        }

        $recentVehicles = Vehicle::latest()->take(6)->get();
        $recentReservations = Reservation::with(['user', 'vehicle'])
            ->latest()->take(5)->get();

        return view('admin.dashboard', [
            'vehiclesTotal'            => $vehiclesTotal,
            'vehiclesAvailable'        => $vehiclesAvailable,
            'vehiclesReserved'         => $vehiclesReserved,
            'vehiclesMaintenance'      => $vehiclesMaintenance,
            'clientsCount'             => $clientsCount,
            'reservationsActive'       => $reservationsActive,
            'reservationsTotal'        => $reservationsTotal,
            'reservationsWithDiscount' => $reservationsWithDiscount,
            'monthlyRevenue'           => $monthlyRevenue,
            'monthlyDiscounts'         => $monthlyDiscounts,
            'avgReservationDays'       => round($avgReservationDays, 1),
            'avgReservationValue'      => round($avgReservationValue),
            'occupancyRate'            => $occupancyRate,
            'chauffeurCount'           => $chauffeurCount,
            'sansChauffeurCount'       => $sansChauffeurCount,
            'discountTiers'            => $discountTiers,
            'chartData'                => $chartData,
            'recentVehicles'           => $recentVehicles,
            'recentReservations'       => $recentReservations,
        ]);
    }
}
