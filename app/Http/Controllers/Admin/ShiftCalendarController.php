<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CalendarFilterRequest;
use App\Models\HospitalService;
use App\Models\ShiftAssignment;
use App\Models\Staff;
use App\Services\ShiftCalendarService;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ShiftCalendarController extends Controller
{
    public function __construct(private readonly ShiftCalendarService $shiftCalendarService)
    {
    }

    public function index(CalendarFilterRequest $request): View
    {
        $this->authorize('viewAny', ShiftAssignment::class);

        $filters = $request->validated();
        $currentMonth = $this->currentMonth($filters['month'] ?? null);

        return view('admin.calendar.index', [
            'filters' => $filters,
            'currentMonth' => $currentMonth,
            'previousMonth' => $currentMonth->subMonth()->format('Y-m'),
            'nextMonth' => $currentMonth->addMonth()->format('Y-m'),
            'hospitalServices' => $this->hospitalServiceOptions(),
            'staffOptions' => $this->staffOptions(),
        ]);
    }

    public function events(CalendarFilterRequest $request): JsonResponse
    {
        $this->authorize('viewAny', ShiftAssignment::class);

        $filters = $request->validated();
        $range = $this->shiftCalendarService->rangeFromFilters($filters);

        return response()->json($this->shiftCalendarService->events(
            $range['start'],
            $range['end'],
            $filters
        ));
    }

    private function currentMonth(?string $month): CarbonImmutable
    {
        if ($month) {
            return CarbonImmutable::createFromFormat('Y-m-d', $month . '-01')->startOfMonth();
        }

        return CarbonImmutable::now()->startOfMonth();
    }

    private function hospitalServiceOptions()
    {
        return HospitalService::query()
            ->where('active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    private function staffOptions()
    {
        return Staff::query()
            ->with('hospitalService')
            ->where('active', true)
            ->orderBy('full_name')
            ->get(['id', 'full_name', 'ci', 'hospital_service_id']);
    }
}
