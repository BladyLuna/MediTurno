<?php

namespace App\Policies;

use App\Models\ServiceShiftTemplate;
use App\Models\User;

class ServiceShiftTemplatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, ServiceShiftTemplate $serviceShiftTemplate): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, ServiceShiftTemplate $serviceShiftTemplate): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, ServiceShiftTemplate $serviceShiftTemplate): bool
    {
        return $user->isAdmin();
    }
}
