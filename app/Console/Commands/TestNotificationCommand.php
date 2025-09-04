<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\NotificationHelper;
use App\Models\User;

class TestNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:test {type=all : Type of test (user|role|all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test notification system by sending sample notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        
        $this->info('Testing notification system...');
        
        switch ($type) {
            case 'user':
                $this->testUserNotification();
                break;
            case 'role':
                $this->testRoleNotification();
                break;
            case 'all':
                $this->testAllNotifications();
                break;
            default:
                $this->error('Invalid test type. Use: user, role, or all');
                return 1;
        }
        
        $this->info('Notification test completed!');
        return 0;
    }
    
    private function testUserNotification()
    {
        $this->info('Testing user-specific notification...');
        
        $user = User::first();
        if (!$user) {
            $this->error('No users found in database.');
            return;
        }
        
        $result = NotificationHelper::sendToUser(
             $user->id,
             'Test Notification',
             'This is a test notification sent to a specific user.',
             'high',
             null
         );
        
        if ($result) {
            $this->info("✓ Notification sent to user: {$user->name} ({$user->email})");
        } else {
            $this->error('Failed to send notification to user.');
        }
    }
    
    private function testRoleNotification()
    {
        $this->info('Testing role-based notification...');
        
        $result = NotificationHelper::sendToRole(
             'admin',
             'Admin Test Notification',
             'This is a test notification sent to all admin users.',
             'medium',
             '/admin/dashboard'
         );
        
        if ($result) {
            $this->info('✓ Notification sent to all admin users.');
        } else {
            $this->error('Failed to send notification to admin role.');
        }
    }
    
    private function testAllNotifications()
    {
        $this->info('Testing all notification types...');
        
        // Test user notification
        $this->testUserNotification();
        
        // Test role notification
        $this->testRoleNotification();
        
        // Test broadcast notification
        $this->info('Testing broadcast notification...');
        $result = NotificationHelper::sendToAll(
             'System Announcement',
             'This is a test system-wide announcement.',
             'low',
             '/announcements'
         );
        
        if ($result) {
            $this->info('✓ Broadcast notification sent to all users.');
        } else {
            $this->error('Failed to send broadcast notification.');
        }
        
        // Display statistics
        $this->displayStatistics();
    }
    
    private function displayStatistics()
    {
        $this->info('\nNotification Statistics:');
        
        $totalUsers = User::count();
        $totalNotifications = \App\Models\Notification::count();
        $unreadNotifications = \App\Models\Notification::whereNull('read_at')->count();
        
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Users', $totalUsers],
                ['Total Notifications', $totalNotifications],
                ['Unread Notifications', $unreadNotifications],
                ['Read Notifications', $totalNotifications - $unreadNotifications]
            ]
        );
        
        // Show recent notifications
        $recentNotifications = \App\Models\Notification::with('user', 'sender')
            ->latest()
            ->take(5)
            ->get();
            
        if ($recentNotifications->count() > 0) {
            $this->info('\nRecent Notifications:');
            $data = [];
            foreach ($recentNotifications as $notification) {
                $data[] = [
                    $notification->title,
                    $notification->user->name ?? 'N/A',
                    $notification->sender->name ?? 'System',
                    $notification->read_at ? 'Read' : 'Unread',
                    $notification->created_at->diffForHumans()
                ];
            }
            
            $this->table(
                ['Title', 'Recipient', 'Sender', 'Status', 'Created'],
                $data
            );
        }
    }
}
