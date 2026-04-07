<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Debug: Log role user
        Log::info('Role Check', [
            'username' => $admin->username,
            'role' => $admin->role,
            'required_roles' => $roles,
        ]);

        // Cek jika role NULL atau kosong
        if (empty($admin->role)) {
            Log::error('User role is empty or NULL', ['username' => $admin->username]);
            abort(403, 'Unauthorized access. Role tidak ter-set. Silakan hubungi administrator.');
        }

        if (!in_array($admin->role, $roles)) {
            Log::error('Access denied - role mismatch', [
                'username' => $admin->username,
                'user_role' => $admin->role,
                'required_roles' => $roles,
            ]);
            abort(403, 'Unauthorized access. You do not have permission to access this page.');
        }

        return $next($request);
    }
}
