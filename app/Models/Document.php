<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $fillable = [
        'document_number',
        'service_request_id',
        'template_name',
        'document_title',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'digital_signature',
        'template_variables',
        'generated_by',
        'generated_at',
        'download_count',
        'last_downloaded_at',
        'is_active',
        'valid_until',
        'notes'
    ];

    protected $casts = [
        'template_variables' => 'array',
        'generated_at' => 'datetime',
        'last_downloaded_at' => 'datetime',
        'valid_until' => 'date',
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->document_number)) {
                $model->document_number = static::generateDocumentNumber();
            }
            if (empty($model->generated_at)) {
                $model->generated_at = now();
            }
        });
    }

    public static function generateDocumentNumber()
    {
        $prefix = 'DOC';
        $date = now()->format('Ymd');
        $lastDocument = static::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastDocument ? (int) substr($lastDocument->document_number, -4) + 1 : 1;
        
        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    // Relationships
    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function generatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByTemplate($query, $templateName)
    {
        return $query->where('template_name', $templateName);
    }

    public function scopeValid($query)
    {
        return $query->where(function($q) {
            $q->whereNull('valid_until')
              ->orWhere('valid_until', '>=', now()->toDateString());
        });
    }

    // Accessors
    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getIsValidAttribute()
    {
        return $this->is_active && 
               ($this->valid_until === null || $this->valid_until >= now()->toDateString());
    }

    public function getDownloadUrlAttribute()
    {
        return route('admin.documents.download', $this->id);
    }

    // Methods
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
        $this->update(['last_downloaded_at' => now()]);
    }

    public function getFileContent()
    {
        if (Storage::exists($this->file_path)) {
            return Storage::get($this->file_path);
        }
        
        return null;
    }

    public function deleteFile()
    {
        if (Storage::exists($this->file_path)) {
            Storage::delete($this->file_path);
        }
    }

    public function markAsInactive()
    {
        $this->update(['is_active' => false]);
    }

    public function setValidUntil($date)
    {
        $this->update(['valid_until' => $date]);
    }

    // Static methods for template management
    public static function getAvailableTemplates()
    {
        return [
            'surat_keterangan_domisili' => 'Surat Keterangan Domisili',
            'surat_keterangan_usaha' => 'Surat Keterangan Usaha',
            'surat_keterangan_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
            'surat_keterangan_kelahiran' => 'Surat Keterangan Kelahiran',
            'surat_keterangan_kematian' => 'Surat Keterangan Kematian',
            'surat_pengantar_nikah' => 'Surat Pengantar Nikah',
            'surat_keterangan_beda_nama' => 'Surat Keterangan Beda Nama',
            'surat_keterangan_penghasilan' => 'Surat Keterangan Penghasilan',
            'surat_rekomendasi' => 'Surat Rekomendasi'
        ];
    }

    public static function getTemplateRequiredFields($templateName)
    {
        $requirements = [
            'surat_keterangan_domisili' => ['alamat_lengkap', 'rt_rw', 'keperluan'],
            'surat_keterangan_usaha' => ['jenis_usaha', 'alamat_usaha', 'modal_usaha'],
            'surat_keterangan_tidak_mampu' => ['keperluan', 'keterangan_tambahan'],
            'surat_keterangan_kelahiran' => ['tempat_lahir', 'tanggal_lahir', 'nama_ayah', 'nama_ibu'],
            'surat_keterangan_kematian' => ['tempat_meninggal', 'tanggal_meninggal', 'sebab_kematian'],
            'surat_pengantar_nikah' => ['calon_pasangan', 'tempat_nikah', 'tanggal_nikah'],
            'surat_keterangan_beda_nama' => ['nama_sebelumnya', 'nama_sekarang', 'alasan'],
            'surat_keterangan_penghasilan' => ['pekerjaan', 'penghasilan_perbulan', 'keterangan'],
            'surat_rekomendasi' => ['keperluan', 'tujuan', 'keterangan']
        ];
        
        return $requirements[$templateName] ?? [];
    }
}
