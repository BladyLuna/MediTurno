<?php

namespace App\Policies;

use App\Models\ShiftAssignment;
use App\Models\User;

class ShiftAssignmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, ShiftAssignment $shiftAssignment): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, ShiftAssignment $shiftAssignment): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, ShiftAssignment $shiftAssignment): bool
    {
        return $user->isAdmin();
    }
}
