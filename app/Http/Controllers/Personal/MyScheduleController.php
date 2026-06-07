<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personal\MyScheduleFilterRequest;
use App\Services\ShiftCalendarService;
use App\Services\UserScopeService;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class MyScheduleController extends Controller
{
    public function __construct(
        private readonly ShiftCalendarService $shiftCalendarService,
        private readonly UserScopeService $userScopeService
    ) {
    }

    public function index(MyScheduleFilterRequest $request): View
    {
        $filters = $request->validated();
        $currentMonth = $this->currentMonth($filters['month'] ?? null);
        $staff = $this->userScopeService->personalStaff($request->user());

        return view('admin.calendar.index', [
            'filters' => $filters,
            'currentMonth' => $currentMonth,
            'previousMonth' => $currentMonth->subMonth()->format('Y-m'),
            'nextMonth' => $currentMonth->addMonth()->format('Y-m'),
            'hospitalServices' => collect(),
            'staffOptions' => collect(),
            'pageTitle' => 'Mis turnos',
            'pageSubtitle' => 'Calendario mensual con tus asignaciones registradas.',
            'indexRoute' => 'my-schedule.index',
            'eventsRoute' => 'my-schedule.events',
            'showServiceFilter' => false,
            'showStaffFilter' => false,
            'notice' => $staff ? null : 'No tienes una ficha de personal asociada. El calendario se muestra sin asignaciones.',
        ]);
    }

    public function events(MyScheduleFilterRequest $request): JsonResponse
    {
        $staff = $this->userScopeService->personalStaff($request->user());

        if (! $staff) {
            return response()->json([]);
        }

        $filters = $request->validated();
        $range = $this->shiftCalendarService->rangeFromFilters($filters);

        return response()->json($this->shiftCalendarService->events(
            $range['start'],
            $range['end'],
            [],
            ['staff_id' => $staff->id]
        ));
    }

    private function currentMonth(?string $month): CarbonImmutable
    {
        if ($month) {
            return CarbonImmutable::createFromFormat('Y-m-d', $month . '-01')->startOfMonth();
        }

        return CarbonImmutable::now()->startOfMonth();
    }
}
