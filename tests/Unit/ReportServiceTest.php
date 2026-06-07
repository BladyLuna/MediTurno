<?php

namespace Tests\Unit;

use App\Models\HospitalService;
use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use App\Models\ShiftTemplate;
use App\Models\Staff;
use App\Services\ReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculates_day_shift_duration(): void
    {
        $assignment = $this->assignment([
            'start_at' => '2026-06-10 08:00:00',
            'end_at' => '2026-06-10 16:00:00',
        ]);

        $row = app(ReportService::class)->detailRow($assignment->fresh([
            'staff',
            'hospitalService',
            'serviceShiftTemplate.shiftTemplate',
        ]));

        $this->assertSame(480, $row['minutes']);
        $this->assertSame('08:00', $row['duration']);
    }

    public function test_calculates_night_shift_duration_from_start_and_end(): void
    {
        $assignment = $this->assignment([
            'start_at' => '2026-06-10 21:00:00',
            'end_at' => '2026-06-11 07:00:00',
        ]);

        $row = app(ReportService::class)->detailRow($assignment->fresh([
            'staff',
            'hospitalService',
            'serviceShiftTemplate.shiftTemplate',
        ]));

        $this->assertSame(600, $row['minutes']);
        $this->assertSame('10:00', $row['duration']);
    }

    public function test_groups_by_service(): void
    {
        $assignment = $this->assignment(['service_name' => 'Emergencia']);

        $report = app(ReportService::class)->build([
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
            'group_by' => 'service',
        ]);

        $this->assertSame('Emergencia', $report['grouped']->first()['label']);
        $this->assertSame($assignment->hospital_service_id, $report['details']->first()['hospital_service_id']);
    }

    public function test_groups_by_staff(): void
    {
        $assignment = $this->assignment(['staff_name' => 'Ana Rojas']);

        $report = app(ReportService::class)->build([
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
            'group_by' => 'staff',
        ]);

        $this->assertSame('Ana Rojas', $report['grouped']->first()['label']);
        $this->assertSame($assignment->staff_id, $report['details']->first()['staff_id']);
    }

    public function test_excludes_cancelled_and_includes_changed_assignments(): void
    {
        $changed = $this->assignment(['status' => ShiftAssignment::STATUS_CHANGED]);
        $cancelled = $this->assignment(['status' => ShiftAssignment::STATUS_CANCELLED]);

        $report = app(ReportService::class)->build([
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
        ]);

        $ids = $report['details']->pluck('id')->all();

        $this->assertContains($changed->id, $ids);
        $this->assertNotContains($cancelled->id, $ids);
    }

    public function test_effective_shift_name_uses_custom_or_base_name(): void
    {
        $base = ShiftTemplate::factory()->create(['name' => 'Mañana', 'code' => 'M']);
        $custom = ServiceShiftTemplate::factory()->create([
            'shift_template_id' => $base->id,
            'custom_name' => 'Mañana Emergencia',
        ]);
        $inherited = ServiceShiftTemplate::factory()->create([
            'shift_template_id' => $base->id,
            'custom_name' => null,
        ]);

        $service = app(ReportService::class);

        $this->assertSame('Mañana Emergencia', $service->effectiveName($custom));
        $this->assertSame('Mañana', $service->effectiveName($inherited));
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    private function assignment(array $overrides = []): ShiftAssignment
    {
        $hospitalService = HospitalService::factory()->create([
            'name' => $overrides['service_name'] ?? fake()->unique()->words(2, true),
        ]);
        $staff = Staff::factory()->create([
            'hospital_service_id' => $hospitalService->id,
            'full_name' => $overrides['staff_name'] ?? fake()->name(),
        ]);
        $shiftTemplate = ShiftTemplate::factory()->create([
            'name' => $overrides['shift_name'] ?? fake()->unique()->words(2, true),
            'code' => $overrides['shift_code'] ?? strtoupper(fake()->unique()->bothify('??#')),
        ]);
        $serviceShiftTemplate = ServiceShiftTemplate::factory()->create([
            'hospital_service_id' => $hospitalService->id,
            'shift_template_id' => $shiftTemplate->id,
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
