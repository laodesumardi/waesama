<?php

namespace Database\Seeders;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PengaduanSeeder extends Seeder
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

        $pengaduanData = [
            [
                'nomor_pengaduan' => 'ADU/001/I/2025',
                'nama_pengadu' => 'Budi Santoso',
                'email_pengadu' => 'budi.santoso@gmail.com',
                'phone_pengadu' => '081234567890',
                'alamat_pengadu' => 'Jl. Kenanga No. 45, Desa Waesama',
                'judul_pengaduan' => 'Pelayanan Lambat di Loket 1',
                'isi_pengaduan' => 'Saya mengajukan surat keterangan domisili sejak 3 hari yang lalu namun belum ada kabar. Petugas di loket 1 terkesan kurang responsif dalam memberikan informasi progress pengajuan surat.',
                'kategori' => 'Pelayanan Publik',
                'prioritas' => 'Sedang',
                'status' => 'Selesai',
                'tanggapan' => 'Terima kasih atas pengaduannya. Kami telah melakukan evaluasi dan perbaikan SOP pelayanan. Surat Anda telah selesai dan dapat diambil hari ini.',
                'ditangani_oleh' => $pegawaiUsers->first()?->id,
                'tanggal_ditangani' => now()->subDays(3),
                'tanggal_selesai' => now()->subDays(1),
            ],
            [
                'nomor_pengaduan' => 'ADU/002/I/2025',
                'nama_pengadu' => 'Rina Wati',
                'email_pengadu' => 'rina.wati@gmail.com',
                'phone_pengadu' => '081234567891',
                'alamat_pengadu' => 'Jl. Dahlia No. 12, Desa Waesama',
                'judul_pengaduan' => 'Fasilitas Toilet Tidak Bersih',
                'isi_pengaduan' => 'Toilet umum di kantor camat kondisinya kurang bersih dan tidak tersedia sabun cuci tangan. Mohon untuk diperbaiki karena ini menyangkut kesehatan pengunjung.',
                'kategori' => 'Kebersihan',
                'prioritas' => 'Tinggi',
                'status' => 'Diproses',
                'tanggapan' => null,
                'ditangani_oleh' => $pegawaiUsers->skip(1)->first()?->id,
                'tanggal_ditangani' => now()->subDay(),
                'tanggal_selesai' => null,
            ],
            [
                'nomor_pengaduan' => 'ADU/003/I/2025',
                'nama_pengadu' => 'Joko Widodo',
                'email_pengadu' => 'joko.widodo@gmail.com',
                'phone_pengadu' => '081234567892',
                'alamat_pengadu' => 'Jl. Melati No. 8, Desa Waesama',
                'judul_pengaduan' => 'Persyaratan Surat Tidak Jelas',
                'isi_pengaduan' => 'Informasi persyaratan untuk mengurus surat keterangan usaha tidak jelas. Di website tertulis satu hal, tapi ketika datang ke kantor diminta dokumen tambahan yang tidak disebutkan sebelumnya.',
                'kategori' => 'Pelayanan Publik',
                'prioritas' => 'Sedang',
                'status' => 'Selesai',
                'tanggapan' => 'Terima kasih atas masukannya. Kami telah memperbarui informasi persyaratan di website dan papan pengumuman. Untuk surat keterangan usaha, persyaratan lengkap sudah diperbaharui.',
                'ditangani_oleh' => $pegawaiUsers->skip(2)->first()?->id,
                'tanggal_ditangani' => now()->subDays(5),
                'tanggal_selesai' => now()->subDays(3),
            ],
            [
                'nomor_pengaduan' => 'ADU/004/I/2025',
                'nama_pengadu' => 'Sri Mulyani',
                'email_pengadu' => 'sri.mulyani@gmail.com',
                'phone_pengadu' => '081234567893',
                'alamat_pengadu' => 'Jl. Anggrek No. 22, Desa Waesama',
                'judul_pengaduan' => 'Antrian Online Tidak Berfungsi',
                'isi_pengaduan' => 'Sistem antrian online di website tidak bisa diakses. Selalu muncul error ketika mencoba mendaftar antrian. Mohon diperbaiki agar masyarakat bisa menggunakan layanan ini.',
                'kategori' => 'Lainnya',
                'prioritas' => 'Tinggi',
                'status' => 'Diterima',
                'tanggapan' => null,
                'ditangani_oleh' => null,
                'tanggal_ditangani' => null,
                'tanggal_selesai' => null,
            ],
            [
                'nomor_pengaduan' => 'ADU/005/I/2025',
                'nama_pengadu' => 'Agus Salim',
                'email_pengadu' => 'agus.salim@gmail.com',
                'phone_pengadu' => '081234567894',
                'alamat_pengadu' => 'Jl. Mawar No. 15, Desa Waesama',
                'judul_pengaduan' => 'Parkir Kendaraan Kurang Memadai',
                'isi_pengaduan' => 'Area parkir di kantor camat terlalu sempit dan tidak tertata dengan baik. Sering terjadi kemacetan kecil di depan kantor karena kendaraan parkir sembarangan.',
                'kategori' => 'Infrastruktur',
                'prioritas' => 'Rendah',
                'status' => 'Diproses',
                'tanggapan' => null,
                'ditangani_oleh' => $pegawaiUsers->first()?->id,
                'tanggal_ditangani' => now()->subDays(2),
                'tanggal_selesai' => null,
            ],
            [
                'nomor_pengaduan' => 'ADU/006/I/2025',
                'nama_pengadu' => 'Sari Dewi',
                'email_pengadu' => 'sari.dewi@gmail.com',
                'phone_pengadu' => '081234567895',
                'alamat_pengadu' => 'Jl. Cempaka No. 30, Desa Waesama',
                'judul_pengaduan' => 'Jam Pelayanan Tidak Sesuai',
                'isi_pengaduan' => 'Beberapa kali saya datang pada jam 14.30 namun petugas sudah tidak ada. Padahal di papan pengumuman tertulis pelayanan sampai jam 15.00. Mohon konsistensi jam pelayanan.',
                'kategori' => 'Pelayanan Publik',
                'prioritas' => 'Sedang',
                'status' => 'Ditindaklanjuti',
                'tanggapan' => 'Mohon maaf atas ketidaknyamanan ini. Kami telah melakukan pembinaan kepada petugas terkait kedisiplinan jam kerja. Jam pelayanan akan konsisten sesuai yang tertera.',
                'ditangani_oleh' => $pegawaiUsers->skip(1)->first()?->id,
                'tanggal_ditangani' => now()->subDays(8),
                'tanggal_selesai' => null,
            ],
        ];

        foreach ($pengaduanData as $data) {
            Pengaduan::firstOrCreate(
                ['nomor_pengaduan' => $data['nomor_pengaduan']],
                $data
            );
        }

        $this->command->info('Pengaduan data seeded successfully!');
        $this->command->info('Total pengaduan: ' . count($pengaduanData));
        $this->command->info('Status breakdown:');
        $this->command->info('- Diterima: ' . collect($pengaduanData)->where('status', 'Diterima')->count());
        $this->command->info('- Diproses: ' . collect($pengaduanData)->where('status', 'Diproses')->count());
        $this->command->info('- Ditindaklanjuti: ' . collect($pengaduanData)->where('status', 'Ditindaklanjuti')->count());
        $this->command->info('- Selesai: ' . collect($pengaduanData)->where('status', 'Selesai')->count());
        $this->command->info('Kategori breakdown:');
        $this->command->info('- Pelayanan: ' . collect($pengaduanData)->where('kategori', 'Pelayanan')->count());
        $this->command->info('- Infrastruktur: ' . collect($pengaduanData)->where('kategori', 'Infrastruktur')->count());
        $this->command->info('- Kebersihan: ' . collect($pengaduanData)->where('kategori', 'Kebersihan')->count());
        $this->command->info('- Lainnya: ' . collect($pengaduanData)->where('kategori', 'Lainnya')->count());
    }
}