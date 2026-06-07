<?php

namespace App\Policies;

use App\Models\ShiftChangeRequest;
use App\Models\User;

class ShiftChangeRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [User::ROLE_ADMIN, User::ROLE_SERVICE_MANAGER, User::ROLE_STAFF], true);
    }

    public function view(User $user, ShiftChangeRequest $shiftChangeRequest): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->role === User::ROLE_STAFF) {
            return $shiftChangeRequest->requested_by === $user->id;
        }

        return $user->role === User::ROLE_SERVICE_MANAGER
            && $user->managesHospitalService($shiftChangeRequest->shiftAssignment->hospital_service_id);
    }

    public function create(User $user): bool
    {
        return $user->role === User::ROLE_STAFF;
    }

    public function cancel(User $user, ShiftChangeRequest $shiftChangeRequest): bool
    {
        return $shiftChangeRequest->status === ShiftChangeRequest::STATUS_PENDING
            && $shiftChangeRequest->requested_by === $user->id;
    }

    public function review(User $user, ShiftChangeRequest $shiftChangeRequest): bool
    {
        if ($shiftChangeRequest->status !== ShiftChangeRequest::STATUS_PENDING) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        return $user->role === User::ROLE_SERVICE_MANAGER
            && $user->managesHospitalService($shiftChangeRequest->shiftAssignment->hospital_service_id);
    }
}
