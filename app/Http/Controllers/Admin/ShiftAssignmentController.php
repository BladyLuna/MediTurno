<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreShiftAssignmentRequest;
use App\Http\Requests\Admin\UpdateShiftAssignmentRequest;
use App\Models\HospitalService;
use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use App\Models\Staff;
use App\Services\AuditLogService;
use App\Services\ShiftTimeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ShiftAssignmentController extends Controller
{
    public function __construct(
        private readonly AuditLogService $auditLogService,
        private readonly ShiftTimeService $shiftTimeService
    ) {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', ShiftAssignment::class);

        $shiftAssignments = ShiftAssignment::query()
            ->with(['staff', 'hospitalService', 'serviceShiftTemplate.shiftTemplate'])
            ->when($request->filled('staff_id'), fn ($query) => $query->where('staff_id', $request->integer('staff_id')))
            ->when($request->filled('hospital_service_id'), fn ($query) => $query->where('hospital_service_id', $request->integer('hospital_service_id')))
            ->when($request->filled('assignment_date'), fn ($query) => $query->whereDate('assignment_date', $request->input('assignment_date')))
            ->latest('assignment_date')
            ->latest('start_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.shift-assignments.index', [
            'shiftAssignments' => $shiftAssignments,
            'staffOptions' => $this->staffOptions(),
            'hospitalServices' => $this->hospitalServiceOptions(),
            'filters' => $request->only(['staff_id', 'hospital_service_id', 'assignment_date']),
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', ShiftAssignment::class);

        return view('admin.shift-assignments.create', $this->formOptions());
    }

    public function store(StoreShiftAssignmentRequest $request): RedirectResponse
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
            ->route('admin.shift-assignments.index')
            ->with('success', 'Asignación creada correctamente.');
    }

    public function edit(Request $request, ShiftAssignment $shiftAssignment): View
    {
        $this->authorize('update', $shiftAssignment);

        return view('admin.shift-assignments.edit', [
            'shiftAssignment' => $shiftAssignment,
            ...$this->formOptions(),
        ]);
    }

    public function update(UpdateShiftAssignmentRequest $request, ShiftAssignment $shiftAssignment): RedirectResponse
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
            ->route('admin.shift-assignments.index')
            ->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy(Request $request, ShiftAssignment $shiftAssignment): RedirectResponse
    {
        $this->authorize('delete', $shiftAssignment);

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
            ->route('admin.shift-assignments.index')
            ->with('success', 'Asignación cancelada correctamente.');
    }

    /**
     * @return array<string, mixed>
     */
    private function formOptions(): array
    {
        return [
            'staffOptions' => $this->staffOptions(),
            'hospitalServices' => $this->hospitalServiceOptions(),
            'serviceShiftTemplates' => $this->serviceShiftTemplateOptions(),
        ];
    }

    private function staffOptions()
    {
        return Staff::query()
            ->with('hospitalService')
            ->where('active', true)
            ->orderBy('full_name')
            ->get(['id', 'full_name', 'ci', 'hospital_service_id']);
    }

    private function hospitalServiceOptions()
    {
        return HospitalService::query()
            ->where('active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    private function serviceShiftTemplateOptions()
    {
        return ServiceShiftTemplate::query()
            ->with(['hospitalService', 'shiftTemplate'])
            ->where('active', true)
            ->orderBy('hospital_service_id')
            ->get();
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
