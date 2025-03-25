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

        $request->session()->regenerate();

        $user = Auth::user();
        $userRole = $user->pluckRoleNames();

        if ($userRole->contains("managing director") || $userRole->contains("bph")) {
            $departmentSlug = $user->department->slug;
            return redirect()->intended(route('dashboard', ['slug' => $departmentSlug], absolute: false));
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
