<?php

namespace App\Services;

use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class ReportService
{
    /**
     * @param  array<string, mixed>  $filters
     * @param  array<string, mixed>  $scope
     * @return array<string, mixed>
     */
    public function build(array $filters, array $scope = []): array
    {
        $filters = $this->normalizeFilters($filters);
        $assignments = $this->assignments($filters, $scope);
        $details = $assignments
            ->map(fn (ShiftAssignment $assignment) => $this->detailRow($assignment))
            ->values();

        return [
            'filters' => $filters,
            'summary' => $this->summary($details),
            'grouped' => $this->groupedSummary($details, $filters['group_by']),
            'details' => $details,
        ];
    }

    /**
     * @param  array<string, mixed>  $filters
     * @return array<string, mixed>
     */
    public function normalizeFilters(array $filters): array
    {
        $today = CarbonImmutable::now();
        $startDate = empty($filters['start_date'])
            ? $today->startOfMonth()
            : CarbonImmutable::parse($filters['start_date'])->startOfDay();
        $endDate = empty($filters['end_date'])
            ? $today->endOfMonth()->startOfDay()
            : CarbonImmutable::parse($filters['end_date'])->startOfDay();

        return [
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'hospital_service_id' => $filters['hospital_service_id'] ?? null,
            'staff_id' => $filters['staff_id'] ?? null,
            'group_by' => $filters['group_by'] ?? 'service',
        ];
    }

    /**
     * @param  array<string, mixed>  $filters
     * @param  array<string, mixed>  $scope
     * @return \Illuminate\Support\Collection<int, \App\Models\ShiftAssignment>
     */
    public function assignments(array $filters, array $scope = []): Collection
    {
        $filters = $this->normalizeFilters($filters);
        $startAt = CarbonImmutable::parse($filters['start_date'])->startOfDay();
        $endExclusive = CarbonImmutable::parse($filters['end_date'])->addDay()->startOfDay();

        return ShiftAssignment::query()
            ->with(['staff', 'hospitalService', 'serviceShiftTemplate.shiftTemplate'])
            ->whereIn('status', [
                ShiftAssignment::STATUS_ASSIGNED,
                ShiftAssignment::STATUS_CHANGED,
            ])
            ->where('start_at', '<', $endExclusive)
            ->where('end_at', '>', $startAt)
            ->when(array_key_exists('hospital_service_ids', $scope), function ($query) use ($scope): void {
                $serviceIds = $scope['hospital_service_ids'];

                if ($serviceIds === []) {
                    $query->whereRaw('0 = 1');

                    return;
                }

                $query->whereIn('hospital_service_id', $serviceIds);
            })
            ->when($scope['staff_id'] ?? null, fn ($query, $staffId) => $query->where('staff_id', $staffId))
            ->when($filters['hospital_service_id'], fn ($query, $serviceId) => $query->where('hospital_service_id', $serviceId))
            ->when($filters['staff_id'], fn ($query, $staffId) => $query->where('staff_id', $staffId))
            ->orderBy('start_at')
            ->get();
    }

    /**
     * @return array<string, mixed>
     */
    public function detailRow(ShiftAssignment $assignment): array
    {
        $serviceShiftTemplate = $assignment->serviceShiftTemplate;
        $minutes = $assignment->start_at->diffInMinutes($assignment->end_at);

        return [
            'id' => $assignment->id,
            'assignment_date' => $assignment->assignment_date?->format('Y-m-d'),
            'staff_id' => $assignment->staff_id,
            'staff_name' => $assignment->staff?->full_name,
            'staff_ci' => $assignment->staff?->ci,
            'hospital_service_id' => $assignment->hospital_service_id,
            'hospital_service_name' => $assignment->hospitalService?->name,
            'shift_name' => $this->effectiveName($serviceShiftTemplate),
            'shift_code' => $this->effectiveCode($serviceShiftTemplate),
            'status' => $assignment->status,
            'start_at' => $assignment->start_at?->format('Y-m-d H:i'),
            'end_at' => $assignment->end_at?->format('Y-m-d H:i'),
            'minutes' => $minutes,
            'hours_decimal' => round($minutes / 60, 2),
            'duration' => $this->formatMinutes($minutes),
        ];
    }

    public function effectiveName(ServiceShiftTemplate $serviceShiftTemplate): string
    {
        return $serviceShiftTemplate->custom_name
            ?: ($serviceShiftTemplate->shiftTemplate?->name ?: 'Turno');
    }

    public function effectiveCode(ServiceShiftTemplate $serviceShiftTemplate): string
    {
        return $serviceShiftTemplate->custom_code
            ?: ($serviceShiftTemplate->shiftTemplate?->code ?: '');
    }

    public function formatMinutes(int $minutes): string
    {
        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        return sprintf('%02d:%02d', $hours, $remainingMinutes);
    }

    /**
     * @param  \Illuminate\Support\Collection<int, array<string, mixed>>  $details
     * @return array<string, mixed>
     */
    private function summary(Collection $details): array
    {
        $minutes = (int) $details->sum('minutes');

        return [
            'assignments_count' => $details->count(),
            'total_minutes' => $minutes,
            'total_hours_decimal' => round($minutes / 60, 2),
            'total_duration' => $this->formatMinutes($minutes),
            'services_count' => $details->pluck('hospital_service_id')->filter()->unique()->count(),
            'staff_count' => $details->pluck('staff_id')->filter()->unique()->count(),
        ];
    }

    /**
     * @param  \Illuminate\Support\Collection<int, array<string, mixed>>  $details
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    private function groupedSummary(Collection $details, string $groupBy): Collection
    {
        $key = $groupBy === 'staff' ? 'staff_id' : 'hospital_service_id';

        return $details
            ->groupBy($key)
            ->map(function (Collection $rows) use ($groupBy): array {
                $minutes = (int) $rows->sum('minutes');
                $first = $rows->first();

                return [
                    'label' => $groupBy === 'staff'
                        ? ($first['staff_name'] ?? 'Personal sin nombre')
                        : ($first['hospital_service_name'] ?? 'Servicio sin nombre'),
                    'secondary' => $groupBy === 'staff'
                        ? trim(($first['staff_ci'] ?? '') . ' - ' . ($first['hospital_service_name'] ?? ''), ' -')
                        : null,
                    'assignments_count' => $rows->count(),
                    'total_minutes' => $minutes,
                    'total_hours_decimal' => round($minutes / 60, 2),
                    'total_duration' => $this->formatMinutes($minutes),
                    'staff_count' => $rows->pluck('staff_id')->filter()->unique()->count(),
                    'shift_breakdown' => $this->shiftBreakdown($rows),
                ];
            })
            ->sortBy('label')
            ->values();
    }

    /**
     * @param  \Illuminate\Support\Collection<int, array<string, mixed>>  $rows
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    private function shiftBreakdown(Collection $rows): Collection
    {
        return $rows
            ->groupBy('shift_name')
            ->map(function (Collection $shiftRows, string $shiftName): array {
                $minutes = (int) $shiftRows->sum('minutes');

                return [
                    'shift_name' => $shiftName,
                    'assignments_count' => $shiftRows->count(),
                    'total_duration' => $this->formatMinutes($minutes),
                ];
            })
            ->sortBy('shift_name')
            ->values();
    }
}
