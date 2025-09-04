<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\ServiceRequest;
use App\Models\User;

class NotificationService
{
    /**
     * Create notification for service request status change.
     */
    public function createStatusChangeNotification(ServiceRequest $serviceRequest, string $oldStatus, string $newStatus)
    {
        $statusMessages = [
            'pending' => 'Permohonan Anda sedang menunggu review',
            'processing' => 'Permohonan Anda sedang diproses',
            'approved' => 'Permohonan Anda telah disetujui',
            'rejected' => 'Permohonan Anda ditolak',
            'completed' => 'Permohonan Anda telah selesai diproses'
        ];

        $title = 'Status Permohonan Berubah';
        $message = $statusMessages[$newStatus] ?? 'Status permohonan Anda telah berubah';
        
        $actionUrl = route('admin.service-requests.show', $serviceRequest->id);
        
        // Determine if notification is important
        $isImportant = in_array($newStatus, ['approved', 'rejected', 'completed']);

        return Notification::create([
            'user_id' => $serviceRequest->citizen->user_id,
            'service_request_id' => $serviceRequest->id,
            'type' => 'status_change',
            'title' => $title,
            'message' => $message,
            'data' => [
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'service_type' => $serviceRequest->service_type,
                'request_number' => $serviceRequest->request_number
            ],
            'is_important' => $isImportant,
            'action_url' => $actionUrl
        ]);
    }

    /**
     * Create notification when document is ready.
     * (Disabled - Document model not available)
     */
    // public function createDocumentReadyNotification(ServiceRequest $serviceRequest, $document)
    // {
    //     $title = 'Dokumen Siap Diunduh';
    //     $message = "Dokumen untuk permohonan {$serviceRequest->service_type} Anda sudah siap dan dapat diunduh.";
    //     
    //     $actionUrl = route('admin.documents.download', $document->id);

    //     return Notification::create([
    //         'user_id' => $serviceRequest->citizen->user_id,
    //         'service_request_id' => $serviceRequest->id,
    //         'type' => 'document_ready',
    //         'title' => $title,
    //         'message' => $message,
    //         'data' => [
    //             'document_id' => $document->id,
    //             'document_name' => $document->file_name,
    //             'service_type' => $serviceRequest->service_type,
    //             'request_number' => $serviceRequest->request_number
    //         ],
    //         'is_important' => true,
    //         'action_url' => $actionUrl
    //     ]);
    // }

    /**
     * Create notification for bulk status changes.
     */
    public function createBulkStatusChangeNotifications(array $serviceRequests, string $newStatus)
    {
        $notifications = [];
        
        foreach ($serviceRequests as $serviceRequest) {
            $oldStatus = $serviceRequest->status;
            if ($oldStatus !== $newStatus) {
                $notifications[] = $this->createStatusChangeNotification($serviceRequest, $oldStatus, $newStatus);
            }
        }
        
        return $notifications;
    }

    /**
     * Get unread notifications count for user.
     */
    public function getUnreadCount(User $user)
    {
        return $user->notifications()->unread()->count();
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        return $notification->markAsRead();
    }

    /**
     * Mark all notifications as read for user.
     */
    public function markAllAsRead(User $user)
    {
        return $user->notifications()->unread()->update(['read_at' => now()]);
    }

    /**
     * Get recent notifications for user.
     */
    public function getRecentNotifications(User $user, int $limit = 10)
    {
        return $user->notifications()
            ->with(['serviceRequest'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Delete old notifications (older than specified days).
     */
    public function deleteOldNotifications(int $days = 30)
    {
        return Notification::where('created_at', '<', now()->subDays($days))->delete();
    }

    /**
     * Create notification for new service request to all staff.
     */
    public function createNewServiceRequestNotification(ServiceRequest $serviceRequest)
    {
        $title = "Pengajuan Surat Baru";
        $message = "Pengajuan surat baru #{$serviceRequest->request_number} dari {$serviceRequest->citizen->name} untuk layanan {$serviceRequest->service_type}";
        
        // Get all users with roles: admin, pegawai, and camat
        $staffUsers = User::whereIn('role', ['admin', 'pegawai', 'camat'])->get();
        
        $notifications = [];
        
        foreach ($staffUsers as $staff) {
            $notifications[] = Notification::create([
                'user_id' => $staff->id,
                'service_request_id' => $serviceRequest->id,
                'type' => 'new_service_request',
                'title' => $title,
                'message' => $message,
                'data' => [
                    'service_request_id' => $serviceRequest->id,
                    'request_number' => $serviceRequest->request_number,
                    'service_type' => $serviceRequest->service_type,
                    'citizen_name' => $serviceRequest->citizen->name,
                    'citizen_nik' => $serviceRequest->citizen->nik
                ],
                'is_important' => true,
                'action_url' => route('admin.service-requests.show', $serviceRequest->id)
            ]);
        }
        
        return $notifications;
    }

    /**
     * Create notification for service request processing to citizen.
     */
    public function createServiceRequestProcessNotification(ServiceRequest $serviceRequest, string $oldStatus, string $newStatus, User $processedBy)
    {
        $statusMessages = [
            'pending' => 'Permohonan Anda sedang menunggu review',
            'processing' => 'Permohonan Anda sedang diproses',
            'approved' => 'Permohonan Anda telah disetujui',
            'rejected' => 'Permohonan Anda ditolak',
            'completed' => 'Permohonan Anda telah selesai diproses'
        ];

        $statusLabels = [
            'pending' => 'Menunggu',
            'processing' => 'Diproses', 
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai'
        ];

        $title = 'Status Pengajuan Surat Diperbarui';
        $message = "Pengajuan surat #{$serviceRequest->request_number} telah diubah dari {$statusLabels[$oldStatus]} menjadi {$statusLabels[$newStatus]} oleh {$processedBy->name}";
        
        // Determine if notification is important
        $isImportant = in_array($newStatus, ['approved', 'rejected', 'completed']);
        
        // Get citizen's user_id
        $citizenUserId = $serviceRequest->citizen->user_id ?? null;
        
        if ($citizenUserId) {
            return Notification::create([
                'user_id' => $citizenUserId,
                'service_request_id' => $serviceRequest->id,
                'type' => 'service_request_processed',
                'title' => $title,
                'message' => $message,
                'data' => [
                    'service_request_id' => $serviceRequest->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'request_number' => $serviceRequest->request_number,
                    'service_type' => $serviceRequest->service_type,
                    'processed_by' => $processedBy->name,
                    'processed_by_role' => $processedBy->role
                ],
                'is_important' => $isImportant,
                'action_url' => route('warga.service-requests.show', $serviceRequest->id)
            ]);
        }
        
        return null;
    }
}