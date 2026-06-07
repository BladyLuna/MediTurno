<?php

namespace Tests\Feature;

use App\Models\HospitalService;
use App\Models\ServiceManager;
use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use App\Models\ShiftTemplate;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleScopedViewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_manager_calendar_events_only_include_managed_services(): void
    {
        $manager = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);
        $managed = $this->createAssignment([
            'service_name' => 'Emergencia',
            'staff_name' => 'Personal Gestionado',
        ]);
        $other = $this->createAssignment([
            'service_name' => 'Laboratorio',
            'staff_name' => 'Personal Externo',
        ]);
        ServiceManager::factory()->create([
            'user_id' => $manager->id,
            'hospital_service_id' => $managed->hospital_service_id,
        ]);

        $response = $this->actingAs($manager)->getJson(route('service-calendar.events', [
            'start' => '2026-06-01',
            'end' => '2026-07-01',
        ]));

        $response->assertOk();
        $response->assertJsonFragment(['staff_name' => 'Personal Gestionado']);
        $response->assertJsonMissing(['staff_name' => 'Personal Externo']);

        $forced = $this->actingAs($manager)->getJson(route('service-calendar.events', [
            'start' => '2026-06-01',
            'end' => '2026-07-01',
            'hospital_service_id' => $other->hospital_service_id,
        ]));

        $forced->assertUnprocessable();
    }

    public function test_service_manager_staff_index_only_shows_managed_services(): void
    {
        $manager = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);
        $managed = $this->createAssignment(['staff_name' => 'Enfermera Gestionada']);
        $other = $this->createAssignment(['staff_name' => 'Medico Externo']);
        ServiceManager::factory()->create([
            'user_id' => $manager->id,
            'hospital_service_id' => $managed->hospital_service_id,
        ]);

        $response = $this->actingAs($manager)->get(route('service-staff.index'));

        $response->assertOk();
        $response->assertSee('Enfermera Gestionada');
        $response->assertDontSee('Medico Externo');

        $forced = $this->actingAs($manager)->getJson(route('service-staff.index', [
            'hospital_service_id' => $other->hospital_service_id,
        ]));

        $forced->assertUnprocessable();
    }

    public function test_service_manager_reports_only_include_managed_services_and_exports_are_scoped(): void
    {
        $manager = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);
        $managed = $this->createAssignment([
            'service_name' => 'UCI',
            'staff_name' => 'Reporte Gestionado',
        ]);
        $other = $this->createAssignment([
            'service_name' => 'Farmacia',
            'staff_name' => 'Reporte Externo',
        ]);
        ServiceManager::factory()->create([
            'user_id' => $manager->id,
            'hospital_service_id' => $managed->hospital_service_id,
        ]);

        $response = $this->actingAs($manager)->get(route('service-reports.index', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
        ]));

        $response->assertOk();
        $response->assertSee('Reporte Gestionado');
        $response->assertDontSee('Reporte Externo');

        $csv = $this->actingAs($manager)->get(route('service-reports.export', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
        ]));

        $csv->assertOk();
        $content = $csv->streamedContent();
        $this->assertStringContainsString('Reporte Gestionado', $content);
        $this->assertStringNotContainsString('Reporte Externo', $content);

        $pdf = $this->actingAs($manager)->get(route('service-reports.pdf', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
        ]));

        $pdf->assertOk();
        $pdf->assertHeader('content-type', 'application/pdf');

        $forced = $this->actingAs($manager)->getJson(route('service-reports.index', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
            'hospital_service_id' => $other->hospital_service_id,
        ]));

        $forced->assertUnprocessable();
    }

    public function test_personal_schedule_only_includes_own_staff_assignments(): void
    {
        $personal = User::factory()->create(['role' => User::ROLE_STAFF]);
        $own = $this->createAssignment([
            'staff_name' => 'Turno Propio',
            'staff_user_id' => $personal->id,
        ]);
        $this->createAssignment(['staff_name' => 'Turno Ajeno']);

        $index = $this->actingAs($personal)->get(route('my-schedule.index', [
            'month' => '2026-06',
        ]));

        $index->assertOk();
        $index->assertSee('Mis turnos');
        $index->assertSee(route('my-schedule.events'));

        $events = $this->actingAs($personal)->getJson(route('my-schedule.events', [
            'start' => '2026-06-01',
            'end' => '2026-07-01',
        ]));

        $events->assertOk();
        $events->assertJsonCount(1);
        $events->assertJsonFragment(['id' => (string) $own->id]);
        $events->assertJsonFragment(['staff_name' => 'Turno Propio']);
        $events->assertJsonMissing(['staff_name' => 'Turno Ajeno']);
    }

    public function test_personal_without_staff_profile_gets_empty_schedule_without_error(): void
    {
        $personal = User::factory()->create(['role' => User::ROLE_STAFF]);
        $this->createAssignment(['staff_name' => 'Turno No Asociado']);

        $index = $this->actingAs($personal)->get(route('my-schedule.index'));
        $events = $this->actingAs($personal)->getJson(route('my-schedule.events', [
            'start' => '2026-06-01',
            'end' => '2026-07-01',
        ]));

        $index->assertOk();
        $index->assertSee('No tienes una ficha de personal asociada.');
        $events->assertOk();
        $events->assertExactJson([]);
    }

    public function test_role_scoped_routes_do_not_replace_admin_global_routes(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $manager = User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER]);
        $personal = User::factory()->create(['role' => User::ROLE_STAFF]);

        $this->actingAs($admin)->get(route('admin.calendar.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.reports.index'))->assertOk();
        $this->actingAs($manager)->get(route('admin.calendar.index'))->assertForbidden();
        $this->actingAs($manager)->get(route('admin.reports.index'))->assertForbidden();
        $this->actingAs($personal)->get(route('service-calendar.index'))->assertForbidden();
        $this->actingAs($personal)->get(route('service-reports.index'))->assertForbidden();
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
            'user_id' => $overrides['staff_user_id'] ?? null,
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
