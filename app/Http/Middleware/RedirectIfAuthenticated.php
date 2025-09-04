<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Check if user has a role assigned
                if (!$user->role) {
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Role tidak ditemukan. Silakan hubungi administrator.');
                }
                
                // Redirect based on user role
                switch ($user->role->name) {
                    case 'Admin':
                        return redirect()->route('admin.dashboard');
                    case 'Pegawai':
                        return redirect()->route('pegawai.dashboard');
                    case 'Warga':
                        return redirect()->route('warga.dashboard');
                    default:
                        return redirect()->route('dashboard');
                }
            }
        }

        return $next($request);
    }
}