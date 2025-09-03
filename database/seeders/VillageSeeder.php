<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Village;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $villages = [
            [
                'code' => '001',
                'name' => 'Desa Maju Jaya',
                'head_name' => 'Budi Santoso',
                'head_phone' => '081234567890',
                'area_size' => 15.75,
                'population_count' => 2500,
                'description' => 'Desa dengan potensi pertanian yang baik',
                'boundaries' => [
                    'utara' => 'Desa Sejahtera',
                    'selatan' => 'Desa Makmur',
                    'timur' => 'Sungai Brantas',
                    'barat' => 'Jalan Raya Utama'
                ],
                'is_active' => true,
            ],
            [
                'code' => '002',
                'name' => 'Desa Sejahtera',
                'head_name' => 'Siti Aminah',
                'head_phone' => '081234567891',
                'area_size' => 12.30,
                'population_count' => 1800,
                'description' => 'Desa dengan fokus pada peternakan',
                'boundaries' => [
                    'utara' => 'Hutan Lindung',
                    'selatan' => 'Desa Maju Jaya',
                    'timur' => 'Desa Bahagia',
                    'barat' => 'Pegunungan Kawi'
                ],
                'is_active' => true,
            ],
            [
                'code' => '003',
                'name' => 'Desa Makmur',
                'head_name' => 'Ahmad Wijaya',
                'head_phone' => '081234567892',
                'area_size' => 18.45,
                'population_count' => 3200,
                'description' => 'Desa dengan industri kerajinan tangan',
                'boundaries' => [
                    'utara' => 'Desa Maju Jaya',
                    'selatan' => 'Desa Tentram',
                    'timur' => 'Danau Buatan',
                    'barat' => 'Perkebunan Teh'
                ],
                'is_active' => true,
            ],
            [
                'code' => '004',
                'name' => 'Desa Bahagia',
                'head_name' => 'Rina Sari',
                'head_phone' => '081234567893',
                'area_size' => 10.20,
                'population_count' => 1500,
                'description' => 'Desa wisata dengan pemandangan alam',
                'boundaries' => [
                    'utara' => 'Gunung Arjuno',
                    'selatan' => 'Desa Damai',
                    'timur' => 'Lembah Hijau',
                    'barat' => 'Desa Sejahtera'
                ],
                'is_active' => true,
            ],
            [
                'code' => '005',
                'name' => 'Desa Tentram',
                'head_name' => 'Joko Susilo',
                'head_phone' => '081234567894',
                'area_size' => 14.80,
                'population_count' => 2100,
                'description' => 'Desa dengan sektor perdagangan yang berkembang',
                'boundaries' => [
                    'utara' => 'Desa Makmur',
                    'selatan' => 'Kota Kecamatan',
                    'timur' => 'Pasar Tradisional',
                    'barat' => 'Terminal Bus'
                ],
                'is_active' => true,
            ],
            [
                'code' => '006',
                'name' => 'Desa Damai',
                'head_name' => 'Fatimah Zahra',
                'head_phone' => '081234567895',
                'area_size' => 11.65,
                'population_count' => 1650,
                'description' => 'Desa dengan program pemberdayaan masyarakat',
                'boundaries' => [
                    'utara' => 'Desa Bahagia',
                    'selatan' => 'Sungai Kali Mas',
                    'timur' => 'Persawahan',
                    'barat' => 'Jalan Provinsi'
                ],
                'is_active' => true,
            ],
        ];

        foreach ($villages as $village) {
            Village::create($village);
        }
    }
}
