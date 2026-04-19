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
     * Single Login logic for all staff (admin, kitchen, cashier)
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

            // Redirect based on role
            $admin = Auth::guard('admin')->user();

            return $this->redirectBasedOnRole($admin);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Redirect based on role
     */
    private function redirectBasedOnRole($admin): \Illuminate\Http\RedirectResponse
    {
        if ($admin->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($admin->isCashier()) {
            return redirect()->intended(route('admin.orders.index'));
        } elseif ($admin->isKitchen()) {
            return redirect()->intended(route('admin.kitchen'));
        }

        return redirect()->intended(route('admin.history'));
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