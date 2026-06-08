<?php

namespace App\Services;

use App\Models\ServiceShiftTemplate;

class ServiceAvailabilityService
{
    public function __construct(
        private readonly ShiftTimeService $shiftTimeService,
        private readonly ShiftConflictService $shiftConflictService
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function check(
        int $staffId,
        string $assignmentDate,
        ServiceShiftTemplate $serviceShiftTemplate,
        ?int $ignoreAssignmentId = null
    ): array {
        $interval = $this->shiftTimeService->calculateInterval($assignmentDate, $serviceShiftTemplate);
        $conflict = $this->shiftConflictService->findConflict(
            $staffId,
            $interval['start_at'],
            $interval['end_at'],
            $ignoreAssignmentId
        );

        return [
            'available' => $conflict === null,
            'conflict' => $conflict,
            'start_at' => $interval['start_at'],
            'end_at' => $interval['end_at'],
        ];
    }
}
