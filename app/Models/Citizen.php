<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Citizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'kk_number',
        'name',
        'birth_date',
        'birth_place',
        'gender',
        'religion',
        'marital_status',
        'occupation',
        'education',
        'address',
        'village_id',
        'rt',
        'rw',
        'postal_code',
        'phone',
        'email',
        'photo_path',
        'family_members',
        'is_active',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'family_members' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    public function scopeByVillage($query, $villageId)
    {
        return $query->where('village_id', $villageId);
    }

    // Accessors
    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address;
        if ($this->rt) $address .= ", RT {$this->rt}";
        if ($this->rw) $address .= "/RW {$this->rw}";
        if ($this->village) $address .= ", {$this->village->name}";
        return $address;
    }
}
