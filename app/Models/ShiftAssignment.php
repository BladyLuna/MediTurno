<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftAssignment extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_ASSIGNED = 'assigned';
    public const STATUS_CHANGED = 'changed';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_ASSIGNED,
        self::STATUS_CHANGED,
        self::STATUS_CANCELLED,
    ];

    protected $fillable = [
        'staff_id',
        'hospital_service_id',
        'service_shift_template_id',
        'assignment_date',
        'start_at',
        'end_at',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'assignment_date' => 'date',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function hospitalService(): BelongsTo
    {
        return $this->belongsTo(HospitalService::class);
    }

    public function serviceShiftTemplate(): BelongsTo
    {
        return $this->belongsTo(ServiceShiftTemplate::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function changeRequests(): HasMany
    {
        return $this->hasMany(ShiftChangeRequest::class);
    }
}
