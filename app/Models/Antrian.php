<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Antrian extends Model
{
    protected $table = 'antrian';
    
    protected $fillable = [
        'nomor_antrian',
        'nama_pengunjung',
        'nik_pengunjung',
        'phone_pengunjung',
        'jenis_layanan',
        'keperluan',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'status',
        'estimasi_waktu',
        'catatan',
        'dilayani_oleh',
        'waktu_mulai_layanan',
        'waktu_selesai_layanan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kunjungan' => 'date',
            'jam_kunjungan' => 'datetime:H:i',
            'waktu_mulai_layanan' => 'datetime',
            'waktu_selesai_layanan' => 'datetime',
        ];
    }

    /**
     * Get the user who serves the antrian.
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dilayani_oleh');
    }
}
