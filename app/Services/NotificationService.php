<?php

namespace App\Services;

use App\Models\InternalNotification;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
    /**
     * @param  array<string, mixed>|null  $data
     */
    public function notify(User $user, string $type, string $title, string $message, ?array $data = null): InternalNotification
    {
        return InternalNotification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * @param  iterable<int, \App\Models\User>  $users
     * @param  array<string, mixed>|null  $data
     * @return \Illuminate\Support\Collection<int, \App\Models\InternalNotification>
     */
    public function notifyMany(iterable $users, string $type, string $title, string $message, ?array $data = null): Collection
    {
        return collect($users)
            ->unique('id')
            ->map(fn (User $user) => $this->notify($user, $type, $title, $message, $data))
            ->values();
    }

    public function markAsRead(InternalNotification $notification): void
    {
        if ($notification->read_at === null) {
            $notification->forceFill(['read_at' => now()])->save();
        }
    }
}
