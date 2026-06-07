<?php

namespace App\Services;

use App\Models\ServiceShiftTemplate;
use Carbon\Carbon;

class ShiftTimeService
{
    /**
     * @return array{0: string, 1: string}
     */
    public function resolveEffectiveTimes(ServiceShiftTemplate $serviceShiftTemplate): array
    {
        $serviceShiftTemplate->loadMissing('shiftTemplate');

        $startTime = $serviceShiftTemplate->custom_start_time ?: $serviceShiftTemplate->shiftTemplate->start_time;
        $endTime = $serviceShiftTemplate->custom_end_time ?: $serviceShiftTemplate->shiftTemplate->end_time;

        return [
            substr($startTime, 0, 5),
            substr($endTime, 0, 5),
        ];
    }

    /**
     * @return array{start_at: \Carbon\Carbon, end_at: \Carbon\Carbon}
     */
    public function calculateInterval(string $assignmentDate, ServiceShiftTemplate $serviceShiftTemplate): array
    {
        [$startTime, $endTime] = $this->resolveEffectiveTimes($serviceShiftTemplate);

        $startAt = Carbon::parse($assignmentDate . ' ' . $startTime);
        $endAt = Carbon::parse($assignmentDate . ' ' . $endTime);

        if ($endAt->lessThanOrEqualTo($startAt)) {
            $endAt->addDay();
        }

        return [
            'start_at' => $startAt,
            'end_at' => $endAt,
        ];
    }
}
