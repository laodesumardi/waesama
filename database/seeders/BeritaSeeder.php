<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Berita;
use App\Models\User;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user admin untuk author_id
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        $admin = User::whereHas('role', function($query) {
            $query->where('name', 'admin');
        })->first();
        
        if (!$admin) {
            $admin = User::create([
                'name' => 'Administrator',
                'email' => 'admin@waesama.go.id',
                'password' => bcrypt('password'),
                'role_id' => $adminRole->id,
                'email_verified_at' => now(),
            ]);
        }

        $beritaData = [
            [
                'judul' => 'Pembukaan Pendaftaran Program Bantuan Sosial Tahun 2025',
                'excerpt' => 'Kantor Camat Waesama membuka pendaftaran program bantuan sosial untuk masyarakat kurang mampu tahun 2025.',
                'konten' => 'Kantor Camat Waesama dengan ini mengumumkan pembukaan pendaftaran program bantuan sosial tahun 2025. Program ini ditujukan untuk membantu masyarakat kurang mampu di wilayah Kecamatan Waesama. Pendaftaran dibuka mulai tanggal 15 Januari 2025 hingga 15 Februari 2025. Persyaratan yang harus dipenuhi antara lain: KTP asli dan fotokopi, Kartu Keluarga asli dan fotokopi, Surat Keterangan Tidak Mampu dari RT/RW, dan dokumen pendukung lainnya. Informasi lebih lanjut dapat menghubungi kantor camat pada jam kerja.',
                'status' => 'Published',
                'is_featured' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'judul' => 'Jadwal Pelayanan Administrasi Kependudukan Bulan Januari 2025',
                'excerpt' => 'Informasi jadwal pelayanan administrasi kependudukan di Kantor Camat Waesama untuk bulan Januari 2025.',
                'konten' => 'Kantor Camat Waesama menginformasikan jadwal pelayanan administrasi kependudukan untuk bulan Januari 2025. Pelayanan tersedia setiap hari Senin-Jumat pukul 08.00-15.00 WIB. Khusus untuk hari Jumat, pelayanan dihentikan sementara pada pukul 11.30-13.00 untuk istirahat sholat Jumat. Jenis layanan yang tersedia meliputi: pembuatan surat keterangan domisili, surat keterangan tidak mampu, surat pengantar, dan layanan administrasi lainnya. Masyarakat diharapkan membawa dokumen yang diperlukan dan datang sesuai jadwal yang telah ditentukan.',
                'status' => 'Published',
                'is_featured' => false,
                'published_at' => now()->subDays(3),
            ],
            [
                'judul' => 'Sosialisasi Program Desa Digital di Kecamatan Waesama',
                'excerpt' => 'Kantor Camat Waesama mengadakan sosialisasi program desa digital untuk meningkatkan pelayanan publik.',
                'konten' => 'Dalam rangka meningkatkan kualitas pelayanan publik, Kantor Camat Waesama mengadakan sosialisasi program desa digital. Program ini bertujuan untuk mengintegrasikan teknologi digital dalam pelayanan administrasi kependudukan dan pelayanan publik lainnya. Sosialisasi akan dilaksanakan pada tanggal 20 Januari 2025 di Aula Kantor Camat Waesama. Peserta yang diundang meliputi kepala desa, perangkat desa, dan tokoh masyarakat. Melalui program ini diharapkan pelayanan kepada masyarakat dapat lebih efisien dan transparan.',
                'status' => 'Published',
                'is_featured' => false,
                'published_at' => now()->subDays(5),
            ],
            [
                'judul' => 'Pengumuman Libur Nasional dan Cuti Bersama Tahun 2025',
                'excerpt' => 'Informasi mengenai jadwal libur nasional dan cuti bersama yang berlaku di Kantor Camat Waesama tahun 2025.',
                'konten' => 'Kantor Camat Waesama menginformasikan jadwal libur nasional dan cuti bersama tahun 2025 sesuai dengan Keputusan Bersama Menteri. Libur nasional yang akan berlaku antara lain: Tahun Baru (1 Januari), Isra Miraj (27 Januari), Imlek (29 Januari), Nyepi (29 Maret), Wafat Isa Almasih (18 April), Hari Buruh (1 Mei), Kenaikan Isa Almasih (29 Mei), Waisak (12 Mei), Pancasila (1 Juni), Idul Fitri (30-31 Maret), Idul Adha (6 Juni), Tahun Baru Islam (26 Juni), Kemerdekaan RI (17 Agustus), Maulid Nabi (4 September), dan Natal (25 Desember). Pada hari libur tersebut, pelayanan di kantor camat diliburkan.',
                'status' => 'Published',
                'is_featured' => false,
                'published_at' => now()->subDays(7),
            ],
            [
                'judul' => 'Peningkatan Keamanan Wilayah Melalui Siskamling',
                'excerpt' => 'Kantor Camat Waesama mengajak masyarakat untuk aktif dalam kegiatan sistem keamanan lingkungan (Siskamling).',
                'konten' => 'Kantor Camat Waesama mengajak seluruh masyarakat untuk berpartisipasi aktif dalam kegiatan sistem keamanan lingkungan (Siskamling). Program ini bertujuan untuk meningkatkan keamanan dan ketertiban di wilayah Kecamatan Waesama. Kegiatan Siskamling akan dilaksanakan secara bergiliran oleh warga di setiap RT/RW. Masyarakat diharapkan dapat bergotong royong menjaga keamanan lingkungan tempat tinggal. Kantor camat akan memberikan dukungan berupa koordinasi dengan pihak kepolisian dan penyediaan peralatan keamanan dasar. Mari bersama-sama menjaga keamanan dan kenyamanan lingkungan kita.',
                'status' => 'Published',
                'is_featured' => false,
                'published_at' => now()->subDays(10),
            ],
            [
                'judul' => 'Program Vaksinasi COVID-19 Booster di Kecamatan Waesama',
                'excerpt' => 'Kantor Camat Waesama bekerja sama dengan Puskesmas mengadakan program vaksinasi COVID-19 booster.',
                'konten' => 'Kantor Camat Waesama bekerja sama dengan Puskesmas setempat mengadakan program vaksinasi COVID-19 booster untuk masyarakat Kecamatan Waesama. Vaksinasi akan dilaksanakan selama 3 hari, mulai tanggal 25-27 Januari 2025 di Aula Kantor Camat Waesama. Target peserta adalah masyarakat yang telah menerima vaksin dosis kedua minimal 6 bulan yang lalu. Persyaratan yang harus dibawa: KTP asli, kartu vaksin sebelumnya, dan dalam kondisi sehat. Vaksinasi dilaksanakan gratis dan peserta akan mendapatkan sertifikat vaksin. Mari bersama-sama menjaga kesehatan dengan mengikuti program vaksinasi ini.',
                'status' => 'Published',
                'is_featured' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'judul' => 'Pengumuman Jadwal Pelayanan Khusus Hari Kemerdekaan',
                'excerpt' => 'Informasi jadwal pelayanan khusus di Kantor Camat Waesama dalam rangka memperingati Hari Kemerdekaan RI.',
                'konten' => 'Dalam rangka memperingati Hari Kemerdekaan Republik Indonesia yang ke-80, Kantor Camat Waesama mengumumkan jadwal pelayanan khusus. Pada tanggal 17 Agustus 2025, seluruh pelayanan administrasi diliburkan untuk mengikuti upacara bendera dan kegiatan peringatan kemerdekaan. Pelayanan akan kembali normal pada tanggal 18 Agustus 2025. Masyarakat yang memerlukan layanan mendesak dapat menghubungi nomor darurat yang telah disediakan. Kami mengajak seluruh masyarakat untuk berpartisipasi dalam kegiatan peringatan kemerdekaan di lapangan kecamatan.',
                'status' => 'Published',
                'is_featured' => false,
                'published_at' => \Carbon\Carbon::create(2025, 8, 27, 10, 0, 0),
                'slug' => 'pengumuman-jadwal-pelayanan-khusus-hari-kemerdekaan',
                'author_id' => 1,
                'views' => 216,
            ],
        ];

        foreach ($beritaData as $data) {
            $data['slug'] = Str::slug($data['judul']);
            $data['author_id'] = $admin->id;
            $data['views'] = rand(50, 500);
            
            Berita::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
