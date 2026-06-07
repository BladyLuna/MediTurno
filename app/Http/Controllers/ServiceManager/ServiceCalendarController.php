<?php

namespace App\Http\Controllers\ServiceManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceManager\ServiceCalendarFilterRequest;
use App\Services\ShiftCalendarService;
use App\Services\UserScopeService;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ServiceCalendarController extends Controller
{
    public function __construct(
        private readonly ShiftCalendarService $shiftCalendarService,
        private readonly UserScopeService $userScopeService
    ) {
    }

    public function index(ServiceCalendarFilterRequest $request): View
    {
        $filters = $request->validated();
        $currentMonth = $this->currentMonth($filters['month'] ?? null);
        $serviceIds = $this->userScopeService->managedHospitalServiceIds($request->user());

        return view('admin.calendar.index', [
            'filters' => $filters,
            'currentMonth' => $currentMonth,
            'previousMonth' => $currentMonth->subMonth()->format('Y-m'),
            'nextMonth' => $currentMonth->addMonth()->format('Y-m'),
            'hospitalServices' => $this->userScopeService->managedHospitalServices($request->user()),
            'staffOptions' => $this->userScopeService->managedStaff($request->user()),
            'pageTitle' => 'Calendario de servicios',
            'pageSubtitle' => 'Visualización de asignaciones de los servicios que administras.',
            'indexRoute' => 'service-calendar.index',
            'eventsRoute' => 'service-calendar.events',
            'notice' => $serviceIds === [] ? 'No tienes servicios asociados como jefe de servicio.' : null,
        ]);
    }

    public function events(ServiceCalendarFilterRequest $request): JsonResponse
    {
        $filters = $request->validated();
        $range = $this->shiftCalendarService->rangeFromFilters($filters);

        return response()->json($this->shiftCalendarService->events(
            $range['start'],
            $range['end'],
            $filters,
            ['hospital_service_ids' => $this->userScopeService->managedHospitalServiceIds($request->user())]
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
