<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Surat extends Model
{
    protected $table = 'surat';
    
    protected $fillable = [
        'nomor_surat',
        'jenis_surat',
        'nama_pemohon',
        'nik_pemohon',
        'alamat_pemohon',
        'phone_pemohon',
        'keperluan',
        'data_tambahan',
        'status',
        'catatan',
        'diproses_oleh',
        'tanggal_selesai',
        'file_surat',
    ];

    protected function casts(): array
    {
        return [
            'data_tambahan' => 'array',
            'tanggal_selesai' => 'date',
        ];
    }

    /**
     * Get the user who processed the surat.
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }
}
