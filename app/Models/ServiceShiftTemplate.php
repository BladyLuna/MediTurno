<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceShiftTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospital_service_id',
        'shift_template_id',
        'custom_code',
        'custom_name',
        'custom_start_time',
        'custom_end_time',
        'custom_color',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function hospitalService(): BelongsTo
    {
        return $this->belongsTo(HospitalService::class);
    }

    public function shiftTemplate(): BelongsTo
    {
        return $this->belongsTo(ShiftTemplate::class);
    }

    public function shiftAssignments(): HasMany
    {
        return $this->hasMany(ShiftAssignment::class);
    }
}
