<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Show the about page.
     */
    public function about(): View
    {
        return view('frontend.about');
    }

    /**
     * Show the contact page.
     */
    public function contact(): View
    {
        return view('frontend.contact');
    }

    /**
     * Handle contact form submission.
     */
    public function sendContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'nullable|string|max:30',
            'message'   => 'required|string|min:10',
        ]);

        Log::info('Contact form submission', $validated);

        return back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }
}
