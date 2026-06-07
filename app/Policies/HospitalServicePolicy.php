<?php

namespace App\Policies;

use App\Models\HospitalService;
use App\Models\User;

class HospitalServicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, HospitalService $hospitalService): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, HospitalService $hospitalService): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, HospitalService $hospitalService): bool
    {
        return $user->isAdmin();
    }
}
