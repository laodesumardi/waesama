<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Document extends Model
{
    protected $fillable = [
        'service_request_id',
        'document_number',
        'template_name',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'is_active',
        'generated_by',
        'generated_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'generated_at' => 'datetime',
        'file_size' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->document_number)) {
                $model->document_number = static::generateDocumentNumber();
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

    // Accessors
    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByTemplate($query, $template)
    {
        return $query->where('template_name', $template);
    }
}
