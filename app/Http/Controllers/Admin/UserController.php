<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'client')->withCount('reservations');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%");
            });
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $reservations = $user->reservations()
            ->with(['vehicle', 'zone'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total'     => $user->reservations()->count(),
            'active'    => $user->reservations()->where('status', 'active')->count(),
            'completed' => $user->reservations()->where('status', 'completed')->count(),
            'cancelled' => $user->reservations()->where('status', 'cancelled')->count(),
            'total_spent' => $user->reservations()->whereIn('status', ['active', 'completed'])->sum('total'),
        ];

        return view('admin.users.show', compact('user', 'reservations', 'stats'));
    }
}
