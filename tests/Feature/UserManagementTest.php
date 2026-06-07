<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\EnsureUserIsActive;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    public function test_admin_can_view_users_index(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertOk();
        $response->assertSee('Usuarios');
    }

    public function test_non_admin_cannot_manage_users(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_STAFF]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_create_user_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Jefe Servicio',
            'email' => 'jefe.sprint2@example.com',
            'password' => '12345678',
            'role' => User::ROLE_SERVICE_MANAGER,
            'active' => '1',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'jefe.sprint2@example.com',
            'role' => User::ROLE_SERVICE_MANAGER,
            'active' => true,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'created',
            'model_type' => User::class,
        ]);
    }

    public function test_user_creation_validates_allowed_roles(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Invalid Role',
            'email' => 'invalid-role@example.com',
            'password' => '12345678',
            'role' => 'externo',
            'active' => '1',
        ]);

        $response->assertSessionHasErrors('role');
    }

    public function test_admin_can_update_user_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $user = User::factory()->create(['role' => User::ROLE_STAFF]);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $user), [
            'name' => 'Personal Actualizado',
            'email' => $user->email,
            'password' => '',
            'role' => User::ROLE_SERVICE_MANAGER,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Personal Actualizado',
            'role' => User::ROLE_SERVICE_MANAGER,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'updated',
            'model_id' => $user->id,
        ]);
    }

    public function test_admin_can_deactivate_and_activate_user_with_audit_logs(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $user = User::factory()->create(['role' => User::ROLE_STAFF, 'active' => true]);

        $deactivate = $this->actingAs($admin)->patch(route('admin.users.deactivate', $user));

        $deactivate->assertRedirect();
        $this->assertFalse($user->fresh()->active);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'deactivated',
            'model_id' => $user->id,
        ]);

        $activate = $this->actingAs($admin)->patch(route('admin.users.activate', $user));

        $activate->assertRedirect();
        $this->assertTrue($user->fresh()->active);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'activated',
            'model_id' => $user->id,
        ]);
    }

    public function test_admin_cannot_deactivate_self(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'active' => true]);

        $response = $this->actingAs($admin)->patch(route('admin.users.deactivate', $admin));

        $response->assertSessionHas('error');
        $this->assertTrue($admin->fresh()->active);
    }

    public function test_admin_cannot_deactivate_last_active_admin(): void
    {
        $this->withoutMiddleware(EnsureUserIsActive::class);

        $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'active' => true]);
        $target = User::factory()->create(['role' => User::ROLE_ADMIN, 'active' => true]);
        $admin->forceFill(['active' => false])->save();

        $response = $this->actingAs($admin)->patch(route('admin.users.deactivate', $target));

        $response->assertSessionHas('error');
        $this->assertTrue($target->fresh()->active);
    }

    public function test_admin_can_soft_delete_user_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $user = User::factory()->create(['role' => User::ROLE_STAFF]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $user));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertSoftDeleted('users', ['id' => $user->id]);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'deleted',
            'model_id' => $user->id,
        ]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'active' => true]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'deleted_at' => null,
        ]);
    }

    public function test_admin_cannot_delete_last_active_admin(): void
    {
        $this->withoutMiddleware(EnsureUserIsActive::class);

        $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'active' => true]);
        $target = User::factory()->create(['role' => User::ROLE_ADMIN, 'active' => true]);
        $admin->forceFill(['active' => false])->save();

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $target));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'deleted_at' => null,
        ]);
    }

    public function test_admin_can_view_audit_logs(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $auditLog = AuditLog::create([
            'user_id' => $admin->id,
            'action' => 'created',
            'model_type' => User::class,
            'model_id' => $admin->id,
            'new_values' => ['email' => $admin->email],
        ]);

        $index = $this->actingAs($admin)->get(route('admin.audit-logs.index'));
        $show = $this->actingAs($admin)->get(route('admin.audit-logs.show', $auditLog));

        $index->assertOk();
        $index->assertSee('Auditoría');
        $show->assertOk();
        $show->assertSee('Detalle de auditoría');
    }
}
