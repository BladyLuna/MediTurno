<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShiftChangeRequestRequest;
use App\Models\AuditLog;
use App\Models\ShiftAssignment;
use App\Models\ShiftChangeRequest;
use App\Services\ShiftChangeRequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShiftChangeRequestController extends Controller
{
    public function __construct(private readonly ShiftChangeRequestService $shiftChangeRequestService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', ShiftChangeRequest::class);

        $shiftChangeRequests = ShiftChangeRequest::query()
            ->with(['shiftAssignment.hospitalService', 'shiftAssignment.serviceShiftTemplate.shiftTemplate'])
            ->where('requested_by', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('shift-change-requests.index', [
            'shiftChangeRequests' => $shiftChangeRequests,
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', ShiftChangeRequest::class);

        $assignments = ShiftAssignment::query()
            ->with(['hospitalService', 'serviceShiftTemplate.shiftTemplate'])
            ->whereHas('staff', fn ($query) => $query->where('user_id', $request->user()->id))
            ->whereIn('status', [ShiftAssignment::STATUS_ASSIGNED, ShiftAssignment::STATUS_CHANGED])
            ->orderByDesc('start_at')
            ->get();

        return view('shift-change-requests.create', [
            'assignments' => $assignments,
        ]);
    }

    public function store(StoreShiftChangeRequestRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $assignment = ShiftAssignment::query()->findOrFail($data['shift_assignment_id']);

        $this->shiftChangeRequestService->create($assignment, $request->user(), $data['reason'], $request);

        return redirect()
            ->route('shift-change-requests.index')
            ->with('success', 'Solicitud de cambio registrada correctamente.');
    }

    public function show(Request $request, ShiftChangeRequest $shiftChangeRequest): View
    {
        $this->authorize('view', $shiftChangeRequest);

        return view('shift-change-requests.show', [
            'shiftChangeRequest' => $shiftChangeRequest->load(['shiftAssignment.hospitalService', 'shiftAssignment.serviceShiftTemplate.shiftTemplate', 'requestedBy', 'reviewedBy']),
            'auditLogs' => $this->auditLogs($shiftChangeRequest),
        ]);
    }

    public function cancel(Request $request, ShiftChangeRequest $shiftChangeRequest): RedirectResponse
    {
        $this->authorize('cancel', $shiftChangeRequest);

        $this->shiftChangeRequestService->cancel($shiftChangeRequest, $request->user(), $request);

        return redirect()
            ->route('shift-change-requests.show', $shiftChangeRequest)
            ->with('success', 'Solicitud cancelada correctamente.');
    }

    private function auditLogs(ShiftChangeRequest $shiftChangeRequest)
    {
        return AuditLog::query()
            ->where('model_type', ShiftChangeRequest::class)
            ->where('model_id', $shiftChangeRequest->id)
            ->latest()
            ->get();
    }
}
