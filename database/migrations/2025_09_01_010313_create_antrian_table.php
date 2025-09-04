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
        Schema::create('antrian', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_antrian')->unique();
            $table->string('nama_pengunjung');
            $table->string('nik_pengunjung', 16)->nullable();
            $table->string('phone_pengunjung');
            $table->enum('jenis_layanan', ['Surat Domisili', 'SKTM', 'Surat Usaha', 'Surat Pengantar', 'Konsultasi', 'Lainnya']);
            $table->text('keperluan')->nullable();
            $table->date('tanggal_kunjungan');
            $table->time('jam_kunjungan');
            $table->enum('status', ['Menunggu', 'Dipanggil', 'Dilayani', 'Selesai', 'Batal'])->default('Menunggu');
            $table->integer('estimasi_waktu')->nullable(); // dalam menit
            $table->text('catatan')->nullable();
            $table->foreignId('dilayani_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('waktu_mulai_layanan')->nullable();
            $table->timestamp('waktu_selesai_layanan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrian');
    }
};
