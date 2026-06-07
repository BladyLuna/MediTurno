<?php

namespace App\Policies;

use App\Models\InternalNotification;
use App\Models\User;

class InternalNotificationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isActive();
    }

    public function update(User $user, InternalNotification $internalNotification): bool
    {
        return $internalNotification->user_id === $user->id;
    }
}
