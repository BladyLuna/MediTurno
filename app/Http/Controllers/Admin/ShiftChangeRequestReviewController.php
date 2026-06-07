<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewShiftChangeRequestRequest;
use App\Models\AuditLog;
use App\Models\ShiftChangeRequest;
use App\Models\User;
use App\Services\ShiftChangeRequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShiftChangeRequestReviewController extends Controller
{
    public function __construct(private readonly ShiftChangeRequestService $shiftChangeRequestService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', ShiftChangeRequest::class);

        $shiftChangeRequests = ShiftChangeRequest::query()
            ->with(['shiftAssignment.staff', 'shiftAssignment.hospitalService', 'requestedBy'])
            ->when($request->user()->role === User::ROLE_SERVICE_MANAGER, function ($query) use ($request): void {
                $query->whereHas('shiftAssignment', function ($assignmentQuery) use ($request): void {
                    $assignmentQuery->whereIn('hospital_service_id', $request->user()->serviceManagers()->pluck('hospital_service_id'));
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.shift-change-requests.index', [
            'shiftChangeRequests' => $shiftChangeRequests,
        ]);
    }

    public function show(Request $request, ShiftChangeRequest $shiftChangeRequest): View
    {
        $this->authorize('view', $shiftChangeRequest);

        return view('admin.shift-change-requests.show', [
            'shiftChangeRequest' => $shiftChangeRequest->load(['shiftAssignment.staff', 'shiftAssignment.hospitalService', 'shiftAssignment.serviceShiftTemplate.shiftTemplate', 'requestedBy', 'reviewedBy']),
            'auditLogs' => $this->auditLogs($shiftChangeRequest),
        ]);
    }

    public function approve(ReviewShiftChangeRequestRequest $request, ShiftChangeRequest $shiftChangeRequest): RedirectResponse
    {
        $this->shiftChangeRequestService->approve($shiftChangeRequest, $request->user(), $request->validated('review_notes'), $request);

        return redirect()
            ->route('admin.shift-change-requests.show', $shiftChangeRequest)
            ->with('success', 'Solicitud aprobada correctamente.');
    }

    public function reject(ReviewShiftChangeRequestRequest $request, ShiftChangeRequest $shiftChangeRequest): RedirectResponse
    {
        $this->shiftChangeRequestService->reject($shiftChangeRequest, $request->user(), $request->validated('review_notes'), $request);

        return redirect()
            ->route('admin.shift-change-requests.show', $shiftChangeRequest)
            ->with('success', 'Solicitud rechazada correctamente.');
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
