<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get notifications for authenticated user
     */
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        $notifications = Notification::forUser($user->id)
            ->with(['sender:id,name,email'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
            
        $unreadCount = Notification::forUser($user->id)
            ->unread()
            ->count();
            
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }
    
    /**
     * Get unread notifications count
     */
    public function unreadCount(): JsonResponse
    {
        $user = Auth::user();
        
        $count = Notification::forUser($user->id)
            ->unread()
            ->count();
            
        return response()->json([
            'unread_count' => $count
        ]);
    }
    
    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, $id): JsonResponse
    {
        $user = Auth::user();
        
        $notification = Notification::forUser($user->id)
            ->findOrFail($id);
            
        $notification->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }
    
    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        Notification::forUser($user->id)
            ->unread()
            ->update(['read_at' => now()]);
            
        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }
    
    /**
     * Delete notification
     */
    public function destroy($id): JsonResponse
    {
        $user = Auth::user();
        
        $notification = Notification::forUser($user->id)
            ->findOrFail($id);
            
        $notification->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification deleted'
        ]);
    }
    
    /**
     * Create notification (for system use)
     */
    public static function createNotification($userId, $senderId, $type, $title, $message, $priority = 'medium', $data = null, $actionUrl = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'sender_id' => $senderId,
            'type' => $type,
            'priority' => $priority,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'action_url' => $actionUrl
        ]);
    }
    
    /**
     * Send notification to specific user
     */
    public function sendNotification(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'in:low,medium,high,urgent',
            'action_url' => 'nullable|string'
        ]);
        
        $sender = Auth::user();
        
        $notification = self::createNotification(
            $request->user_id,
            $sender->id,
            $request->type,
            $request->title,
            $request->message,
            $request->priority ?? 'medium',
            null,
            $request->action_url
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Notification sent successfully',
            'notification' => $notification
        ]);
    }
    
    /**
     * Send notification to multiple users by role
     */
    public function sendToRole(Request $request): JsonResponse
    {
        $request->validate([
            'role' => 'required|string',
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'in:low,medium,high,urgent'
        ]);
        
        $sender = Auth::user();
        
        $users = \App\Models\User::whereHas('role', function($query) use ($request) {
            $query->where('name', $request->role);
        })->get();
        
        $notifications = [];
        foreach ($users as $user) {
            $notifications[] = self::createNotification(
                $user->id,
                $sender->id,
                $request->type,
                $request->title,
                $request->message,
                $request->priority ?? 'medium'
            );
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Notifications sent to ' . count($notifications) . ' users',
            'count' => count($notifications)
        ]);
    }
    
    /**
     * Create notification for all admin users
     */
    public static function notifyAdmins($senderId, $type, $title, $message, $priority = 'medium', $data = null, $actionUrl = null)
    {
        $adminUsers = \App\Models\User::whereHas('role', function($query) {
            $query->whereIn('name', ['admin', 'pegawai']);
        })->get();
        
        foreach ($adminUsers as $admin) {
            self::createNotification($admin->id, $senderId, $type, $title, $message, $priority, $data, $actionUrl);
        }
    }
    
    /**
     * Notify all users
     */
    public static function notifyAllUsers($senderId, $type, $title, $message, $priority = 'medium', $data = null, $actionUrl = null)
    {
        $users = \App\Models\User::all();
        
        foreach ($users as $user) {
            self::createNotification($user->id, $senderId, $type, $title, $message, $priority, $data, $actionUrl);
        }
    }
}