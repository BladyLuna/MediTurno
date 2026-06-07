<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\AuditLog;
use App\Models\ShiftTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShiftTemplateManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    public function test_admin_can_view_shift_templates_index(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->get(route('admin.shift-templates.index'));

        $response->assertOk();
        $response->assertSee('Plantillas de turno');
    }

    public function test_non_admin_cannot_manage_shift_templates(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);

        $response = $this->actingAs($user)->get(route('admin.shift-templates.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_create_shift_template_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.shift-templates.store'), [
            'code' => 'M1',
            'name' => 'Mañana',
            'start_time' => '08:00',
            'end_time' => '14:00',
            'color' => '#198754',
            'is_working_shift' => '1',
            'active' => '1',
        ]);

        $response->assertRedirect(route('admin.shift-templates.index'));
        $this->assertDatabaseHas('shift_templates', [
            'code' => 'M1',
            'name' => 'Mañana',
            'color' => '#198754',
            'is_working_shift' => true,
            'active' => true,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'created',
            'model_type' => ShiftTemplate::class,
        ]);
    }

    public function test_night_shift_time_range_is_allowed(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.shift-templates.store'), [
            'code' => 'N1',
            'name' => 'Noche',
            'start_time' => '21:00',
            'end_time' => '07:00',
            'color' => '#6f42c1',
            'is_working_shift' => '1',
            'active' => '1',
        ]);

        $response->assertRedirect(route('admin.shift-templates.index'));
        $this->assertDatabaseHas('shift_templates', [
            'code' => 'N1',
            'start_time' => '21:00',
            'end_time' => '07:00',
        ]);
    }

    public function test_code_and_name_must_be_unique_among_not_deleted_records(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        ShiftTemplate::factory()->create(['code' => 'T1', 'name' => 'Tarde']);

        $response = $this->actingAs($admin)->post(route('admin.shift-templates.store'), [
            'code' => 'T1',
            'name' => 'Tarde',
            'start_time' => '14:00',
            'end_time' => '20:00',
            'color' => '#ffc107',
        ]);

        $response->assertSessionHasErrors(['code', 'name']);
    }

    public function test_code_and_name_can_be_reused_after_soft_delete(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        ShiftTemplate::factory()->create(['code' => 'L', 'name' => 'Libre'])->delete();

        $response = $this->actingAs($admin)->post(route('admin.shift-templates.store'), [
            'code' => 'L',
            'name' => 'Libre',
            'start_time' => '00:00',
            'end_time' => '00:00',
            'color' => '#6c757d',
            'is_working_shift' => '0',
            'active' => '1',
        ]);

        $response->assertRedirect(route('admin.shift-templates.index'));
        $this->assertSame(1, ShiftTemplate::query()->where('code', 'L')->count());
    }

    public function test_color_must_be_hexadecimal(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.shift-templates.store'), [
            'code' => 'BAD',
            'name' => 'Color invalido',
            'start_time' => '08:00',
            'end_time' => '12:00',
            'color' => 'blue',
        ]);

        $response->assertSessionHasErrors('color');
    }

    public function test_admin_can_update_shift_template_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $shiftTemplate = ShiftTemplate::factory()->create(['code' => 'A1']);

        $response = $this->actingAs($admin)->put(route('admin.shift-templates.update', $shiftTemplate), [
            'code' => 'A2',
            'name' => 'Actualizado',
            'start_time' => '09:00',
            'end_time' => '17:00',
            'color' => '#20c997',
            'is_working_shift' => '1',
        ]);

        $response->assertRedirect(route('admin.shift-templates.index'));
        $this->assertDatabaseHas('shift_templates', [
            'id' => $shiftTemplate->id,
            'code' => 'A2',
            'name' => 'Actualizado',
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'updated',
            'model_id' => $shiftTemplate->id,
        ]);
    }

    public function test_admin_can_deactivate_activate_and_delete_shift_template_with_audit_logs(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $shiftTemplate = ShiftTemplate::factory()->create(['active' => true]);

        $this->actingAs($admin)->patch(route('admin.shift-templates.deactivate', $shiftTemplate))->assertRedirect();
        $this->assertFalse($shiftTemplate->fresh()->active);
        $this->assertDatabaseHas('audit_logs', ['action' => 'deactivated', 'model_type' => ShiftTemplate::class, 'model_id' => $shiftTemplate->id]);

        $this->actingAs($admin)->patch(route('admin.shift-templates.activate', $shiftTemplate))->assertRedirect();
        $this->assertTrue($shiftTemplate->fresh()->active);
        $this->assertDatabaseHas('audit_logs', ['action' => 'activated', 'model_type' => ShiftTemplate::class, 'model_id' => $shiftTemplate->id]);

        $this->actingAs($admin)->delete(route('admin.shift-templates.destroy', $shiftTemplate))->assertRedirect(route('admin.shift-templates.index'));
        $this->assertSoftDeleted('shift_templates', ['id' => $shiftTemplate->id]);
        $this->assertDatabaseHas('audit_logs', ['action' => 'deleted', 'model_type' => ShiftTemplate::class, 'model_id' => $shiftTemplate->id]);
    }

    public function test_audit_log_view_shows_shift_template_events(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $shiftTemplate = ShiftTemplate::factory()->create(['code' => 'AUD']);
        $auditLog = AuditLog::create([
            'user_id' => $admin->id,
            'action' => 'created',
            'model_type' => ShiftTemplate::class,
            'model_id' => $shiftTemplate->id,
            'new_values' => ['code' => $shiftTemplate->code],
        ]);

        $response = $this->actingAs($admin)->get(route('admin.audit-logs.show', $auditLog));

        $response->assertOk();
        $response->assertSee('ShiftTemplate');
        $response->assertSee('created');
    }
}
