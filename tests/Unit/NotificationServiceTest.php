<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_internal_notification_with_data(): void
    {
        $user = User::factory()->create();

        $notification = app(NotificationService::class)->notify(
            $user,
            'test_type',
            'Título',
            'Mensaje',
            ['shift_change_request_id' => 10]
        );

        $this->assertSame($user->id, $notification->user_id);
        $this->assertSame('test_type', $notification->type);
        $this->assertSame(10, $notification->data['shift_change_request_id']);
    }

    public function test_marks_notification_as_read(): void
    {
        $user = User::factory()->create();
        $notification = app(NotificationService::class)->notify($user, 'test', 'Título', 'Mensaje');

        app(NotificationService::class)->markAsRead($notification);

        $this->assertNotNull($notification->fresh()->read_at);
    }
}
