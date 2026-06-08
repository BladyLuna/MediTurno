<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\HospitalService;
use App\Models\ServiceManager;
use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use App\Models\ShiftTemplate;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceAssignmentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    public function test_service_manager_can_view_operational_dashboard_and_assignment_index(): void
    {
        [$manager] = $this->managedContext();

        $dashboard = $this->actingAs($manager)->get(route('service-dashboard.index'));
        $index = $this->actingAs($manager)->get(route('service-assignments.index'));

        $dashboard->assertOk();
        $dashboard->assertSee('Dashboard operativo de jefatura');
        $index->assertOk();
        $index->assertSee('Asignaciones del servicio');
    }

    public function test_service_manager_can_filter_assignments_when_managing_multiple_services(): void
    {
        [$manager, $firstService, $firstStaff, $firstTemplate] = $this->managedContext();
        [$secondService, $secondStaff, $secondTemplate] = $this->assignmentContext('Segundo Servicio', 'Personal Segundo');
        ServiceManager::factory()->create([
            'user_id' => $manager->id,
            'hospital_service_id' => $secondService->id,
        ]);
        $this->createAssignment($firstStaff, $firstService, $firstTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');
        $this->createAssignment($secondStaff, $secondService, $secondTemplate, '2026-06-08', '2026-06-08 08:00:00', '2026-06-08 14:00:00');

        $response = $this->actingAs($manager)->get(route('service-assignments.index', [
            'hospital_service_id' => $secondService->id,
        ]));

        $response->assertOk();
        $response->assertSee('Personal Segundo');
        $response->assertDontSee('<td>' . $firstStaff->full_name . '</td>', false);
    }

    public function test_service_manager_can_create_assignment_in_managed_service(): void
    {
        [$manager, $service, $staff, $serviceShiftTemplate] = $this->managedContext();

        $response = $this->actingAs($manager)->post(route('service-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
            'notes' => 'Observación de jefatura',
        ]);

        $response->assertRedirect(route('service-assignments.index'));
        $this->assertDatabaseHas('shift_assignments', [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'start_at' => '2026-06-07 08:00:00',
            'end_at' => '2026-06-07 14:00:00',
            'status' => ShiftAssignment::STATUS_ASSIGNED,
            'notes' => 'Observación de jefatura',
            'created_by' => $manager->id,
            'updated_by' => $manager->id,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $manager->id,
            'action' => 'created',
            'model_type' => ShiftAssignment::class,
        ]);
    }

    public function test_service_manager_cannot_force_unmanaged_service_staff_or_template(): void
    {
        [$manager, $managedService, $managedStaff, $managedTemplate] = $this->managedContext();
        [$otherService, $otherStaff, $otherTemplate] = $this->assignmentContext('Servicio Externo', 'Personal Externo');

        $otherServicePayload = $this->actingAs($manager)->post(route('service-assignments.store'), [
            'staff_id' => $managedStaff->id,
            'hospital_service_id' => $otherService->id,
            'service_shift_template_id' => $managedTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);
        $otherStaffPayload = $this->actingAs($manager)->post(route('service-assignments.store'), [
            'staff_id' => $otherStaff->id,
            'hospital_service_id' => $managedService->id,
            'service_shift_template_id' => $managedTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);
        $otherTemplatePayload = $this->actingAs($manager)->post(route('service-assignments.store'), [
            'staff_id' => $managedStaff->id,
            'hospital_service_id' => $managedService->id,
            'service_shift_template_id' => $otherTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);

        $otherServicePayload->assertSessionHasErrors();
        $otherStaffPayload->assertSessionHasErrors();
        $otherTemplatePayload->assertSessionHasErrors();
        $this->assertDatabaseCount('shift_assignments', 0);
    }

    public function test_service_manager_can_edit_assignment_in_managed_service(): void
    {
        [$manager, $service, $staff, $serviceShiftTemplate] = $this->managedContext();
        $assignment = $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');

        $response = $this->actingAs($manager)->put(route('service-assignments.update', $assignment), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
            'notes' => 'Observación actualizada',
        ]);

        $response->assertRedirect(route('service-assignments.index'));
        $this->assertDatabaseHas('shift_assignments', [
            'id' => $assignment->id,
            'status' => ShiftAssignment::STATUS_CHANGED,
            'notes' => 'Observación actualizada',
            'updated_by' => $manager->id,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $manager->id,
            'action' => 'updated',
            'model_type' => ShiftAssignment::class,
            'model_id' => $assignment->id,
        ]);
    }

    public function test_service_manager_cannot_edit_or_cancel_assignment_from_other_service(): void
    {
        [$manager] = $this->managedContext();
        [$otherService, $otherStaff, $otherTemplate] = $this->assignmentContext('Otro Servicio', 'Otro Personal');
        $assignment = $this->createAssignment($otherStaff, $otherService, $otherTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');

        $edit = $this->actingAs($manager)->get(route('service-assignments.edit', $assignment));
        $update = $this->actingAs($manager)->put(route('service-assignments.update', $assignment), [
            'staff_id' => $otherStaff->id,
            'hospital_service_id' => $otherService->id,
            'service_shift_template_id' => $otherTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);
        $delete = $this->actingAs($manager)->delete(route('service-assignments.destroy', $assignment));

        $edit->assertForbidden();
        $update->assertForbidden();
        $delete->assertForbidden();
    }

    public function test_service_manager_can_cancel_assignment_in_managed_service(): void
    {
        [$manager, $service, $staff, $serviceShiftTemplate] = $this->managedContext();
        $assignment = $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');

        $response = $this->actingAs($manager)->delete(route('service-assignments.destroy', $assignment));

        $response->assertRedirect(route('service-assignments.index'));
        $this->assertSoftDeleted('shift_assignments', ['id' => $assignment->id]);
        $this->assertDatabaseHas('shift_assignments', [
            'id' => $assignment->id,
            'status' => ShiftAssignment::STATUS_CANCELLED,
            'updated_by' => $manager->id,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $manager->id,
            'action' => 'cancelled/deleted',
            'model_type' => ShiftAssignment::class,
            'model_id' => $assignment->id,
        ]);
    }

    public function test_service_manager_cannot_edit_or_cancel_cancelled_assignment(): void
    {
        [$manager, $service, $staff, $serviceShiftTemplate] = $this->managedContext();
        $assignment = $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');
        $assignment->forceFill(['status' => ShiftAssignment::STATUS_CANCELLED])->save();

        $edit = $this->actingAs($manager)->get(route('service-assignments.edit', $assignment));
        $delete = $this->actingAs($manager)->delete(route('service-assignments.destroy', $assignment));

        $edit->assertForbidden();
        $delete->assertForbidden();
    }

    public function test_service_manager_assignment_validation_reuses_overlap_rules(): void
    {
        [$manager, $service, $staff, $serviceShiftTemplate] = $this->managedContext('08:00', '14:00');
        $overlapTemplate = $this->serviceShiftTemplate($service, '13:00', '20:00');
        $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');

        $response = $this->actingAs($manager)->post(route('service-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $overlapTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);

        $response->assertSessionHasErrors('service_shift_template_id');
    }

    public function test_service_manager_can_create_consecutive_assignment(): void
    {
        [$manager, $service, $staff, $serviceShiftTemplate] = $this->managedContext('08:00', '14:00');
        $nextTemplate = $this->serviceShiftTemplate($service, '14:00', '20:00');
        $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');

        $response = $this->actingAs($manager)->post(route('service-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $nextTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);

        $response->assertRedirect(route('service-assignments.index'));
    }

    public function test_service_manager_night_shift_crosses_to_next_day(): void
    {
        [$manager, $service, $staff, $serviceShiftTemplate] = $this->managedContext('21:00', '07:00');

        $response = $this->actingAs($manager)->post(route('service-assignments.store'), [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
        ]);

        $response->assertRedirect(route('service-assignments.index'));
        $this->assertDatabaseHas('shift_assignments', [
            'start_at' => '2026-06-07 21:00:00',
            'end_at' => '2026-06-08 07:00:00',
        ]);
    }

    public function test_service_availability_reports_available_and_conflict_states(): void
    {
        [$manager, $service, $staff, $serviceShiftTemplate] = $this->managedContext('08:00', '14:00');
        $this->createAssignment($staff, $service, $serviceShiftTemplate, '2026-06-07', '2026-06-07 08:00:00', '2026-06-07 14:00:00');
        $nextTemplate = $this->serviceShiftTemplate($service, '14:00', '20:00');

        $conflict = $this->actingAs($manager)->get(route('service-availability.index', [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
        ]));
        $available = $this->actingAs($manager)->get(route('service-availability.index', [
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $nextTemplate->id,
            'assignment_date' => '2026-06-07',
        ]));

        $conflict->assertOk();
        $conflict->assertSee('Personal no disponible');
        $available->assertOk();
        $available->assertSee('Personal disponible');
    }

    public function test_service_manager_cannot_access_global_admin_cruds(): void
    {
        $manager = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);

        $this->actingAs($manager)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($manager)->get(route('admin.hospital-services.index'))->assertForbidden();
        $this->actingAs($manager)->get(route('admin.staff.index'))->assertForbidden();
        $this->actingAs($manager)->get(route('admin.shift-templates.index'))->assertForbidden();
        $this->actingAs($manager)->get(route('admin.service-managers.index'))->assertForbidden();
        $this->actingAs($manager)->get(route('admin.audit-logs.index'))->assertForbidden();
    }

    public function test_admin_global_assignment_routes_still_work(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)->get(route('admin.shift-assignments.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.shift-assignments.create'))->assertOk();
    }

    private function managedContext(string $startTime = '08:00', string $endTime = '14:00'): array
    {
        $manager = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);
        [$service, $staff, $serviceShiftTemplate] = $this->assignmentContext('Servicio Gestionado', 'Personal Gestionado', $startTime, $endTime);
        ServiceManager::factory()->create([
            'user_id' => $manager->id,
            'hospital_service_id' => $service->id,
        ]);

        return [$manager, $service, $staff, $serviceShiftTemplate];
    }

    private function assignmentContext(
        string $serviceName,
        string $staffName,
        string $startTime = '08:00',
        string $endTime = '14:00'
    ): array {
        $service = HospitalService::factory()->create([
            'name' => $serviceName,
            'active' => true,
        ]);
        $staff = Staff::factory()->create([
            'hospital_service_id' => $service->id,
            'full_name' => $staffName,
            'active' => true,
        ]);
        $serviceShiftTemplate = $this->serviceShiftTemplate($service, $startTime, $endTime);

        return [$service, $staff, $serviceShiftTemplate];
    }

    private function serviceShiftTemplate(HospitalService $service, string $startTime, string $endTime): ServiceShiftTemplate
    {
        $shiftTemplate = ShiftTemplate::factory()->create([
            'start_time' => $startTime,
            'end_time' => $endTime,
            'active' => true,
        ]);

        return ServiceShiftTemplate::factory()->create([
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
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
        return ShiftAssignment::factory()->create([
            'staff_id' => $staff->id,
            'hospital_service_id' => $service->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => $assignmentDate,
            'start_at' => $startAt,
            'end_at' => $endAt,
            'status' => ShiftAssignment::STATUS_ASSIGNED,
        ]);
    }
}
