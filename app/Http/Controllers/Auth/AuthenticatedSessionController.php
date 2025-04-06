<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user()->fresh();
        $userRole = $user->pluckRoleNames();

        $request->session()->regenerate();

        if ($userRole->contains("managing director") || $userRole->contains("bph")) {
            return redirect()->intended(route('dashboard', ['department' => $user->department->slug], absolute: false));
        } else if ($userRole->contains("supervisor")) {
            return redirect()->intended(route('dashboard.supervisor', absolute: false));
        } else {
            return redirect()->intended();
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
