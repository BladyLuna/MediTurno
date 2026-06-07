<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\AuditLog;
use App\Models\HospitalService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HospitalServiceManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    public function test_admin_can_view_hospital_services_index(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->get(route('admin.hospital-services.index'));

        $response->assertOk();
        $response->assertSee('Servicios hospitalarios');
    }

    public function test_non_admin_cannot_manage_hospital_services(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);

        $response = $this->actingAs($user)->get(route('admin.hospital-services.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_create_hospital_service_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.hospital-services.store'), [
            'name' => 'Emergencia',
            'description' => 'Atencion de emergencias',
            'active' => '1',
        ]);

        $response->assertRedirect(route('admin.hospital-services.index'));
        $this->assertDatabaseHas('hospital_services', [
            'name' => 'Emergencia',
            'description' => 'Atencion de emergencias',
            'active' => true,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'created',
            'model_type' => HospitalService::class,
        ]);
    }

    public function test_hospital_service_name_is_required(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.hospital-services.store'), [
            'name' => '',
            'description' => 'Sin nombre',
            'active' => '1',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_hospital_service_name_must_be_unique_among_not_deleted_records(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        HospitalService::factory()->create(['name' => 'Laboratorio']);

        $response = $this->actingAs($admin)->post(route('admin.hospital-services.store'), [
            'name' => 'Laboratorio',
            'description' => 'Duplicado',
            'active' => '1',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_hospital_service_name_can_be_reused_after_soft_delete(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        HospitalService::factory()->create(['name' => 'Imagenologia'])->delete();

        $response = $this->actingAs($admin)->post(route('admin.hospital-services.store'), [
            'name' => 'Imagenologia',
            'description' => 'Nuevo servicio',
            'active' => '1',
        ]);

        $response->assertRedirect(route('admin.hospital-services.index'));
        $this->assertSame(1, HospitalService::query()->where('name', 'Imagenologia')->count());
    }

    public function test_admin_can_update_hospital_service_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $hospitalService = HospitalService::factory()->create(['name' => 'Pediatria']);

        $response = $this->actingAs($admin)->put(route('admin.hospital-services.update', $hospitalService), [
            'name' => 'Pediatria General',
            'description' => 'Servicio actualizado',
        ]);

        $response->assertRedirect(route('admin.hospital-services.index'));
        $this->assertDatabaseHas('hospital_services', [
            'id' => $hospitalService->id,
            'name' => 'Pediatria General',
            'description' => 'Servicio actualizado',
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'updated',
            'model_id' => $hospitalService->id,
        ]);
    }

    public function test_admin_can_deactivate_and_activate_hospital_service_with_audit_logs(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $hospitalService = HospitalService::factory()->create(['active' => true]);

        $deactivate = $this->actingAs($admin)->patch(route('admin.hospital-services.deactivate', $hospitalService));

        $deactivate->assertRedirect();
        $this->assertFalse($hospitalService->fresh()->active);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'deactivated',
            'model_type' => HospitalService::class,
            'model_id' => $hospitalService->id,
        ]);

        $activate = $this->actingAs($admin)->patch(route('admin.hospital-services.activate', $hospitalService));

        $activate->assertRedirect();
        $this->assertTrue($hospitalService->fresh()->active);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'activated',
            'model_type' => HospitalService::class,
            'model_id' => $hospitalService->id,
        ]);
    }

    public function test_admin_can_soft_delete_hospital_service_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $hospitalService = HospitalService::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.hospital-services.destroy', $hospitalService));

        $response->assertRedirect(route('admin.hospital-services.index'));
        $this->assertSoftDeleted('hospital_services', ['id' => $hospitalService->id]);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'deleted',
            'model_type' => HospitalService::class,
            'model_id' => $hospitalService->id,
        ]);
    }

    public function test_audit_log_view_shows_hospital_service_events(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $hospitalService = HospitalService::factory()->create(['name' => 'Cirugia']);
        $auditLog = AuditLog::create([
            'user_id' => $admin->id,
            'action' => 'created',
            'model_type' => HospitalService::class,
            'model_id' => $hospitalService->id,
            'new_values' => ['name' => $hospitalService->name],
        ]);

        $response = $this->actingAs($admin)->get(route('admin.audit-logs.show', $auditLog));

        $response->assertOk();
        $response->assertSee('HospitalService');
        $response->assertSee('created');
    }
}
