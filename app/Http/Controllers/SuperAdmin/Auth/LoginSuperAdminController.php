<?php

namespace App\Http\Controllers\SuperAdmin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SuperAdminLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginSuperAdminController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('superadmin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(SuperAdminLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('superadmin.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('superadmin')->logout();

        $request->session()->regenerateToken();

        return redirect()->route('superadmin.login');
    }
}