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

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_reports(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->get(route('admin.reports.index', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
        ]));

        $response->assertOk();
        $response->assertSee('Reportes básicos');
        $response->assertSee('Resumen de turnos asignados');
        $response->assertSee('Exportar PDF');
    }

    public function test_non_admin_cannot_view_reports(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_STAFF]);

        $response = $this->actingAs($user)->get(route('admin.reports.index'));

        $response->assertForbidden();
    }

    public function test_report_includes_assigned_and_changed_but_excludes_cancelled(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $assigned = $this->createAssignment([
            'staff_name' => 'Asignado Uno',
            'status' => ShiftAssignment::STATUS_ASSIGNED,
        ]);
        $changed = $this->createAssignment([
            'staff_name' => 'Cambiado Uno',
            'status' => ShiftAssignment::STATUS_CHANGED,
        ]);
        $cancelled = $this->createAssignment([
            'staff_name' => 'Cancelado Uno',
            'status' => ShiftAssignment::STATUS_CANCELLED,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.reports.index', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
        ]));

        $response->assertOk();
        $response->assertSee($assigned->staff->full_name);
        $response->assertSee($changed->staff->full_name);
        $response->assertDontSee('<div>' . $cancelled->staff->full_name . '</div>', false);
    }

    public function test_report_excludes_soft_deleted_assignments(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $deleted = $this->createAssignment(['staff_name' => 'Eliminado Logico']);
        $deleted->delete();

        $response = $this->actingAs($admin)->get(route('admin.reports.index', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
        ]));

        $response->assertOk();
        $response->assertDontSee('<div>Eliminado Logico</div>', false);
        $response->assertSee('No hay datos para el rango seleccionado.');
    }

    public function test_report_filters_by_service(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $included = $this->createAssignment([
            'service_name' => 'Emergencia',
            'staff_name' => 'Personal Emergencia',
        ]);
        $this->createAssignment([
            'service_name' => 'Laboratorio',
            'staff_name' => 'Personal Laboratorio',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.reports.index', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
            'hospital_service_id' => $included->hospital_service_id,
        ]));

        $response->assertOk();
        $response->assertSee('<div>Personal Emergencia</div>', false);
        $response->assertDontSee('<div>Personal Laboratorio</div>', false);
    }

    public function test_report_filters_by_staff(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $included = $this->createAssignment(['staff_name' => 'Personal Incluido']);
        $this->createAssignment(['staff_name' => 'Personal Excluido']);

        $response = $this->actingAs($admin)->get(route('admin.reports.index', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
            'staff_id' => $included->staff_id,
            'group_by' => 'staff',
        ]));

        $response->assertOk();
        $response->assertSee('<div class="fw-semibold">Personal Incluido</div>', false);
        $response->assertDontSee('<div>Personal Excluido</div>', false);
    }

    public function test_report_filters_by_real_interval_range(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $overlapping = $this->createAssignment([
            'staff_name' => 'Turno Solapado',
            'start_at' => '2026-05-31 21:00:00',
            'end_at' => '2026-06-01 07:00:00',
        ]);
        $outside = $this->createAssignment([
            'staff_name' => 'Fuera de Rango',
            'start_at' => '2026-05-30 08:00:00',
            'end_at' => '2026-05-30 16:00:00',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.reports.index', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
        ]));

        $response->assertOk();
        $response->assertSee('<div>' . $overlapping->staff->full_name . '</div>', false);
        $response->assertDontSee('<div>' . $outside->staff->full_name . '</div>', false);
    }

    public function test_report_calculates_night_shift_hours_from_start_and_end(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->createAssignment([
            'staff_name' => 'Turno Nocturno',
            'shift_name' => 'Noche',
            'start_at' => '2026-06-10 21:00:00',
            'end_at' => '2026-06-11 07:00:00',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.reports.index', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
        ]));

        $response->assertOk();
        $response->assertSee('Turno Nocturno');
        $response->assertSee('10:00');
    }

    public function test_report_can_group_by_service_and_staff(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $assignment = $this->createAssignment([
            'service_name' => 'Emergencia',
            'staff_name' => 'Ana Rojas',
        ]);

        $byService = $this->actingAs($admin)->get(route('admin.reports.index', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
            'group_by' => 'service',
        ]));

        $byStaff = $this->actingAs($admin)->get(route('admin.reports.index', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
            'group_by' => 'staff',
        ]));

        $byService->assertOk();
        $byService->assertSee($assignment->hospitalService->name);
        $byStaff->assertOk();
        $byStaff->assertSee($assignment->staff->full_name);
    }

    public function test_report_exports_csv_using_same_filters(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $included = $this->createAssignment([
            'staff_name' => 'CSV Incluido',
            'service_name' => 'Emergencia CSV',
        ]);
        $this->createAssignment([
            'staff_name' => 'CSV Excluido',
            'service_name' => 'Laboratorio CSV',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.reports.export', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
            'hospital_service_id' => $included->hospital_service_id,
        ]));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');

        $content = $response->streamedContent();

        $this->assertStringContainsString('CSV Incluido', $content);
        $this->assertStringNotContainsString('CSV Excluido', $content);
        $this->assertStringContainsString('Fecha,Personal,CI,Servicio,Turno,Estado,Inicio,Fin,Horas', $content);
    }

    public function test_report_exports_pdf_using_same_filters(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $included = $this->createAssignment([
            'staff_name' => 'PDF Incluido',
            'service_name' => 'Emergencia PDF',
        ]);
        $this->createAssignment([
            'staff_name' => 'PDF Excluido',
            'service_name' => 'Laboratorio PDF',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.reports.pdf', [
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
            'hospital_service_id' => $included->hospital_service_id,
            'group_by' => 'service',
        ]));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF', $response->getContent());
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
        ]);
        $serviceShiftTemplate = ServiceShiftTemplate::factory()->create([
            'hospital_service_id' => $hospitalService->id,
            'shift_template_id' => $shiftTemplate->id,
            'custom_name' => $overrides['custom_name'] ?? null,
            'custom_code' => $overrides['custom_code'] ?? null,
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
