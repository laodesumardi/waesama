<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationHelper
{
    /**
     * Send notification to a specific user
     */
    public static function sendToUser($userId, $title, $message, $priority = 'medium', $actionUrl = null, $senderId = null)
    {
        $senderId = $senderId ?? Auth::id();
        
        return Notification::create([
            'user_id' => $userId,
            'sender_id' => $senderId,
            'type' => 'user_notification',
            'title' => $title,
            'message' => $message,
            'priority' => $priority,
            'action_url' => $actionUrl,
            'data' => json_encode([
                'sender_id' => $senderId,
                'timestamp' => now()->toISOString()
            ])
        ]);
    }

    /**
     * Send notification to users with specific role
     */
    public static function sendToRole($role, $title, $message, $priority = 'medium', $actionUrl = null, $senderId = null)
    {
        $senderId = $senderId ?? Auth::id();
        $users = User::whereHas('role', function($query) use ($role) {
            $query->where('name', $role);
        })->get();
        
        $notifications = [];
        foreach ($users as $user) {
            $notifications[] = [
                'user_id' => $user->id,
                'sender_id' => $senderId,
                'type' => 'role_notification',
                'title' => $title,
                'message' => $message,
                'priority' => $priority,
                'action_url' => $actionUrl,
                'data' => json_encode([
                    'sender_id' => $senderId,
                    'role' => $role,
                    'timestamp' => now()->toISOString()
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        
        if (!empty($notifications)) {
            Notification::insert($notifications);
        }
        
        return count($notifications);
    }

    /**
     * Send notification to all admins
     */
    public static function notifyAdmins($title, $message, $priority = 'high', $actionUrl = null, $senderId = null)
    {
        return self::sendToRole('admin', $title, $message, $priority, $actionUrl, $senderId);
    }

    /**
     * Send notification to all staff
     */
    public static function notifyStaff($title, $message, $priority = 'medium', $actionUrl = null, $senderId = null)
    {
        return self::sendToRole('pegawai', $title, $message, $priority, $actionUrl, $senderId);
    }

    /**
     * Send notification to all users (warga)
     */
    public static function notifyUsers($title, $message, $priority = 'medium', $actionUrl = null, $senderId = null)
    {
        return self::sendToRole('warga', $title, $message, $priority, $actionUrl, $senderId);
    }

    /**
     * Send notification to all users regardless of role
     */
    public static function sendToAll($title, $message, $priority = 'medium', $actionUrl = null, $senderId = null)
    {
        return self::notifyAll($title, $message, $priority, $actionUrl, $senderId);
    }
    
    /**
     * Send notification to all users regardless of role
     */
    public static function notifyAll($title, $message, $priority = 'medium', $actionUrl = null, $senderId = null)
    {
        $senderId = $senderId ?? Auth::id();
        $users = User::all();
        
        $notifications = [];
        foreach ($users as $user) {
            $notifications[] = [
                'user_id' => $user->id,
                'sender_id' => $senderId,
                'type' => 'broadcast_notification',
                'title' => $title,
                'message' => $message,
                'priority' => $priority,
                'action_url' => $actionUrl,
                'data' => json_encode([
                    'sender_id' => $senderId,
                    'broadcast' => true,
                    'timestamp' => now()->toISOString()
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        
        if (!empty($notifications)) {
            Notification::insert($notifications);
        }
        
        return count($notifications);
    }

    /**
     * Create system notification (no sender)
     */
    public static function systemNotification($userId, $title, $message, $priority = 'medium', $actionUrl = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'sender_id' => null,
            'type' => 'system_notification',
            'title' => $title,
            'message' => $message,
            'priority' => $priority,
            'action_url' => $actionUrl,
            'data' => json_encode([
                'system' => true,
                'timestamp' => now()->toISOString()
            ])
        ]);
    }

    /**
     * Get unread notification count for user
     */
    public static function getUnreadCount($userId = null)
    {
        $userId = $userId ?? Auth::id();
        return Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->count();
    }

    /**
     * Mark notification as read
     */
    public static function markAsRead($notificationId, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        return Notification::where('id', $notificationId)
            ->where('user_id', $userId)
            ->update(['read_at' => now()]);
    }

    /**
     * Mark all notifications as read for user
     */
    public static function markAllAsRead($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        return Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Delete notification
     */
    public static function deleteNotification($notificationId, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        return Notification::where('id', $notificationId)
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * Get recent notifications for user
     */
    public static function getRecentNotifications($userId = null, $limit = 10)
    {
        $userId = $userId ?? Auth::id();
        
        return Notification::where('user_id', $userId)
            ->with(['sender:id,name,email'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Notification types for different actions
     */
    public static function notifyNewSurat($suratId, $pemohonName)
    {
        $title = 'Permohonan Surat Baru';
        $message = "Permohonan surat baru dari {$pemohonName} telah diterima dan menunggu verifikasi.";
        $actionUrl = route('admin.surat.show', $suratId);
        
        return self::notifyAdmins($title, $message, 'high', $actionUrl);
    }

    public static function notifyNewPengaduan($pengaduanId, $pengaduName)
    {
        $title = 'Pengaduan Baru';
        $message = "Pengaduan baru dari {$pengaduName} telah diterima dan memerlukan tindak lanjut.";
        $actionUrl = route('admin.pengaduan.show', $pengaduanId);
        
        return self::notifyAdmins($title, $message, 'high', $actionUrl);
    }

    public static function notifyStatusUpdate($userId, $type, $status, $itemId)
    {
        $typeNames = [
            'surat' => 'surat',
            'pengaduan' => 'pengaduan',
            'antrian' => 'antrian'
        ];
        
        $statusNames = [
            'approved' => 'disetujui',
            'rejected' => 'ditolak',
            'completed' => 'selesai',
            'processing' => 'sedang diproses'
        ];
        
        $typeName = $typeNames[$type] ?? $type;
        $statusName = $statusNames[$status] ?? $status;
        
        $title = 'Update Status ' . ucfirst($typeName);
        $message = "Status {$typeName} Anda telah {$statusName}.";
        $actionUrl = route("warga.{$type}.show", $itemId);
        
        return self::sendToUser($userId, $title, $message, 'medium', $actionUrl);
    }

    public static function notifyNewBerita($beritaId, $judul)
    {
        $title = 'Berita Terbaru';
        $message = "Berita baru telah dipublikasikan: {$judul}";
        $actionUrl = route('berita.show', $beritaId);
        
        return self::notifyAll($title, $message, 'low', $actionUrl);
    }
}