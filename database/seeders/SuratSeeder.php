<?php

namespace Database\Seeders;

use App\Models\Surat;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users
        $wargaUsers = User::whereHas('role', function($query) {
            $query->where('name', 'Warga');
        })->get();
        
        $pegawaiUsers = User::whereHas('role', function($query) {
            $query->where('name', 'Pegawai');
        })->get();

        $suratData = [
            [
                'nomor_surat' => 'DOM/001/I/2025',
                'jenis_surat' => 'Domisili',
                'nama_pemohon' => 'Budi Santoso',
                'nik_pemohon' => '7301010101950001',
                'alamat_pemohon' => 'Jl. Kenanga No. 45, Desa Waesama',
                'phone_pemohon' => '081234567890',
                'keperluan' => 'Untuk keperluan pendaftaran sekolah anak',
                'data_tambahan' => json_encode([
                    'lama_tinggal' => '5 tahun',
                    'status_tempat_tinggal' => 'Milik Sendiri'
                ]),
                'status' => 'Selesai',
                'catatan' => 'Surat telah selesai dan dapat diambil',
                'diproses_oleh' => $pegawaiUsers->first()?->id,
                'tanggal_selesai' => now()->subDays(2),
            ],
            [
                'nomor_surat' => 'SKTM/001/I/2025',
                'jenis_surat' => 'SKTM',
                'nama_pemohon' => 'Rina Wati',
                'nik_pemohon' => '7301010101930001',
                'alamat_pemohon' => 'Jl. Dahlia No. 12, Desa Waesama',
                'phone_pemohon' => '081234567891',
                'keperluan' => 'Untuk beasiswa pendidikan anak',
                'data_tambahan' => json_encode([
                    'jumlah_tanggungan' => '3 orang',
                    'penghasilan_perbulan' => 'Rp 1.500.000'
                ]),
                'status' => 'Diproses',
                'catatan' => 'Sedang dalam proses verifikasi data',
                'diproses_oleh' => $pegawaiUsers->skip(1)->first()?->id,
                'tanggal_selesai' => null,
            ],
            [
                'nomor_surat' => 'USH/001/I/2025',
                'jenis_surat' => 'Usaha',
                'nama_pemohon' => 'Joko Widodo',
                'nik_pemohon' => '7301010101920001',
                'alamat_pemohon' => 'Jl. Melati No. 8, Desa Waesama',
                'phone_pemohon' => '081234567892',
                'keperluan' => 'Untuk izin usaha warung kelontong',
                'data_tambahan' => json_encode([
                    'jenis_usaha' => 'Warung Kelontong',
                    'modal_usaha' => 'Rp 10.000.000',
                    'lokasi_usaha' => 'Jl. Melati No. 8, Desa Waesama'
                ]),
                'status' => 'Selesai',
                'catatan' => 'Surat keterangan usaha telah selesai',
                'diproses_oleh' => $pegawaiUsers->skip(2)->first()?->id,
                'tanggal_selesai' => now()->subDays(1),
            ],
            [
                'nomor_surat' => 'PNG/001/I/2025',
                'jenis_surat' => 'Pengantar',
                'nama_pemohon' => 'Sri Mulyani',
                'nik_pemohon' => '7301010101940001',
                'alamat_pemohon' => 'Jl. Anggrek No. 22, Desa Waesama',
                'phone_pemohon' => '081234567893',
                'keperluan' => 'Untuk keperluan melamar pekerjaan',
                'data_tambahan' => json_encode([
                    'tujuan' => 'Rumah Sakit Umum Daerah',
                    'posisi' => 'Perawat'
                ]),
                'status' => 'Pending',
                'catatan' => null,
                'diproses_oleh' => null,
                'tanggal_selesai' => null,
            ],
            [
                'nomor_surat' => 'DOM/002/I/2025',
                'jenis_surat' => 'Domisili',
                'nama_pemohon' => 'Agus Salim',
                'nik_pemohon' => '7301010101910001',
                'alamat_pemohon' => 'Jl. Mawar No. 15, Desa Waesama',
                'phone_pemohon' => '081234567894',
                'keperluan' => 'Untuk keperluan pembuatan KTP',
                'data_tambahan' => json_encode([
                    'lama_tinggal' => '10 tahun',
                    'status_tempat_tinggal' => 'Milik Sendiri'
                ]),
                'status' => 'Diproses',
                'catatan' => 'Menunggu verifikasi RT/RW',
                'diproses_oleh' => $pegawaiUsers->first()?->id,
                'tanggal_selesai' => null,
            ],
            [
                'nomor_surat' => 'SKTM/002/I/2025',
                'jenis_surat' => 'SKTM',
                'nama_pemohon' => 'Sari Dewi',
                'nik_pemohon' => '7301010101960001',
                'alamat_pemohon' => 'Jl. Cempaka No. 30, Desa Waesama',
                'phone_pemohon' => '081234567895',
                'keperluan' => 'Untuk bantuan sosial pemerintah',
                'data_tambahan' => json_encode([
                    'jumlah_tanggungan' => '2 orang',
                    'penghasilan_perbulan' => 'Rp 800.000'
                ]),
                'status' => 'Ditolak',
                'catatan' => 'Data penghasilan tidak sesuai dengan kriteria',
                'diproses_oleh' => $pegawaiUsers->skip(1)->first()?->id,
                'tanggal_selesai' => now()->subDays(3),
            ],
        ];

        foreach ($suratData as $data) {
            Surat::firstOrCreate(
                ['nomor_surat' => $data['nomor_surat']],
                $data
            );
        }

        $this->command->info('Surat data seeded successfully!');
        $this->command->info('Total surat: ' . count($suratData));
        $this->command->info('Status breakdown:');
        $this->command->info('- Pending: ' . collect($suratData)->where('status', 'Pending')->count());
        $this->command->info('- Diproses: ' . collect($suratData)->where('status', 'Diproses')->count());
        $this->command->info('- Selesai: ' . collect($suratData)->where('status', 'Selesai')->count());
        $this->command->info('- Ditolak: ' . collect($suratData)->where('status', 'Ditolak')->count());
        $this->command->info('Jenis surat breakdown:');
        $this->command->info('- Domisili: ' . collect($suratData)->where('jenis_surat', 'Domisili')->count());
        $this->command->info('- SKTM: ' . collect($suratData)->where('jenis_surat', 'SKTM')->count());
        $this->command->info('- Usaha: ' . collect($suratData)->where('jenis_surat', 'Usaha')->count());
        $this->command->info('- Pengantar: ' . collect($suratData)->where('jenis_surat', 'Pengantar')->count());
    }
}