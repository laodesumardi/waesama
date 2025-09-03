<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleries = [
            [
                'title' => 'Kegiatan Pelayanan Masyarakat',
                'description' => 'Dokumentasi kegiatan pelayanan administrasi kepada masyarakat di kantor camat',
                'image' => 'gallery/sample1.svg',
                'status' => 'active'
            ],
            [
                'title' => 'Rapat Koordinasi Bulanan',
                'description' => 'Rapat koordinasi rutin bulanan dengan seluruh staff dan kepala desa',
                'image' => 'gallery/sample2.svg',
                'status' => 'active'
            ],
            [
                'title' => 'Program Pemberdayaan Masyarakat',
                'description' => 'Kegiatan sosialisasi program pemberdayaan masyarakat di tingkat kecamatan',
                'image' => 'gallery/sample3.svg',
                'status' => 'active'
            ]
        ];

        foreach ($galleries as $gallery) {
            Gallery::create($gallery);
        }
    }
}