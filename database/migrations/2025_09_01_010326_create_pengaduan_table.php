<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengaduan')->unique();
            $table->string('nama_pengadu');
            $table->string('email_pengadu')->nullable();
            $table->string('phone_pengadu');
            $table->text('alamat_pengadu')->nullable();
            $table->string('judul_pengaduan');
            $table->longText('isi_pengaduan');
            $table->enum('kategori', ['Infrastruktur', 'Pelayanan Publik', 'Keamanan', 'Kebersihan', 'Administrasi', 'Lainnya']);
            $table->enum('prioritas', ['Rendah', 'Sedang', 'Tinggi', 'Urgent'])->default('Sedang');
            $table->enum('status', ['Baru', 'Diterima', 'Diproses', 'Ditindaklanjuti', 'Selesai', 'Ditolak'])->default('Baru');
            $table->text('tanggapan')->nullable();
            $table->string('lampiran')->nullable(); // file attachment
            $table->foreignId('ditangani_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tanggal_ditangani')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
