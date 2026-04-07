<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Check if admin is active
            if (!Auth::guard('admin')->user()->is_active) {
                Auth::guard('admin')->logout();
                return back()->withErrors([
                    'username' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.',
                ]);
            }

            // Redirect berdasarkan role
            $admin = Auth::guard('admin')->user();
            
            if ($admin->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($admin->isCashier()) {
                return redirect()->intended(route('admin.orders.index'));
            } elseif ($admin->isKitchen()) {
                return redirect()->intended(route('admin.kitchen'));
            }
            
            // Default fallback
            return redirect()->intended(route('admin.history'));
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah logout.');
    }
}
