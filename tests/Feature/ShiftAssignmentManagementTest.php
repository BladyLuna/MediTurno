<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\AuditLog;
use App\Models\HospitalService;
use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use App\Models\ShiftTemplate;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShiftAssignmentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    public function test_admin_can_view_shift_assignments_index(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->get(route('admin.shift-assignments.index'));

        $response->assertOk();
        $response->assertSee('Asignaciones de turno');
    }

    public function test_non_admin_cannot_manage_shift_assignments(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);

        $response = $this->actingAs($user)->get(route('admin.shift-assignments.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_create_assignment_and_audit_log_is_recorded(): void
    {
        [$admin, $service, $staff, $serviceShiftTemplate] = $this->assignmentContext('08:00', '14:00');

        $response = $this->actingAs($admin)->post(route('admin.shift-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
            'notes' => 'Turno inicial',
        ]);

        $response->assertRedirect(route('admin.shift-assignments.index'));
        $this->assertDatabaseHas('shift_assignments', [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
            'start_at' => '2026-06-07 08:00:00',
            'end_at' => '2026-06-07 14:00:00',
            'status' => ShiftAssignment::STATUS_ASSIGNED,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'created',
            'model_type' => ShiftAssignment::class,
        ]);
    }

    public function test_night_shift_crosses_to_next_day(): void
    {
        [$admin, $service, $staff, $serviceShiftTemplate] = $this->assignmentContext('21:00', '07:00');

        $this->actingAs($admin)->post(route('admin.shift-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
        ])->assertRedirect(route('admin.shift-assignments.index'));

        $this->assertDatabaseHas('shift_assignments', [
            'start_at' => '2026-06-07 21:00:00',
            'end_at' => '2026-06-08 07:00:00',
        ]);
    }

    public function test_custom_service_shift_times_are_used(): void
    {
        [$admin, $service, $staff, $serviceShiftTemplate] = $this->assignmentContext('08:00', '16:00', '10:00', '18:00');

        $this->actingAs($admin)->post(route('admin.shift-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
        ])->assertRedirect(route('admin.shift-assignments.index'));

        $this->assertDatabaseHas('shift_assignments', [
            'start_at' => '2026-06-07 10:00:00',
            'end_at' => '2026-06-07 18:00:00',
        ]);
    }

    public function test_overlapping_assignment_is_rejected(): void
    {
        [$admin, $service, $staff, $serviceShiftTemplate] = $this->assignmentContext('08:00', '14:00');
        $overlapTemplate = $this->serviceShiftTemplate($service, '13:00', '20:00');
        $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');

        $response = $this->actingAs($admin)->post(route('admin.shift-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $overlapTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);

        $response->assertSessionHasErrors('service_shift_template_id');
    }

    public function test_consecutive_assignment_when_existing_end_equals_new_start_is_allowed(): void
    {
        [$admin, $service, $staff, $serviceShiftTemplate] = $this->assignmentContext('08:00', '14:00');
        $nextTemplate = $this->serviceShiftTemplate($service, '14:00', '20:00');
        $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');

        $response = $this->actingAs($admin)->post(route('admin.shift-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $nextTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);

        $response->assertRedirect(route('admin.shift-assignments.index'));
    }

    public function test_consecutive_assignment_when_new_end_equals_existing_start_is_allowed(): void
    {
        [$admin, $service, $staff, $serviceShiftTemplate] = $this->assignmentContext('14:00', '20:00');
        $previousTemplate = $this->serviceShiftTemplate($service, '08:00', '14:00');
        $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 14:00:00', '2026-06-07 20:00:00');

        $response = $this->actingAs($admin)->post(route('admin.shift-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $previousTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);

        $response->assertRedirect(route('admin.shift-assignments.index'));
    }

    public function test_night_shift_overlap_is_rejected(): void
    {
        [$admin, $service, $staff, $serviceShiftTemplate] = $this->assignmentContext('21:00', '07:00');
        $overlapTemplate = $this->serviceShiftTemplate($service, '06:00', '12:00');
        $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 21:00:00', '2026-06-08 07:00:00');

        $response = $this->actingAs($admin)->post(route('admin.shift-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $overlapTemplate->id,
            'assignment_date' => '2026-06-08',
        ]);

        $response->assertSessionHasErrors('service_shift_template_id');
    }

    public function test_same_time_for_different_staff_is_allowed(): void
    {
        [$admin, $service, $staff, $serviceShiftTemplate] = $this->assignmentContext('08:00', '14:00');
        $otherStaff = Staff::factory()->create(['hospital_service_id' => $service->id]);
        $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');

        $response = $this->actingAs($admin)->post(route('admin.shift-assignments.store'), [
            'staff_id' => $otherStaff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);

        $response->assertRedirect(route('admin.shift-assignments.index'));
    }

    public function test_staff_service_must_match_selected_service(): void
    {
        [$admin, $service, $staff, $serviceShiftTemplate] = $this->assignmentContext('08:00', '14:00');
        $otherService = HospitalService::factory()->create(['active' => true]);

        $response = $this->actingAs($admin)->post(route('admin.shift-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $otherService->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);

        $response->assertSessionHasErrors(['staff_id', 'service_shift_template_id']);
    }

    public function test_inactive_staff_service_or_service_shift_template_is_rejected(): void
    {
        [$admin, $service, $staff, $serviceShiftTemplate] = $this->assignmentContext('08:00', '14:00');

        $staff->forceFill(['active' => false])->save();
        $response = $this->actingAs($admin)->post(route('admin.shift-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);
        $response->assertSessionHasErrors('staff_id');

        $staff->forceFill(['active' => true])->save();
        $service->forceFill(['active' => false])->save();
        $response = $this->actingAs($admin)->post(route('admin.shift-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);
        $response->assertSessionHasErrors('hospital_service_id');

        $service->forceFill(['active' => true])->save();
        $serviceShiftTemplate->forceFill(['active' => false])->save();
        $response = $this->actingAs($admin)->post(route('admin.shift-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);
        $response->assertSessionHasErrors('service_shift_template_id');
    }

    public function test_admin_can_update_assignment_and_ignore_its_own_conflict(): void
    {
        [$admin, $service, $staff, $serviceShiftTemplate] = $this->assignmentContext('08:00', '14:00');
        $assignment = $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');

        $response = $this->actingAs($admin)->put(route('admin.shift-assignments.update', $assignment), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
            'notes' => 'Editado',
        ]);

        $response->assertRedirect(route('admin.shift-assignments.index'));
        $this->assertDatabaseHas('shift_assignments', [
            'id' => $assignment->id,
            'status' => ShiftAssignment::STATUS_CHANGED,
            'notes' => 'Editado',
            'updated_by' => $admin->id,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'updated',
            'model_type' => ShiftAssignment::class,
            'model_id' => $assignment->id,
        ]);
    }

    public function test_admin_can_cancel_assignment_with_soft_delete_and_audit_log(): void
    {
        [$admin, $service, $staff, $serviceShiftTemplate] = $this->assignmentContext('08:00', '14:00');
        $assignment = $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');

        $response = $this->actingAs($admin)->delete(route('admin.shift-assignments.destroy', $assignment));

        $response->assertRedirect(route('admin.shift-assignments.index'));
        $this->assertSoftDeleted('shift_assignments', ['id' => $assignment->id]);
        $this->assertDatabaseHas('shift_assignments', [
            'id' => $assignment->id,
            'status' => ShiftAssignment::STATUS_CANCELLED,
            'updated_by' => $admin->id,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'cancelled/deleted',
            'model_type' => ShiftAssignment::class,
            'model_id' => $assignment->id,
        ]);
    }

    public function test_cancelled_deleted_assignment_does_not_block_new_assignment(): void
    {
        [$admin, $service, $staff, $serviceShiftTemplate] = $this->assignmentContext('08:00', '14:00');
        $assignment = $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');
        $assignment->forceFill(['status' => ShiftAssignment::STATUS_CANCELLED])->save();
        $assignment->delete();

        $response = $this->actingAs($admin)->post(route('admin.shift-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);

        $response->assertRedirect(route('admin.shift-assignments.index'));
    }

    public function test_audit_log_view_shows_shift_assignment_events(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $assignment = ShiftAssignment::factory()->create();
        $auditLog = AuditLog::create([
            'user_id' => $admin->id,
            'action' => 'created',
            'model_type' => ShiftAssignment::class,
            'model_id' => $assignment->id,
            'new_values' => ['id' => $assignment->id],
        ]);

        $response = $this->actingAs($admin)->get(route('admin.audit-logs.show', $auditLog));

        $response->assertOk();
        $response->assertSee('ShiftAssignment');
        $response->assertSee('created');
    }

    private function assignmentContext(
        string $startTime,
        string $endTime,
        ?string $customStartTime = null,
        ?string $customEndTime = null
    ): array {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create(['active' => true]);
        $staff = Staff::factory()->create(['hospital_service_id' => $service->id, 'active' => true]);
        $serviceShiftTemplate = $this->serviceShiftTemplate($service, $startTime, $endTime, $customStartTime, $customEndTime);

        return [$admin, $service, $staff, $serviceShiftTemplate];
    }

    private function serviceShiftTemplate(
        HospitalService $service,
        string $startTime,
        string $endTime,
        ?string $customStartTime = null,
        ?string $customEndTime = null
    ): ServiceShiftTemplate {
        $shiftTemplate = ShiftTemplate::factory()->create([
            'start_time' => $startTime,
            'end_time' => $endTime,
            'active' => true,
        ]);

        return ServiceShiftTemplate::factory()->create([
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
            'custom_start_time' => $customStartTime,
            'custom_end_time' => $customEndTime,
            'active' => true,
        ]);
    }

    private function createAssignment(
        Staff $staff,
        HospitalService $service,
        ServiceShiftTemplate $serviceShiftTemplate,
        string $assignmentDate,
        string $startAt,
        string $endAt
    ): ShiftAssignment {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        return ShiftAssignment::factory()->create([
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => $assignmentDate,
            'start_at' => $startAt,
            'end_at' => $endAt,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
    }
}
