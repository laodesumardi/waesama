<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Database\Seeder;

class PendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendudukData = [
            [
                'nik' => '7301010101950001',
                'nama_lengkap' => 'Budi Santoso',
                'tempat_lahir' => 'Waesama',
                'tanggal_lahir' => '1995-07-12',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pendidikan' => 'S1',
                'pekerjaan' => 'Wiraswasta',
                'status_perkawinan' => 'Belum Kawin',
                'kewarganegaraan' => 'WNI',
                'no_kk' => '7301010101950001',
                'hubungan_keluarga' => 'Kepala Keluarga',
                'alamat' => 'Jl. Kenanga No. 45, Desa Waesama',
                'rt' => '001',
                'rw' => '001',
                'desa_kelurahan' => 'Waesama',
                'kecamatan' => 'Waesama',
                'kabupaten_kota' => 'Buru Selatan',
                'provinsi' => 'Maluku',
                'kode_pos' => '97566',
                'status_penduduk' => 'Tetap',
            ],
            [
                'nik' => '7301010101930001',
                'nama_lengkap' => 'Rina Wati',
                'tempat_lahir' => 'Waesama',
                'tanggal_lahir' => '1993-11-25',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'pendidikan' => 'SMA',
                'pekerjaan' => 'Guru',
                'status_perkawinan' => 'Kawin',
                'kewarganegaraan' => 'WNI',
                'no_kk' => '7301010101930001',
                'hubungan_keluarga' => 'Kepala Keluarga',
                'alamat' => 'Jl. Dahlia No. 12, Desa Waesama',
                'rt' => '002',
                'rw' => '001',
                'desa_kelurahan' => 'Waesama',
                'kecamatan' => 'Waesama',
                'kabupaten_kota' => 'Buru Selatan',
                'provinsi' => 'Maluku',
                'kode_pos' => '97566',
                'status_penduduk' => 'Tetap',
            ],
            [
                'nik' => '7301010101920001',
                'nama_lengkap' => 'Joko Widodo',
                'tempat_lahir' => 'Waesama',
                'tanggal_lahir' => '1992-03-15',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pendidikan' => 'SMA',
                'pekerjaan' => 'Petani',
                'status_perkawinan' => 'Kawin',
                'kewarganegaraan' => 'WNI',
                'no_kk' => '7301010101920001',
                'hubungan_keluarga' => 'Kepala Keluarga',
                'alamat' => 'Jl. Melati No. 8, Desa Waesama',
                'rt' => '003',
                'rw' => '002',
                'desa_kelurahan' => 'Waesama',
                'kecamatan' => 'Waesama',
                'kabupaten_kota' => 'Buru Selatan',
                'provinsi' => 'Maluku',
                'kode_pos' => '97566',
                'status_penduduk' => 'Tetap',
            ],
            [
                'nik' => '7301010101940001',
                'nama_lengkap' => 'Sri Mulyani',
                'tempat_lahir' => 'Waesama',
                'tanggal_lahir' => '1994-09-20',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'pendidikan' => 'D3',
                'pekerjaan' => 'Perawat',
                'status_perkawinan' => 'Belum Kawin',
                'kewarganegaraan' => 'WNI',
                'no_kk' => '7301010101940001',
                'hubungan_keluarga' => 'Kepala Keluarga',
                'alamat' => 'Jl. Anggrek No. 22, Desa Waesama',
                'rt' => '004',
                'rw' => '002',
                'desa_kelurahan' => 'Waesama',
                'kecamatan' => 'Waesama',
                'kabupaten_kota' => 'Buru Selatan',
                'provinsi' => 'Maluku',
                'kode_pos' => '97566',
                'status_penduduk' => 'Tetap',
            ],
            [
                'nik' => '7301010101910001',
                'nama_lengkap' => 'Agus Salim',
                'tempat_lahir' => 'Waesama',
                'tanggal_lahir' => '1991-12-05',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pendidikan' => 'SMA',
                'pekerjaan' => 'Nelayan',
                'status_perkawinan' => 'Kawin',
                'kewarganegaraan' => 'WNI',
                'no_kk' => '7301010101910001',
                'hubungan_keluarga' => 'Kepala Keluarga',
                'alamat' => 'Jl. Mawar No. 15, Desa Waesama',
                'rt' => '005',
                'rw' => '003',
                'desa_kelurahan' => 'Waesama',
                'kecamatan' => 'Waesama',
                'kabupaten_kota' => 'Buru Selatan',
                'provinsi' => 'Maluku',
                'kode_pos' => '97566',
                'status_penduduk' => 'Tetap',
            ],
            // Additional residents without user accounts
            [
                'nik' => '7301010101960001',
                'nama_lengkap' => 'Sari Dewi',
                'tempat_lahir' => 'Waesama',
                'tanggal_lahir' => '1996-04-18',
                'jenis_kelamin' => 'P',
                'agama' => 'Kristen',
                'pendidikan' => 'SMA',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'status_perkawinan' => 'Kawin',
                'kewarganegaraan' => 'WNI',
                'no_kk' => '7301010101960001',
                'hubungan_keluarga' => 'Istri',
                'alamat' => 'Jl. Cempaka No. 30, Desa Waesama',
                'rt' => '006',
                'rw' => '003',
                'desa_kelurahan' => 'Waesama',
                'kecamatan' => 'Waesama',
                'kabupaten_kota' => 'Buru Selatan',
                'provinsi' => 'Maluku',
                'kode_pos' => '97566',
                'status_penduduk' => 'Tetap',
            ],
            [
                'nik' => '7301010101970001',
                'nama_lengkap' => 'Ahmad Fauzi',
                'tempat_lahir' => 'Waesama',
                'tanggal_lahir' => '1997-08-10',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pendidikan' => 'SMP',
                'pekerjaan' => 'Buruh',
                'status_perkawinan' => 'Belum Kawin',
                'kewarganegaraan' => 'WNI',
                'no_kk' => '7301010101970001',
                'hubungan_keluarga' => 'Anak',
                'alamat' => 'Jl. Flamboyan No. 7, Desa Waesama',
                'rt' => '007',
                'rw' => '004',
                'desa_kelurahan' => 'Waesama',
                'kecamatan' => 'Waesama',
                'kabupaten_kota' => 'Buru Selatan',
                'provinsi' => 'Maluku',
                'kode_pos' => '97566',
                'status_penduduk' => 'Tetap',
            ],
        ];

        foreach ($pendudukData as $data) {
            Penduduk::firstOrCreate(
                ['nik' => $data['nik']],
                $data
            );
        }

        $this->command->info('Penduduk data seeded successfully!');
        $this->command->info('Total penduduk: ' . count($pendudukData));
        $this->command->info('Gender breakdown:');
        $this->command->info('- Laki-laki: ' . collect($pendudukData)->where('jenis_kelamin', 'L')->count());
        $this->command->info('- Perempuan: ' . collect($pendudukData)->where('jenis_kelamin', 'P')->count());
    }
}