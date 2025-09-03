<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Village extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'head_name',
        'head_phone',
        'area_size',
        'population_count',
        'description',
        'boundaries',
        'is_active',
    ];

    protected $casts = [
        'area_size' => 'decimal:2',
        'population_count' => 'integer',
        'boundaries' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }

    public function activeCitizens()
    {
        return $this->hasMany(Citizen::class)->where('is_active', true);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getActualPopulationAttribute()
    {
        return $this->activeCitizens()->count();
    }

    public function getMalePopulationAttribute()
    {
        return $this->activeCitizens()->where('gender', 'L')->count();
    }

    public function getFemalePopulationAttribute()
    {
        return $this->activeCitizens()->where('gender', 'P')->count();
    }
}
