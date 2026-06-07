<?php

namespace App\Services;

use App\Models\ShiftAssignment;
use Carbon\CarbonInterface;

class ShiftConflictService
{
    public function hasConflict(
        int $staffId,
        CarbonInterface $startAt,
        CarbonInterface $endAt,
        ?int $ignoreAssignmentId = null
    ): bool {
        return $this->queryConflicts($staffId, $startAt, $endAt, $ignoreAssignmentId)->exists();
    }

    public function findConflict(
        int $staffId,
        CarbonInterface $startAt,
        CarbonInterface $endAt,
        ?int $ignoreAssignmentId = null
    ): ?ShiftAssignment {
        return $this->queryConflicts($staffId, $startAt, $endAt, $ignoreAssignmentId)->first();
    }

    private function queryConflicts(
        int $staffId,
        CarbonInterface $startAt,
        CarbonInterface $endAt,
        ?int $ignoreAssignmentId = null
    ) {
        return ShiftAssignment::query()
            ->where('staff_id', $staffId)
            ->where('status', '!=', ShiftAssignment::STATUS_CANCELLED)
            ->where('start_at', '<', $endAt)
            ->where('end_at', '>', $startAt)
            ->when($ignoreAssignmentId, fn ($query) => $query->whereKeyNot($ignoreAssignmentId));
    }
}
