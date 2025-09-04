<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ServiceRequest extends Model
{
    protected $fillable = [
        'request_number',
        'citizen_id',
        'service_type',
        'purpose',
        'status',
        'priority',
        'required_documents',
        'uploaded_files',
        'notes',
        'rejection_reason',
        'requested_at',
        'processed_at',
        'approved_at',
        'completed_at',
        'processed_by',
        'approved_by',
        'fee_amount',
        'payment_status',
        'payment_at',
        'payment_method',
        'payment_reference'
    ];

    protected $casts = [
        'required_documents' => 'array',
        'uploaded_files' => 'array',
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
        'payment_at' => 'datetime',
        'fee_amount' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->request_number)) {
                $model->request_number = static::generateRequestNumber();
            }
        });
    }

    public static function generateRequestNumber()
    {
        $prefix = 'REQ';
        $date = now()->format('Ymd');
        $lastRequest = static::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastRequest ? (int) substr($lastRequest->request_number, -4) + 1 : 1;
        
        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    // Relationships
    public function citizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByServiceType($query, $serviceType)
    {
        return $query->where('service_type', $serviceType);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $statusConfig = [
            'draft' => ['class' => 'bg-gray-100 text-gray-800', 'label' => 'Draft'],
            'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'label' => 'Menunggu'],
            'processing' => ['class' => 'bg-blue-100 text-blue-800', 'label' => 'Diproses'],
            'approved' => ['class' => 'bg-green-100 text-green-800', 'label' => 'Disetujui'],
            'rejected' => ['class' => 'bg-red-100 text-red-800', 'label' => 'Ditolak'],
            'completed' => ['class' => 'bg-green-100 text-green-800', 'label' => 'Selesai'],
            'cancelled' => ['class' => 'bg-gray-100 text-gray-800', 'label' => 'Dibatalkan']
        ];
        
        $config = $statusConfig[$this->status] ?? ['class' => 'bg-gray-100 text-gray-800', 'label' => ucfirst($this->status)];
        
        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $config['class'] . '">' . $config['label'] . '</span>';
    }

    public function getServiceTypeBadgeAttribute()
    {
        $serviceTypeLabels = [
            'surat_keterangan_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
            'surat_keterangan_domisili' => 'Surat Keterangan Domisili',
            'surat_keterangan_usaha' => 'Surat Keterangan Usaha',
            'surat_keterangan_kelahiran' => 'Surat Keterangan Kelahiran',
            'surat_keterangan_kematian' => 'Surat Keterangan Kematian',
            'surat_pengantar_nikah' => 'Surat Pengantar Nikah',
            'surat_keterangan_penghasilan' => 'Surat Keterangan Penghasilan',
            'surat_keterangan_belum_menikah' => 'Surat Keterangan Belum Menikah',
            'surat_keterangan_ahli_waris' => 'Surat Keterangan Ahli Waris',
            'surat_rekomendasi' => 'Surat Rekomendasi'
        ];
        
        $label = $serviceTypeLabels[$this->service_type] ?? str_replace('_', ' ', ucwords($this->service_type, '_'));
        
        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">' . $label . '</span>';
    }

    public function getPriorityBadgeAttribute()
    {
        $priorityConfig = [
            'low' => ['class' => 'bg-gray-100 text-gray-800', 'label' => 'Rendah'],
            'normal' => ['class' => 'bg-blue-100 text-blue-800', 'label' => 'Normal'],
            'high' => ['class' => 'bg-orange-100 text-orange-800', 'label' => 'Tinggi'],
            'urgent' => ['class' => 'bg-red-100 text-red-800', 'label' => 'Mendesak']
        ];
        
        $config = $priorityConfig[$this->priority] ?? ['class' => 'bg-blue-100 text-blue-800', 'label' => ucfirst($this->priority)];
        
        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $config['class'] . '">' . $config['label'] . '</span>';
    }

    // Methods
    public function canBeProcessed()
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    public function canBeApproved()
    {
        return $this->status === 'processing';
    }

    public function canBeRejected()
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    public function markAsProcessing($userId = null)
    {
        $this->update([
            'status' => 'processing',
            'processed_at' => now(),
            'processed_by' => $userId ?? auth()->id()
        ]);
    }

    public function markAsApproved($userId = null)
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $userId ?? auth()->id()
        ]);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
    }

    public function markAsRejected($reason, $userId = null)
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'processed_by' => $userId ?? auth()->id(),
            'processed_at' => now()
        ]);
    }
}
