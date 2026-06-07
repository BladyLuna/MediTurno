<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class HospitalService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class);
    }

    public function serviceShiftTemplates(): HasMany
    {
        return $this->hasMany(ServiceShiftTemplate::class);
    }

    public function shiftAssignments(): HasMany
    {
        return $this->hasMany(ShiftAssignment::class);
    }

    public function serviceManagers(): HasMany
    {
        return $this->hasMany(ServiceManager::class);
    }
}
