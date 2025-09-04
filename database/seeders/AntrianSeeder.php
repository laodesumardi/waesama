<?php

namespace Database\Seeders;

use App\Models\Antrian;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AntrianSeeder extends Seeder
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

        $antrianData = [
            [
                'nomor_antrian' => 'A001',
                'nama_pengunjung' => 'Budi Santoso',
                'nik_pengunjung' => '7301010101950001',
                'phone_pengunjung' => '081234567890',
                'jenis_layanan' => 'Surat Domisili',
                'keperluan' => 'Untuk keperluan pendaftaran sekolah anak',
                'tanggal_kunjungan' => Carbon::today(),
                'jam_kunjungan' => '08:30:00',
                'status' => 'Selesai',
                'estimasi_waktu' => 30,
                'catatan' => 'Layanan telah selesai',
                'dilayani_oleh' => $pegawaiUsers->first()?->id,
                'waktu_mulai_layanan' => Carbon::today()->setTime(8, 30),
                'waktu_selesai_layanan' => Carbon::today()->setTime(9, 0),
            ],
            [
                'nomor_antrian' => 'A002',
                'nama_pengunjung' => 'Rina Wati',
                'nik_pengunjung' => '7301010101930001',
                'phone_pengunjung' => '081234567891',
                'jenis_layanan' => 'SKTM',
                'keperluan' => 'Untuk beasiswa pendidikan anak',
                'tanggal_kunjungan' => Carbon::today(),
                'jam_kunjungan' => '09:00:00',
                'status' => 'Dilayani',
                'estimasi_waktu' => 45,
                'catatan' => 'Sedang dalam proses verifikasi data',
                'dilayani_oleh' => $pegawaiUsers->skip(1)->first()?->id,
                'waktu_mulai_layanan' => Carbon::today()->setTime(9, 0),
                'waktu_selesai_layanan' => null,
            ],
            [
                'nomor_antrian' => 'A003',
                'nama_pengunjung' => 'Joko Widodo',
                'nik_pengunjung' => '7301010101920001',
                'phone_pengunjung' => '081234567892',
                'jenis_layanan' => 'Surat Usaha',
                'keperluan' => 'Untuk izin usaha warung kelontong',
                'tanggal_kunjungan' => Carbon::today(),
                'jam_kunjungan' => '09:30:00',
                'status' => 'Dipanggil',
                'estimasi_waktu' => 30,
                'catatan' => 'Menunggu dipanggil untuk dilayani',
                'dilayani_oleh' => null,
                'waktu_mulai_layanan' => null,
                'waktu_selesai_layanan' => null,
            ],
            [
                'nomor_antrian' => 'A004',
                'nama_pengunjung' => 'Sri Mulyani',
                'nik_pengunjung' => '7301010101940001',
                'phone_pengunjung' => '081234567893',
                'jenis_layanan' => 'Surat Pengantar',
                'keperluan' => 'Untuk keperluan melamar pekerjaan',
                'tanggal_kunjungan' => Carbon::today(),
                'jam_kunjungan' => '10:00:00',
                'status' => 'Menunggu',
                'estimasi_waktu' => 20,
                'catatan' => null,
                'dilayani_oleh' => null,
                'waktu_mulai_layanan' => null,
                'waktu_selesai_layanan' => null,
            ],
            [
                'nomor_antrian' => 'A005',
                'nama_pengunjung' => 'Agus Salim',
                'nik_pengunjung' => '7301010101910001',
                'phone_pengunjung' => '081234567894',
                'jenis_layanan' => 'Konsultasi',
                'keperluan' => 'Konsultasi mengenai persyaratan pembuatan KTP',
                'tanggal_kunjungan' => Carbon::tomorrow(),
                'jam_kunjungan' => '08:00:00',
                'status' => 'Menunggu',
                'estimasi_waktu' => 15,
                'catatan' => 'Jadwal untuk besok',
                'dilayani_oleh' => null,
                'waktu_mulai_layanan' => null,
                'waktu_selesai_layanan' => null,
            ],
            [
                'nomor_antrian' => 'A006',
                'nama_pengunjung' => 'Sari Dewi',
                'nik_pengunjung' => '7301010101960001',
                'phone_pengunjung' => '081234567895',
                'jenis_layanan' => 'Lainnya',
                'keperluan' => 'Pengambilan surat yang sudah jadi',
                'tanggal_kunjungan' => Carbon::yesterday(),
                'jam_kunjungan' => '14:00:00',
                'status' => 'Batal',
                'estimasi_waktu' => 5,
                'catatan' => 'Tidak hadir sesuai jadwal',
                'dilayani_oleh' => null,
                'waktu_mulai_layanan' => null,
                'waktu_selesai_layanan' => null,
            ],
        ];

        foreach ($antrianData as $data) {
            Antrian::firstOrCreate(
                ['nomor_antrian' => $data['nomor_antrian']],
                $data
            );
        }

        $this->command->info('Antrian data seeded successfully!');
        $this->command->info('Total antrian: ' . count($antrianData));
        $this->command->info('Status breakdown:');
        $this->command->info('- Menunggu: ' . collect($antrianData)->where('status', 'Menunggu')->count());
        $this->command->info('- Dipanggil: ' . collect($antrianData)->where('status', 'Dipanggil')->count());
        $this->command->info('- Dilayani: ' . collect($antrianData)->where('status', 'Dilayani')->count());
        $this->command->info('- Selesai: ' . collect($antrianData)->where('status', 'Selesai')->count());
        $this->command->info('- Batal: ' . collect($antrianData)->where('status', 'Batal')->count());
        $this->command->info('Jenis layanan breakdown:');
        $this->command->info('- Surat Domisili: ' . collect($antrianData)->where('jenis_layanan', 'Surat Domisili')->count());
        $this->command->info('- SKTM: ' . collect($antrianData)->where('jenis_layanan', 'SKTM')->count());
        $this->command->info('- Surat Usaha: ' . collect($antrianData)->where('jenis_layanan', 'Surat Usaha')->count());
        $this->command->info('- Surat Pengantar: ' . collect($antrianData)->where('jenis_layanan', 'Surat Pengantar')->count());
        $this->command->info('- Konsultasi: ' . collect($antrianData)->where('jenis_layanan', 'Konsultasi')->count());
        $this->command->info('- Lainnya: ' . collect($antrianData)->where('jenis_layanan', 'Lainnya')->count());
    }
}