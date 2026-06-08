<?php

namespace App\Http\Controllers\ServiceManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceManager\DestroyServiceAssignmentRequest;
use App\Http\Requests\ServiceManager\ServiceAssignmentFilterRequest;
use App\Http\Requests\ServiceManager\StoreServiceAssignmentRequest;
use App\Http\Requests\ServiceManager\UpdateServiceAssignmentRequest;
use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use App\Services\AuditLogService;
use App\Services\ShiftTimeService;
use App\Services\UserScopeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ServiceAssignmentController extends Controller
{
    public function __construct(
        private readonly AuditLogService $auditLogService,
        private readonly ShiftTimeService $shiftTimeService,
        private readonly UserScopeService $userScopeService
    ) {
    }

    public function index(ServiceAssignmentFilterRequest $request): View
    {
        $filters = $request->validated();
        $serviceIds = $this->userScopeService->managedHospitalServiceIds($request->user());

        $shiftAssignments = ShiftAssignment::query()
            ->with(['staff', 'hospitalService', 'serviceShiftTemplate.shiftTemplate'])
            ->when($serviceIds === [], fn ($query) => $query->whereRaw('0 = 1'))
            ->when($serviceIds !== [], fn ($query) => $query->whereIn('hospital_service_id', $serviceIds))
            ->when($filters['staff_id'] ?? null, fn ($query, $staffId) => $query->where('staff_id', $staffId))
            ->when($filters['hospital_service_id'] ?? null, fn ($query, $serviceId) => $query->where('hospital_service_id', $serviceId))
            ->when($filters['assignment_date'] ?? null, fn ($query, $date) => $query->whereDate('assignment_date', $date))
            ->latest('assignment_date')
            ->latest('start_at')
            ->paginate(10)
            ->withQueryString();

        return view('service-manager.shift-assignments.index', [
            'shiftAssignments' => $shiftAssignments,
            'staffOptions' => $this->userScopeService->managedStaff($request->user()),
            'hospitalServices' => $this->userScopeService->managedHospitalServices($request->user()),
            'filters' => $filters,
            'notice' => $serviceIds === [] ? 'No tienes servicios asociados como jefe de servicio.' : null,
        ]);
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->role === \App\Models\User::ROLE_SERVICE_MANAGER, 403);

        return view('service-manager.shift-assignments.create', $this->formOptions($request));
    }

    public function store(StoreServiceAssignmentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $serviceShiftTemplate = ServiceShiftTemplate::query()
            ->with('shiftTemplate')
            ->findOrFail($data['service_shift_template_id']);
        $interval = $this->shiftTimeService->calculateInterval($data['assignment_date'], $serviceShiftTemplate);

        DB::transaction(function () use ($data, $interval, $request): void {
            $shiftAssignment = ShiftAssignment::create([
                ...$data,
                'start_at' => $interval['start_at'],
                'end_at' => $interval['end_at'],
                'status' => ShiftAssignment::STATUS_ASSIGNED,
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
            ]);

            $this->auditLogService->record('created', $shiftAssignment, null, $this->auditableValues($shiftAssignment), $request);
        });

        return redirect()
            ->route('service-assignments.index')
            ->with('success', 'Asignación creada correctamente.');
    }

    public function edit(Request $request, ShiftAssignment $shiftAssignment): View
    {
        abort_unless($this->userScopeService->userCanOperateAssignment($request->user(), $shiftAssignment), 403);

        return view('service-manager.shift-assignments.edit', [
            'shiftAssignment' => $shiftAssignment,
            ...$this->formOptions($request),
        ]);
    }

    public function update(UpdateServiceAssignmentRequest $request, ShiftAssignment $shiftAssignment): RedirectResponse
    {
        $data = $request->validated();
        $serviceShiftTemplate = ServiceShiftTemplate::query()
            ->with('shiftTemplate')
            ->findOrFail($data['service_shift_template_id']);
        $interval = $this->shiftTimeService->calculateInterval($data['assignment_date'], $serviceShiftTemplate);

        DB::transaction(function () use ($data, $interval, $request, $shiftAssignment): void {
            $oldValues = $this->auditableValues($shiftAssignment);

            $shiftAssignment->fill([
                ...$data,
                'start_at' => $interval['start_at'],
                'end_at' => $interval['end_at'],
                'status' => ShiftAssignment::STATUS_CHANGED,
                'updated_by' => $request->user()->id,
            ]);
            $shiftAssignment->save();

            $this->auditLogService->record('updated', $shiftAssignment, $oldValues, $this->auditableValues($shiftAssignment), $request);
        });

        return redirect()
            ->route('service-assignments.index')
            ->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy(DestroyServiceAssignmentRequest $request, ShiftAssignment $shiftAssignment): RedirectResponse
    {
        DB::transaction(function () use ($request, $shiftAssignment): void {
            $oldValues = $this->auditableValues($shiftAssignment);

            $shiftAssignment->forceFill([
                'status' => ShiftAssignment::STATUS_CANCELLED,
                'updated_by' => $request->user()->id,
            ])->save();

            $newValues = $this->auditableValues($shiftAssignment);
            $shiftAssignment->delete();

            $this->auditLogService->record('cancelled/deleted', $shiftAssignment, $oldValues, $newValues, $request);
        });

        return redirect()
            ->route('service-assignments.index')
            ->with('success', 'Asignación cancelada correctamente.');
    }

    /**
     * @return array<string, mixed>
     */
    private function formOptions(Request $request): array
    {
        return [
            'staffOptions' => $this->userScopeService->managedStaff($request->user()),
            'hospitalServices' => $this->userScopeService->managedHospitalServices($request->user()),
            'serviceShiftTemplates' => $this->userScopeService->managedServiceShiftTemplates($request->user()),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function auditableValues(ShiftAssignment $shiftAssignment): array
    {
        return $shiftAssignment->only([
            'id',
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
        ]);
    }
}
