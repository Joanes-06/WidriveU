<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the profile edit page.
     */
    public function edit(): View
    {
        return view('customer.profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update general information (name, email, phone, address).
     */
    public function updateInfo(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return back()->with('success_info', 'Informations mises à jour avec succès.');
    }

    /**
     * Update the password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Le mot de passe actuel est incorrect.',
            'password.confirmed'                => 'La confirmation du nouveau mot de passe ne correspond pas.',
            'password.min'                      => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success_password', 'Mot de passe mis à jour avec succès.');
    }
}
