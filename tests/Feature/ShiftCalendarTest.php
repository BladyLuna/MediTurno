<?php

namespace Tests\Feature;

use App\Models\HospitalService;
use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use App\Models\ShiftTemplate;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShiftCalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_shift_calendar(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->get(route('admin.calendar.index', ['month' => '2026-06']));

        $response->assertOk();
        $response->assertSee('Calendario mensual de turnos');
        $response->assertSee(route('admin.calendar.events'));
    }

    public function test_non_admin_cannot_view_shift_calendar(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_STAFF]);

        $response = $this->actingAs($user)->get(route('admin.calendar.index'));

        $response->assertForbidden();
    }

    public function test_calendar_events_returns_assignments_for_range(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $assignment = $this->createAssignment([
            'staff_name' => 'Ana Rojas',
            'service_name' => 'Emergencia',
            'shift_name' => 'Mañana',
            'shift_code' => 'M',
            'color' => '#198754',
            'start_at' => '2026-06-10 08:00:00',
            'end_at' => '2026-06-10 16:00:00',
        ]);

        $response = $this->actingAs($admin)->getJson(route('admin.calendar.events', [
            'start' => '2026-06-01',
            'end' => '2026-07-01',
        ]));

        $response->assertOk();
        $response->assertJsonFragment([
            'id' => (string) $assignment->id,
            'title' => 'Ana Rojas - Mañana',
            'start' => '2026-06-10T08:00:00',
            'end' => '2026-06-10T16:00:00',
            'backgroundColor' => '#198754',
            'borderColor' => '#198754',
        ]);
        $response->assertJsonFragment([
            'staff_name' => 'Ana Rojas',
            'hospital_service_name' => 'Emergencia',
            'shift_name' => 'Mañana',
            'shift_code' => 'M',
            'status' => ShiftAssignment::STATUS_ASSIGNED,
        ]);
    }

    public function test_calendar_events_filter_by_service(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $included = $this->createAssignment(['service_name' => 'Emergencia']);
        $this->createAssignment(['service_name' => 'Laboratorio']);

        $response = $this->actingAs($admin)->getJson(route('admin.calendar.events', [
            'start' => '2026-06-01',
            'end' => '2026-07-01',
            'hospital_service_id' => $included->hospital_service_id,
        ]));

        $response->assertOk();
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['id' => (string) $included->id]);
    }

    public function test_calendar_events_filter_by_staff(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $included = $this->createAssignment(['staff_name' => 'Personal Incluido']);
        $this->createAssignment(['staff_name' => 'Personal Excluido']);

        $response = $this->actingAs($admin)->getJson(route('admin.calendar.events', [
            'start' => '2026-06-01',
            'end' => '2026-07-01',
            'staff_id' => $included->staff_id,
        ]));

        $response->assertOk();
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['staff_name' => 'Personal Incluido']);
    }

    public function test_calendar_events_excludes_only_cancelled_assignments(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $assigned = $this->createAssignment(['status' => ShiftAssignment::STATUS_ASSIGNED]);
        $changed = $this->createAssignment(['status' => ShiftAssignment::STATUS_CHANGED]);
        $cancelled = $this->createAssignment(['status' => ShiftAssignment::STATUS_CANCELLED]);

        $response = $this->actingAs($admin)->getJson(route('admin.calendar.events', [
            'start' => '2026-06-01',
            'end' => '2026-07-01',
        ]));

        $response->assertOk();
        $response->assertJsonFragment(['id' => (string) $assigned->id]);
        $response->assertJsonFragment(['id' => (string) $changed->id]);
        $response->assertJsonMissing(['id' => (string) $cancelled->id]);
    }

    public function test_calendar_events_excludes_soft_deleted_assignments(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $deleted = $this->createAssignment();
        $deleted->delete();

        $response = $this->actingAs($admin)->getJson(route('admin.calendar.events', [
            'start' => '2026-06-01',
            'end' => '2026-07-01',
        ]));

        $response->assertOk();
        $response->assertJsonCount(0);
    }

    public function test_calendar_event_uses_custom_color_when_defined(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $assignment = $this->createAssignment([
            'color' => '#0d6efd',
            'custom_color' => '#dc3545',
        ]);

        $response = $this->actingAs($admin)->getJson(route('admin.calendar.events', [
            'start' => '2026-06-01',
            'end' => '2026-07-01',
        ]));

        $response->assertOk();
        $response->assertJsonFragment([
            'id' => (string) $assignment->id,
            'backgroundColor' => '#dc3545',
        ]);
    }

    public function test_calendar_event_supports_night_shift_crossing_next_day(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->createAssignment([
            'shift_name' => 'Noche',
            'start_at' => '2026-06-10 21:00:00',
            'end_at' => '2026-06-11 07:00:00',
        ]);

        $response = $this->actingAs($admin)->getJson(route('admin.calendar.events', [
            'start' => '2026-06-01',
            'end' => '2026-07-01',
        ]));

        $response->assertOk();
        $response->assertJsonFragment([
            'start' => '2026-06-10T21:00:00',
            'end' => '2026-06-11T07:00:00',
            'shift_name' => 'Noche',
        ]);
    }

    public function test_calendar_event_includes_assignment_that_overlaps_range_boundary(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $assignment = $this->createAssignment([
            'start_at' => '2026-05-31 21:00:00',
            'end_at' => '2026-06-01 07:00:00',
        ]);

        $response = $this->actingAs($admin)->getJson(route('admin.calendar.events', [
            'start' => '2026-06-01',
            'end' => '2026-07-01',
        ]));

        $response->assertOk();
        $response->assertJsonFragment(['id' => (string) $assignment->id]);
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    private function createAssignment(array $overrides = []): ShiftAssignment
    {
        $hospitalService = HospitalService::factory()->create([
            'name' => $overrides['service_name'] ?? fake()->unique()->words(2, true),
        ]);
        $staff = Staff::factory()->create([
            'hospital_service_id' => $hospitalService->id,
            'full_name' => $overrides['staff_name'] ?? fake()->name(),
        ]);
        $shiftTemplate = ShiftTemplate::factory()->create([
            'code' => $overrides['shift_code'] ?? strtoupper(fake()->unique()->bothify('??#')),
            'name' => $overrides['shift_name'] ?? fake()->unique()->words(2, true),
            'color' => $overrides['color'] ?? '#0d6efd',
        ]);
        $serviceShiftTemplate = ServiceShiftTemplate::factory()->create([
            'hospital_service_id' => $hospitalService->id,
            'shift_template_id' => $shiftTemplate->id,
            'custom_color' => $overrides['custom_color'] ?? null,
        ]);

        return ShiftAssignment::factory()->create([
            'staff_id' => $staff->id,
            'hospital_service_id' => $hospitalService->id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => substr($overrides['start_at'] ?? '2026-06-10 08:00:00', 0, 10),
            'start_at' => $overrides['start_at'] ?? '2026-06-10 08:00:00',
            'end_at' => $overrides['end_at'] ?? '2026-06-10 16:00:00',
            'status' => $overrides['status'] ?? ShiftAssignment::STATUS_ASSIGNED,
        ]);
    }
}
