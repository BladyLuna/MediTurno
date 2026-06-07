<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\AuditLog;
use App\Models\HospitalService;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    public function test_admin_can_view_staff_index(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->get(route('admin.staff.index'));

        $response->assertOk();
        $response->assertSee('Personal de salud');
    }

    public function test_non_admin_cannot_manage_staff(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);

        $response = $this->actingAs($user)->get(route('admin.staff.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_create_staff_without_user_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.staff.store'), [
            'hospital_service_id' => $service->id,
            'user_id' => '',
            'ci' => '12345678',
            'full_name' => 'Maria Perez',
            'position' => 'Enfermera',
            'phone' => '70000001',
            'email' => 'maria.perez@example.com',
            'active' => '1',
        ]);

        $response->assertRedirect(route('admin.staff.index'));
        $this->assertDatabaseHas('staff', [
            'hospital_service_id' => $service->id,
            'user_id' => null,
            'ci' => '12345678',
            'full_name' => 'Maria Perez',
            'active' => true,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'created',
            'model_type' => Staff::class,
        ]);
    }

    public function test_admin_can_create_staff_with_personal_user(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();
        $personalUser = User::factory()->create(['role' => User::ROLE_STAFF]);

        $response = $this->actingAs($admin)->post(route('admin.staff.store'), [
            'hospital_service_id' => $service->id,
            'user_id' => $personalUser->id,
            'ci' => '22334455',
            'full_name' => 'Juan Lopez',
            'position' => 'Medico',
            'phone' => '',
            'email' => '',
            'active' => '1',
        ]);

        $response->assertRedirect(route('admin.staff.index'));
        $this->assertDatabaseHas('staff', [
            'user_id' => $personalUser->id,
            'ci' => '22334455',
        ]);
    }

    public function test_staff_cannot_be_associated_to_admin_or_service_manager_user(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();
        $manager = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);

        $response = $this->actingAs($admin)->post(route('admin.staff.store'), [
            'hospital_service_id' => $service->id,
            'user_id' => $manager->id,
            'ci' => '33445566',
            'full_name' => 'Usuario Incorrecto',
            'position' => 'Medico',
        ]);

        $response->assertSessionHasErrors('user_id');
    }

    public function test_hospital_service_is_required_and_must_exist(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.staff.store'), [
            'hospital_service_id' => 999,
            'ci' => '44556677',
            'full_name' => 'Sin Servicio',
            'position' => 'Auxiliar',
        ]);

        $response->assertSessionHasErrors('hospital_service_id');
    }

    public function test_ci_must_be_unique_among_not_deleted_records(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();
        Staff::factory()->create(['ci' => '55667788', 'hospital_service_id' => $service->id]);

        $response = $this->actingAs($admin)->post(route('admin.staff.store'), [
            'hospital_service_id' => $service->id,
            'ci' => '55667788',
            'full_name' => 'CI Duplicado',
            'position' => 'Enfermero',
        ]);

        $response->assertSessionHasErrors('ci');
    }

    public function test_ci_can_be_reused_after_soft_delete(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();
        Staff::factory()->create(['ci' => '66778899', 'hospital_service_id' => $service->id])->delete();

        $response = $this->actingAs($admin)->post(route('admin.staff.store'), [
            'hospital_service_id' => $service->id,
            'ci' => '66778899',
            'full_name' => 'CI Reutilizado',
            'position' => 'Tecnico',
            'active' => '1',
        ]);

        $response->assertRedirect(route('admin.staff.index'));
        $this->assertSame(1, Staff::query()->where('ci', '66778899')->count());
    }

    public function test_user_id_must_be_unique_among_not_deleted_records(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();
        $personalUser = User::factory()->create(['role' => User::ROLE_STAFF]);
        Staff::factory()->create([
            'user_id' => $personalUser->id,
            'hospital_service_id' => $service->id,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.staff.store'), [
            'hospital_service_id' => $service->id,
            'user_id' => $personalUser->id,
            'ci' => '77889900',
            'full_name' => 'Usuario Duplicado',
            'position' => 'Enfermero',
        ]);

        $response->assertSessionHasErrors('user_id');
    }

    public function test_admin_can_update_staff_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();
        $staff = Staff::factory()->create(['hospital_service_id' => $service->id]);

        $response = $this->actingAs($admin)->put(route('admin.staff.update', $staff), [
            'hospital_service_id' => $service->id,
            'user_id' => '',
            'ci' => $staff->ci,
            'full_name' => 'Nombre Actualizado',
            'position' => 'Jefe de Enfermeria',
            'phone' => '70000002',
            'email' => 'actualizado@example.com',
        ]);

        $response->assertRedirect(route('admin.staff.index'));
        $this->assertDatabaseHas('staff', [
            'id' => $staff->id,
            'full_name' => 'Nombre Actualizado',
            'position' => 'Jefe de Enfermeria',
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'updated',
            'model_id' => $staff->id,
        ]);
    }

    public function test_admin_can_open_staff_edit_form(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create(['name' => 'Emergencia']);
        $personalUser = User::factory()->create([
            'name' => 'Personal Asociado',
            'email' => 'personal.asociado@example.com',
            'role' => User::ROLE_STAFF,
            'active' => true,
        ]);
        $staff = Staff::factory()->create([
            'user_id' => $personalUser->id,
            'hospital_service_id' => $service->id,
            'full_name' => 'Personal en Edicion',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.staff.edit', $staff));

        $response->assertOk();
        $response->assertSee('Editar personal de salud');
        $response->assertSee('Personal en Edicion');
        $response->assertSee('Emergencia');
        $response->assertSee('personal.asociado@example.com');
    }

    public function test_admin_can_deactivate_and_activate_staff_with_audit_logs(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $staff = Staff::factory()->create(['active' => true]);

        $deactivate = $this->actingAs($admin)->patch(route('admin.staff.deactivate', $staff));

        $deactivate->assertRedirect();
        $this->assertFalse($staff->fresh()->active);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'deactivated',
            'model_type' => Staff::class,
            'model_id' => $staff->id,
        ]);

        $activate = $this->actingAs($admin)->patch(route('admin.staff.activate', $staff));

        $activate->assertRedirect();
        $this->assertTrue($staff->fresh()->active);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'activated',
            'model_type' => Staff::class,
            'model_id' => $staff->id,
        ]);
    }

    public function test_admin_can_soft_delete_staff_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $staff = Staff::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.staff.destroy', $staff));

        $response->assertRedirect(route('admin.staff.index'));
        $this->assertSoftDeleted('staff', ['id' => $staff->id]);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'deleted',
            'model_type' => Staff::class,
            'model_id' => $staff->id,
        ]);
    }

    public function test_staff_filters_by_name_ci_and_service(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $emergency = HospitalService::factory()->create(['name' => 'Emergencia']);
        $lab = HospitalService::factory()->create(['name' => 'Laboratorio']);
        Staff::factory()->create([
            'hospital_service_id' => $emergency->id,
            'ci' => '11111111',
            'full_name' => 'Ana Emergencia',
        ]);
        Staff::factory()->create([
            'hospital_service_id' => $lab->id,
            'ci' => '22222222',
            'full_name' => 'Luis Laboratorio',
        ]);

        $byName = $this->actingAs($admin)->get(route('admin.staff.index', ['name' => 'Ana']));
        $byCi = $this->actingAs($admin)->get(route('admin.staff.index', ['ci' => '2222']));
        $byService = $this->actingAs($admin)->get(route('admin.staff.index', ['hospital_service_id' => $emergency->id]));

        $byName->assertOk();
        $byName->assertSee('Ana Emergencia');
        $byName->assertDontSee('Luis Laboratorio');
        $byCi->assertSee('Luis Laboratorio');
        $byCi->assertDontSee('Ana Emergencia');
        $byService->assertSee('Ana Emergencia');
        $byService->assertDontSee('Luis Laboratorio');
    }

    public function test_audit_log_view_shows_staff_events(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $staff = Staff::factory()->create(['full_name' => 'Auditoria Staff']);
        $auditLog = AuditLog::create([
            'user_id' => $admin->id,
            'action' => 'created',
            'model_type' => Staff::class,
            'model_id' => $staff->id,
            'new_values' => ['full_name' => $staff->full_name],
        ]);

        $response = $this->actingAs($admin)->get(route('admin.audit-logs.show', $auditLog));

        $response->assertOk();
        $response->assertSee('Staff');
        $response->assertSee('created');
    }
}
