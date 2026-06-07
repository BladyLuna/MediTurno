<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'start_time',
        'end_time',
        'color',
        'is_working_shift',
        'active',
    ];

    protected $casts = [
        'is_working_shift' => 'boolean',
        'active' => 'boolean',
    ];

    public function serviceShiftTemplates(): HasMany
    {
        return $this->hasMany(ServiceShiftTemplate::class);
    }
}
