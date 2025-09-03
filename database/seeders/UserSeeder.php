<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@camat.go.id',
            'role' => 'admin',
            'phone' => '081234567890',
            'employee_id' => 'ADM001',
            'position' => 'Administrator Sistem',
            'department' => 'IT',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Camat (Admin)
        User::create([
            'name' => 'Dr. Ahmad Suryadi, S.Sos, M.Si',
            'email' => 'camat@camat.go.id',
            'role' => 'admin',
            'phone' => '081234567891',
            'employee_id' => 'CAM001',
            'position' => 'Camat',
            'department' => 'Pimpinan',
            'password' => Hash::make('camat123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Sekretaris Camat (Pegawai)
        User::create([
            'name' => 'Siti Nurhaliza, S.AP',
            'email' => 'sekretaris@camat.go.id',
            'role' => 'pegawai',
            'phone' => '081234567892',
            'employee_id' => 'SEK001',
            'position' => 'Sekretaris Camat',
            'department' => 'Sekretariat',
            'password' => Hash::make('sekretaris123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Staff Kependudukan (Pegawai)
        User::create([
            'name' => 'Budi Santoso, S.Kom',
            'email' => 'kependudukan@camat.go.id',
            'role' => 'pegawai',
            'phone' => '081234567893',
            'employee_id' => 'KPD001',
            'position' => 'Staff Kependudukan',
            'department' => 'Pelayanan',
            'password' => Hash::make('kependudukan123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Contoh user masyarakat
        User::create([
            'name' => 'Andi Wijaya',
            'email' => 'andi.wijaya@gmail.com',
            'role' => 'masyarakat',
            'phone' => '081234567894',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Sari Dewi',
            'email' => 'sari.dewi@gmail.com',
            'role' => 'masyarakat',
            'phone' => '081234567895',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
    }
}
