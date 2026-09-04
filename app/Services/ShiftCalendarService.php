<?php

namespace App\Services;

use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

class ShiftCalendarService
{
    /**
     * @param  array<string, mixed>  $filters
     * @param  array<string, mixed>  $scope
     * @return array<int, array<string, mixed>>
     */
    public function events(CarbonInterface $start, CarbonInterface $end, array $filters = [], array $scope = []): array
    {
        return $this->assignments($start, $end, $filters, $scope)
            ->map(fn (ShiftAssignment $assignment) => $this->toEvent($assignment))
            ->values()
            ->all();
    }

    /**
     * @param  array<string, mixed>  $filters
     * @param  array<string, mixed>  $scope
     * @return \Illuminate\Support\Collection<int, \App\Models\ShiftAssignment>
     */
    public function assignments(CarbonInterface $start, CarbonInterface $end, array $filters = [], array $scope = []): Collection
    {
        return ShiftAssignment::query()
            ->with(['staff', 'hospitalService', 'serviceShiftTemplate.shiftTemplate'])
            ->whereIn('status', [
                ShiftAssignment::STATUS_ASSIGNED,
                ShiftAssignment::STATUS_CHANGED,
            ])
            ->where('start_at', '<', $end)
            ->where('end_at', '>', $start)
            ->when(array_key_exists('hospital_service_ids', $scope), function ($query) use ($scope): void {
                $serviceIds = $scope['hospital_service_ids'];

                if ($serviceIds === []) {
                    $query->whereKey(0);

                    return;
                }

                $query->whereIn('hospital_service_id', $serviceIds);
            })
            ->when($scope['staff_id'] ?? null, fn ($query, $staffId) => $query->where('staff_id', $staffId))
            ->when($filters['hospital_service_id'] ?? null, fn ($query, $serviceId) => $query->where('hospital_service_id', $serviceId))
            ->when($filters['staff_id'] ?? null, fn ($query, $staffId) => $query->where('staff_id', $staffId))
            ->orderBy('start_at')
            ->get();
    }

    /**
     * @return array{start: \Carbon\CarbonImmutable, end: \Carbon\CarbonImmutable}
     */
    public function rangeFromFilters(array $filters): array
    {
        if (! empty($filters['start']) && ! empty($filters['end'])) {
            return [
                'start' => CarbonImmutable::parse($filters['start']),
                'end' => CarbonImmutable::parse($filters['end']),
            ];
        }

        $month = empty($filters['month'])
            ? CarbonImmutable::now()->format('Y-m')
            : $filters['month'];

        $start = CarbonImmutable::createFromFormat('Y-m-d', $month . '-01')->startOfMonth();

        return [
            'start' => $start,
            'end' => $start->addMonth(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toEvent(ShiftAssignment $assignment): array
    {
        $serviceShiftTemplate = $assignment->serviceShiftTemplate;
        $color = $this->effectiveColor($serviceShiftTemplate);
        $shiftName = $this->effectiveName($serviceShiftTemplate);
        $shiftCode = $this->effectiveCode($serviceShiftTemplate);

        return [
            'id' => (string) $assignment->id,
            'title' => trim(($assignment->staff?->full_name ?? 'Personal') . ' - ' . $shiftName),
            'start' => $assignment->start_at?->format('Y-m-d\TH:i:s'),
            'end' => $assignment->end_at?->format('Y-m-d\TH:i:s'),
            'allDay' => false,
            'backgroundColor' => $color,
            'borderColor' => $color,
            'extendedProps' => [
                'staff_name' => $assignment->staff?->full_name,
                'hospital_service_name' => $assignment->hospitalService?->name,
                'shift_name' => $shiftName,
                'shift_code' => $shiftCode,
                'start_time' => $assignment->start_at?->format('Y-m-d H:i'),
                'end_time' => $assignment->end_at?->format('Y-m-d H:i'),
                'status' => $assignment->status,
                'notes' => $assignment->notes,
            ],
        ];
    }

    public function effectiveColor(ServiceShiftTemplate $serviceShiftTemplate): string
    {
        return $serviceShiftTemplate->custom_color
            ?: ($serviceShiftTemplate->shiftTemplate?->color ?: '#0d6efd');
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
}
