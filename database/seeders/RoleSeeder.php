<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'display_name' => 'Administrator',
                'description' => 'Administrator sistem dengan akses penuh ke semua fitur'
            ],
            [
                'name' => 'Pegawai',
                'display_name' => 'Pegawai',
                'description' => 'Pegawai kantor camat yang dapat mengelola layanan masyarakat'
            ],
            [
                'name' => 'Warga',
                'display_name' => 'Warga',
                'description' => 'Warga yang dapat mengakses layanan publik'
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}
