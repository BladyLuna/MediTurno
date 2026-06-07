<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\AuditLog;
use App\Models\HospitalService;
use App\Models\ServiceShiftTemplate;
use App\Models\ShiftTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceShiftTemplateManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    public function test_admin_can_view_service_shift_templates_index(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->get(route('admin.service-shift-templates.index'));

        $response->assertOk();
        $response->assertSee('Turnos por servicio');
    }

    public function test_non_admin_cannot_manage_service_shift_templates(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);

        $response = $this->actingAs($user)->get(route('admin.service-shift-templates.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_create_service_shift_template_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();
        $shiftTemplate = ShiftTemplate::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.service-shift-templates.store'), [
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
            'custom_code' => 'EM',
            'custom_name' => 'Emergencia mañana',
            'custom_start_time' => '07:00',
            'custom_end_time' => '13:00',
            'custom_color' => '#fd7e14',
            'active' => '1',
        ]);

        $response->assertRedirect(route('admin.service-shift-templates.index'));
        $this->assertDatabaseHas('service_shift_templates', [
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
            'custom_code' => 'EM',
            'custom_color' => '#fd7e14',
            'active' => true,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'created',
            'model_type' => ServiceShiftTemplate::class,
        ]);
    }

    public function test_custom_color_can_be_empty_to_inherit_shift_template_color(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();
        $shiftTemplate = ShiftTemplate::factory()->create(['color' => '#198754']);

        $response = $this->actingAs($admin)->post(route('admin.service-shift-templates.store'), [
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
            'custom_code' => '',
            'custom_name' => '',
            'custom_start_time' => '',
            'custom_end_time' => '',
            'custom_color' => '',
            'active' => '1',
        ]);

        $response->assertRedirect(route('admin.service-shift-templates.index'));
        $this->assertDatabaseHas('service_shift_templates', [
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
            'custom_color' => null,
        ]);
    }

    public function test_custom_start_and_end_time_must_be_defined_together(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();
        $shiftTemplate = ShiftTemplate::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.service-shift-templates.store'), [
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
            'custom_start_time' => '21:00',
            'custom_end_time' => '',
        ]);

        $response->assertSessionHasErrors('custom_end_time');
    }

    public function test_custom_night_shift_time_range_is_allowed(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();
        $shiftTemplate = ShiftTemplate::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.service-shift-templates.store'), [
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
            'custom_start_time' => '21:00',
            'custom_end_time' => '07:00',
            'custom_color' => '#6f42c1',
            'active' => '1',
        ]);

        $response->assertRedirect(route('admin.service-shift-templates.index'));
        $this->assertDatabaseHas('service_shift_templates', [
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
            'custom_start_time' => '21:00',
            'custom_end_time' => '07:00',
        ]);
    }

    public function test_hospital_service_and_shift_template_are_required(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.service-shift-templates.store'), [
            'hospital_service_id' => '',
            'shift_template_id' => '',
        ]);

        $response->assertSessionHasErrors(['hospital_service_id', 'shift_template_id']);
    }

    public function test_service_and_shift_template_combination_must_be_unique_among_not_deleted_records(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();
        $shiftTemplate = ShiftTemplate::factory()->create();
        ServiceShiftTemplate::factory()->create([
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.service-shift-templates.store'), [
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
        ]);

        $response->assertSessionHasErrors('shift_template_id');
    }

    public function test_service_and_shift_template_combination_can_be_reused_after_soft_delete(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();
        $shiftTemplate = ShiftTemplate::factory()->create();
        ServiceShiftTemplate::factory()->create([
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
        ])->delete();

        $response = $this->actingAs($admin)->post(route('admin.service-shift-templates.store'), [
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
            'active' => '1',
        ]);

        $response->assertRedirect(route('admin.service-shift-templates.index'));
        $this->assertSame(1, ServiceShiftTemplate::query()
            ->where('hospital_service_id', $service->id)
            ->where('shift_template_id', $shiftTemplate->id)
            ->count());
    }

    public function test_custom_color_must_be_hexadecimal(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $service = HospitalService::factory()->create();
        $shiftTemplate = ShiftTemplate::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.service-shift-templates.store'), [
            'hospital_service_id' => $service->id,
            'shift_template_id' => $shiftTemplate->id,
            'custom_color' => 'orange',
        ]);

        $response->assertSessionHasErrors('custom_color');
    }

    public function test_admin_can_update_service_shift_template_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $serviceShiftTemplate = ServiceShiftTemplate::factory()->create();

        $response = $this->actingAs($admin)->put(route('admin.service-shift-templates.update', $serviceShiftTemplate), [
            'hospital_service_id' => $serviceShiftTemplate->hospital_service_id,
            'shift_template_id' => $serviceShiftTemplate->shift_template_id,
            'custom_code' => 'UPD',
            'custom_name' => 'Actualizado',
            'custom_start_time' => '10:00',
            'custom_end_time' => '18:00',
            'custom_color' => '#0dcaf0',
        ]);

        $response->assertRedirect(route('admin.service-shift-templates.index'));
        $this->assertDatabaseHas('service_shift_templates', [
            'id' => $serviceShiftTemplate->id,
            'custom_code' => 'UPD',
            'custom_color' => '#0dcaf0',
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'updated',
            'model_id' => $serviceShiftTemplate->id,
        ]);
    }

    public function test_admin_can_deactivate_activate_and_delete_service_shift_template_with_audit_logs(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $serviceShiftTemplate = ServiceShiftTemplate::factory()->create(['active' => true]);

        $this->actingAs($admin)->patch(route('admin.service-shift-templates.deactivate', $serviceShiftTemplate))->assertRedirect();
        $this->assertFalse($serviceShiftTemplate->fresh()->active);
        $this->assertDatabaseHas('audit_logs', ['action' => 'deactivated', 'model_type' => ServiceShiftTemplate::class, 'model_id' => $serviceShiftTemplate->id]);

        $this->actingAs($admin)->patch(route('admin.service-shift-templates.activate', $serviceShiftTemplate))->assertRedirect();
        $this->assertTrue($serviceShiftTemplate->fresh()->active);
        $this->assertDatabaseHas('audit_logs', ['action' => 'activated', 'model_type' => ServiceShiftTemplate::class, 'model_id' => $serviceShiftTemplate->id]);

        $this->actingAs($admin)->delete(route('admin.service-shift-templates.destroy', $serviceShiftTemplate))->assertRedirect(route('admin.service-shift-templates.index'));
        $this->assertSoftDeleted('service_shift_templates', ['id' => $serviceShiftTemplate->id]);
        $this->assertDatabaseHas('audit_logs', ['action' => 'deleted', 'model_type' => ServiceShiftTemplate::class, 'model_id' => $serviceShiftTemplate->id]);
    }

    public function test_audit_log_view_shows_service_shift_template_events(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $serviceShiftTemplate = ServiceShiftTemplate::factory()->create();
        $auditLog = AuditLog::create([
            'user_id' => $admin->id,
            'action' => 'created',
            'model_type' => ServiceShiftTemplate::class,
            'model_id' => $serviceShiftTemplate->id,
            'new_values' => ['id' => $serviceShiftTemplate->id],
        ]);

        $response = $this->actingAs($admin)->get(route('admin.audit-logs.show', $auditLog));

        $response->assertOk();
        $response->assertSee('ServiceShiftTemplate');
        $response->assertSee('created');
    }
}
