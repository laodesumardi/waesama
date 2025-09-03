<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use App\Models\User;

class ActivityLogMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Handle logout before processing the request
        if ($request->routeIs('logout') && Auth::check()) {
            $user = Auth::user();
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'user_logout',
                'description' => "Pengguna {$user->name} logout dari sistem",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'properties' => json_encode([
                    'logout_time' => now()->toDateTimeString()
                ])
            ]);
        }
        
        $response = $next($request);
        
        // Handle login after processing the request
        if ($request->routeIs('login') && Auth::check()) {
            $user = Auth::user();
            
            // Update last login time
            $user->update(['last_login_at' => now()]);
            
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'user_login',
                'description' => "Pengguna {$user->name} login ke sistem",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'properties' => json_encode([
                    'login_time' => now()->toDateTimeString(),
                    'role' => $user->role
                ])
            ]);
        }
        
        return $response;
    }
}