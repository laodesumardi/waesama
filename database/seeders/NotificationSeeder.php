<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use App\Helpers\NotificationHelper;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users for testing
        $admin = User::whereHas('role', function($query) {
            $query->where('name', 'admin');
        })->first();
        $pegawai = User::whereHas('role', function($query) {
            $query->where('name', 'pegawai');
        })->first();
        $warga = User::whereHas('role', function($query) {
            $query->where('name', 'warga');
        })->first();
        
        if (!$admin || !$pegawai || !$warga) {
            $this->command->error('Please run UserSeeder first to create test users.');
            return;
        }
        
        // Create sample notifications
        $notifications = [
            [
                'user_id' => $admin->id,
                'sender_id' => $pegawai->id,
                'type' => 'system_notification',
                'title' => 'Permohonan Surat Baru',
                'message' => 'Ada permohonan surat keterangan domisili baru yang memerlukan persetujuan Anda.',
                'priority' => 'high',
                'action_url' => '/admin/surat',
                'data' => json_encode(['type' => 'surat', 'id' => 1]),
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2)
            ],
            [
                'user_id' => $admin->id,
                'sender_id' => null,
                'type' => 'system_notification',
                'title' => 'Pengaduan Baru',
                'message' => 'Pengaduan mengenai fasilitas umum telah diterima dan memerlukan tindak lanjut.',
                'priority' => 'medium',
                'action_url' => '/admin/pengaduan',
                'data' => json_encode(['type' => 'pengaduan', 'id' => 1]),
                'created_at' => now()->subHours(1),
                'updated_at' => now()->subHours(1)
            ],
            [
                'user_id' => $warga->id,
                'sender_id' => $admin->id,
                'type' => 'status_update',
                'title' => 'Status Surat Diperbarui',
                'message' => 'Permohonan surat keterangan domisili Anda telah disetujui dan sedang diproses.',
                'priority' => 'medium',
                'action_url' => '/warga/surat',
                'data' => json_encode(['type' => 'surat', 'status' => 'approved']),
                'created_at' => now()->subMinutes(30),
                'updated_at' => now()->subMinutes(30)
            ],
            [
                'user_id' => $pegawai->id,
                'sender_id' => $admin->id,
                'type' => 'task_assignment',
                'title' => 'Tugas Baru',
                'message' => 'Anda telah ditugaskan untuk memproses permohonan surat keterangan usaha.',
                'priority' => 'high',
                'action_url' => '/pegawai/surat',
                'data' => json_encode(['type' => 'assignment', 'task_id' => 1]),
                'created_at' => now()->subMinutes(15),
                'updated_at' => now()->subMinutes(15)
            ],
            [
                'user_id' => $warga->id,
                'sender_id' => null,
                'type' => 'announcement',
                'title' => 'Berita Terbaru',
                'message' => 'Pengumuman: Jadwal pelayanan kantor camat akan berubah mulai minggu depan.',
                'priority' => 'low',
                'action_url' => '/berita',
                'data' => json_encode(['type' => 'announcement']),
                'read_at' => now()->subMinutes(5),
                'created_at' => now()->subMinutes(10),
                'updated_at' => now()->subMinutes(5)
            ],
            [
                'user_id' => $admin->id,
                'sender_id' => $warga->id,
                'type' => 'feedback',
                'title' => 'Feedback Layanan',
                'message' => 'Terima kasih atas pelayanan yang memuaskan. Proses surat sangat cepat dan efisien.',
                'priority' => 'low',
                'action_url' => null,
                'data' => json_encode(['type' => 'feedback', 'rating' => 5]),
                'created_at' => now()->subMinutes(5),
                'updated_at' => now()->subMinutes(5)
            ]
        ];
        
        foreach ($notifications as $notification) {
            Notification::create($notification);
        }
        
        $this->command->info('Sample notifications created successfully!');
        $this->command->info('Created ' . count($notifications) . ' notifications for testing.');
    }
}
