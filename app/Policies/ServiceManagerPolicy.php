<?php

namespace App\Policies;

use App\Models\ServiceManager;
use App\Models\User;

class ServiceManagerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, ServiceManager $serviceManager): bool
    {
        return $user->isAdmin();
    }
}
