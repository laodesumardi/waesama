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
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->enum('jenis_surat', ['Domisili', 'SKTM', 'Usaha', 'Pengantar', 'Kematian', 'Kelahiran', 'Pindah']);
            $table->string('nama_pemohon');
            $table->string('nik_pemohon', 16);
            $table->text('alamat_pemohon');
            $table->string('phone_pemohon')->nullable();
            $table->text('keperluan');
            $table->json('data_tambahan')->nullable(); // untuk data spesifik per jenis surat
            $table->enum('status', ['Pending', 'Diproses', 'Selesai', 'Ditolak'])->default('Pending');
            $table->text('catatan')->nullable();
            $table->foreignId('diproses_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tanggal_selesai')->nullable();
            $table->string('file_surat')->nullable(); // path file PDF yang dihasilkan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
