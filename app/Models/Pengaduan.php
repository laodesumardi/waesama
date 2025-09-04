<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';
    
    protected $fillable = [
        'nomor_pengaduan',
        'nama_pengadu',
        'email_pengadu',
        'phone_pengadu',
        'alamat_pengadu',
        'judul_pengaduan',
        'isi_pengaduan',
        'kategori',
        'prioritas',
        'status',
        'tanggapan',
        'lampiran',
        'ditangani_oleh',
        'tanggal_ditangani',
        'tanggal_selesai',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_ditangani' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    /**
     * Get the user who handles the pengaduan.
     */
    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }
}
