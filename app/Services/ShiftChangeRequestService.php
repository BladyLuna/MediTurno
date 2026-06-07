<?php

namespace App\Services;

use App\Models\ShiftAssignment;
use App\Models\ShiftChangeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShiftChangeRequestService
{
    public function __construct(
        private readonly AuditLogService $auditLogService,
        private readonly NotificationService $notificationService
    ) {
    }

    public function create(ShiftAssignment $assignment, User $requestedBy, string $reason, Request $request): ShiftChangeRequest
    {
        return DB::transaction(function () use ($assignment, $requestedBy, $reason, $request): ShiftChangeRequest {
            $changeRequest = ShiftChangeRequest::create([
                'shift_assignment_id' => $assignment->id,
                'requested_by' => $requestedBy->id,
                'reason' => $reason,
                'status' => ShiftChangeRequest::STATUS_PENDING,
            ]);

            $this->auditLogService->record('created', $changeRequest, null, $this->auditableValues($changeRequest), $request);
            $this->notificationService->notifyMany(
                $this->reviewersFor($assignment),
                'shift_change_request_created',
                'Nueva solicitud de cambio de turno',
                $requestedBy->name . ' registró una solicitud de cambio de turno.',
                $this->notificationData($changeRequest)
            );

            return $changeRequest;
        });
    }

    public function cancel(ShiftChangeRequest $changeRequest, User $cancelledBy, Request $request): void
    {
        DB::transaction(function () use ($changeRequest, $cancelledBy, $request): void {
            $oldValues = $this->auditableValues($changeRequest);

            $changeRequest->forceFill([
                'status' => ShiftChangeRequest::STATUS_CANCELLED,
            ])->save();

            $this->auditLogService->record('cancelled', $changeRequest, $oldValues, $this->auditableValues($changeRequest), $request);
            $this->notificationService->notifyMany(
                $this->reviewersFor($changeRequest->shiftAssignment),
                'shift_change_request_cancelled',
                'Solicitud de cambio cancelada',
                $cancelledBy->name . ' canceló una solicitud de cambio de turno.',
                $this->notificationData($changeRequest)
            );
        });
    }

    public function approve(ShiftChangeRequest $changeRequest, User $reviewedBy, ?string $reviewNotes, Request $request): void
    {
        $this->review($changeRequest, $reviewedBy, ShiftChangeRequest::STATUS_APPROVED, 'approved', $reviewNotes, $request);
    }

    public function reject(ShiftChangeRequest $changeRequest, User $reviewedBy, ?string $reviewNotes, Request $request): void
    {
        $this->review($changeRequest, $reviewedBy, ShiftChangeRequest::STATUS_REJECTED, 'rejected', $reviewNotes, $request);
    }

    private function review(ShiftChangeRequest $changeRequest, User $reviewedBy, string $status, string $action, ?string $reviewNotes, Request $request): void
    {
        DB::transaction(function () use ($changeRequest, $reviewedBy, $status, $action, $reviewNotes, $request): void {
            $oldValues = $this->auditableValues($changeRequest);

            $changeRequest->forceFill([
                'status' => $status,
                'reviewed_by' => $reviewedBy->id,
                'review_notes' => $reviewNotes,
            ])->save();

            $this->auditLogService->record($action, $changeRequest, $oldValues, $this->auditableValues($changeRequest), $request);
            $this->notificationService->notify(
                $changeRequest->requestedBy,
                'shift_change_request_' . $status,
                $status === ShiftChangeRequest::STATUS_APPROVED ? 'Solicitud aprobada' : 'Solicitud rechazada',
                $reviewedBy->name . ' ' . ($status === ShiftChangeRequest::STATUS_APPROVED ? 'aprobó' : 'rechazó') . ' su solicitud de cambio de turno.',
                $this->notificationData($changeRequest)
            );
        });
    }

    /**
     * @return array<string, mixed>
     */
    private function auditableValues(ShiftChangeRequest $changeRequest): array
    {
        return $changeRequest->only([
            'id',
            'shift_assignment_id',
            'requested_by',
            'reviewed_by',
            'reason',
            'status',
            'review_notes',
        ]);
    }

    /**
     * @return array<string, int>
     */
    private function notificationData(ShiftChangeRequest $changeRequest): array
    {
        return [
            'shift_change_request_id' => $changeRequest->id,
            'shift_assignment_id' => $changeRequest->shift_assignment_id,
        ];
    }

    private function reviewersFor(ShiftAssignment $assignment)
    {
        $admins = User::query()
            ->where('role', User::ROLE_ADMIN)
            ->where('active', true)
            ->get();

        $managers = User::query()
            ->where('role', User::ROLE_SERVICE_MANAGER)
            ->where('active', true)
            ->whereHas('serviceManagers', fn ($query) => $query->where('hospital_service_id', $assignment->hospital_service_id))
            ->get();

        return $admins->merge($managers)->unique('id')->values();
    }
}
