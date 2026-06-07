<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\HospitalService;
use App\Models\InternalNotification;
use App\Models\ServiceManager;
use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use App\Models\ShiftChangeRequest;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShiftChangeRequestFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    public function test_admin_can_create_service_manager(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $manager = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);
        $service = HospitalService::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.service-managers.store'), [
            'user_id' => $manager->id,
            'hospital_service_id' => $service->id,
        ]);

        $response->assertRedirect(route('admin.service-managers.index'));
        $this->assertDatabaseHas('service_managers', [
            'user_id' => $manager->id,
            'hospital_service_id' => $service->id,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'created',
            'model_type' => ServiceManager::class,
        ]);
    }

    public function test_service_manager_cannot_be_duplicated_for_same_service(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $manager = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);
        $service = HospitalService::factory()->create();
        ServiceManager::factory()->create([
            'user_id' => $manager->id,
            'hospital_service_id' => $service->id,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.service-managers.store'), [
            'user_id' => $manager->id,
            'hospital_service_id' => $service->id,
        ]);

        $response->assertSessionHasErrors('user_id');
    }

    public function test_personal_can_create_shift_change_request_for_own_assignment(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $manager = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);
        $assignment = $this->assignmentForPersonal();
        ServiceManager::factory()->create([
            'user_id' => $manager->id,
            'hospital_service_id' => $assignment->hospital_service_id,
        ]);

        $response = $this->actingAs($assignment->staff->user)->post(route('shift-change-requests.store'), [
            'shift_assignment_id' => $assignment->id,
            'reason' => 'Necesito cambiar este turno por motivos personales.',
        ]);

        $response->assertRedirect(route('shift-change-requests.index'));
        $this->assertDatabaseHas('shift_change_requests', [
            'shift_assignment_id' => $assignment->id,
            'requested_by' => $assignment->staff->user_id,
            'status' => ShiftChangeRequest::STATUS_PENDING,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'created',
            'model_type' => ShiftChangeRequest::class,
        ]);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $admin->id,
            'type' => 'shift_change_request_created',
        ]);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $manager->id,
            'type' => 'shift_change_request_created',
        ]);
    }

    public function test_personal_cannot_create_request_for_other_assignment_or_cancelled_assignment(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_STAFF]);
        $otherAssignment = $this->assignmentForPersonal();
        $cancelledAssignment = $this->assignmentForPersonal(['status' => ShiftAssignment::STATUS_CANCELLED]);

        $other = $this->actingAs($user)->post(route('shift-change-requests.store'), [
            'shift_assignment_id' => $otherAssignment->id,
            'reason' => 'No corresponde.',
        ]);

        $cancelled = $this->actingAs($cancelledAssignment->staff->user)->post(route('shift-change-requests.store'), [
            'shift_assignment_id' => $cancelledAssignment->id,
            'reason' => 'No corresponde.',
        ]);

        $other->assertSessionHasErrors('shift_assignment_id');
        $cancelled->assertSessionHasErrors('shift_assignment_id');
    }

    public function test_service_manager_can_only_review_requests_for_managed_services(): void
    {
        $manager = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);
        $managedAssignment = $this->assignmentForPersonal();
        $otherAssignment = $this->assignmentForPersonal();
        ServiceManager::factory()->create([
            'user_id' => $manager->id,
            'hospital_service_id' => $managedAssignment->hospital_service_id,
        ]);
        $managedRequest = ShiftChangeRequest::factory()->create([
            'shift_assignment_id' => $managedAssignment->id,
            'requested_by' => $managedAssignment->staff->user_id,
        ]);
        $otherRequest = ShiftChangeRequest::factory()->create([
            'shift_assignment_id' => $otherAssignment->id,
            'requested_by' => $otherAssignment->staff->user_id,
        ]);

        $index = $this->actingAs($manager)->get(route('admin.shift-change-requests.index'));
        $managedShow = $this->actingAs($manager)->get(route('admin.shift-change-requests.show', $managedRequest));
        $otherShow = $this->actingAs($manager)->get(route('admin.shift-change-requests.show', $otherRequest));

        $index->assertOk();
        $index->assertSee($managedAssignment->staff->full_name);
        $index->assertDontSee($otherAssignment->staff->full_name);
        $managedShow->assertOk();
        $otherShow->assertForbidden();
    }

    public function test_manager_can_approve_request_without_modifying_assignment(): void
    {
        $manager = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);
        $assignment = $this->assignmentForPersonal();
        ServiceManager::factory()->create([
            'user_id' => $manager->id,
            'hospital_service_id' => $assignment->hospital_service_id,
        ]);
        $changeRequest = ShiftChangeRequest::factory()->create([
            'shift_assignment_id' => $assignment->id,
            'requested_by' => $assignment->staff->user_id,
        ]);

        $response = $this->actingAs($manager)->patch(route('admin.shift-change-requests.approve', $changeRequest), [
            'review_notes' => 'Aprobado administrativamente.',
        ]);

        $response->assertRedirect(route('admin.shift-change-requests.show', $changeRequest));
        $this->assertDatabaseHas('shift_change_requests', [
            'id' => $changeRequest->id,
            'status' => ShiftChangeRequest::STATUS_APPROVED,
            'reviewed_by' => $manager->id,
        ]);
        $this->assertSame(ShiftAssignment::STATUS_ASSIGNED, $assignment->fresh()->status);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'approved',
            'model_type' => ShiftChangeRequest::class,
            'model_id' => $changeRequest->id,
        ]);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $assignment->staff->user_id,
            'type' => 'shift_change_request_approved',
        ]);
    }

    public function test_admin_can_reject_request_and_personal_can_cancel_pending_request(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $assignment = $this->assignmentForPersonal();
        $toReject = ShiftChangeRequest::factory()->create([
            'shift_assignment_id' => $assignment->id,
            'requested_by' => $assignment->staff->user_id,
        ]);
        $toCancel = ShiftChangeRequest::factory()->create([
            'shift_assignment_id' => $assignment->id,
            'requested_by' => $assignment->staff->user_id,
        ]);

        $reject = $this->actingAs($admin)->patch(route('admin.shift-change-requests.reject', $toReject), [
            'review_notes' => 'No procede.',
        ]);
        $cancel = $this->actingAs($assignment->staff->user)->patch(route('shift-change-requests.cancel', $toCancel));

        $reject->assertRedirect(route('admin.shift-change-requests.show', $toReject));
        $cancel->assertRedirect(route('shift-change-requests.show', $toCancel));
        $this->assertSame(ShiftChangeRequest::STATUS_REJECTED, $toReject->fresh()->status);
        $this->assertSame(ShiftChangeRequest::STATUS_CANCELLED, $toCancel->fresh()->status);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $assignment->staff->user_id,
            'type' => 'shift_change_request_rejected',
        ]);
    }

    public function test_user_can_only_read_own_notifications(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_STAFF]);
        $other = User::factory()->create(['role' => User::ROLE_STAFF]);
        $notification = InternalNotification::factory()->create(['user_id' => $user->id]);
        $otherNotification = InternalNotification::factory()->create(['user_id' => $other->id]);

        $index = $this->actingAs($user)->get(route('notifications.index'));
        $readOwn = $this->actingAs($user)->patch(route('notifications.read', $notification));
        $readOther = $this->actingAs($user)->patch(route('notifications.read', $otherNotification));

        $index->assertOk();
        $index->assertSee($notification->title);
        $index->assertDontSee($otherNotification->title);
        $readOwn->assertRedirect(route('notifications.index'));
        $readOther->assertForbidden();
        $this->assertNotNull($notification->fresh()->read_at);
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    private function assignmentForPersonal(array $overrides = []): ShiftAssignment
    {
        $serviceShiftTemplate = ServiceShiftTemplate::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_STAFF]);
        $staff = Staff::factory()->create([
            'user_id' => $user->id,
            'hospital_service_id' => $serviceShiftTemplate->hospital_service_id,
        ]);

        return ShiftAssignment::factory()->create([
            'staff_id' => $staff->id,
            'hospital_service_id' => $serviceShiftTemplate->hospital_service_id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'status' => $overrides['status'] ?? ShiftAssignment::STATUS_ASSIGNED,
        ]);
    }
}
