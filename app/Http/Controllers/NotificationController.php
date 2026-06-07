<?php

namespace App\Http\Controllers;

use App\Models\InternalNotification;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __construct(private readonly NotificationService $notificationService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', InternalNotification::class);

        $notifications = InternalNotification::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('notifications.index', [
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead(Request $request, InternalNotification $notification): RedirectResponse
    {
        $this->authorize('update', $notification);

        $this->notificationService->markAsRead($notification);

        return redirect()
            ->route('notifications.index')
            ->with('success', 'Notificación marcada como leída.');
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $this->authorize('viewAny', InternalNotification::class);

        InternalNotification::query()
            ->where('user_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()
            ->route('notifications.index')
            ->with('success', 'Notificaciones marcadas como leídas.');
    }
}
