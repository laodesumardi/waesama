<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Helpers\NotificationHelper;
use Symfony\Component\HttpFoundation\Response;

class ShareNotificationData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Share notification data with all views
            View::share([
                'unreadNotificationCount' => NotificationHelper::getUnreadCount(),
                'recentNotifications' => NotificationHelper::getRecentNotifications(null, 5)
            ]);
        }
        
        return $next($request);
    }
}
