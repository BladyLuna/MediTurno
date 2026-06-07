<?php

namespace Tests\Unit;

use App\Models\HospitalService;
use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use App\Models\ShiftTemplate;
use App\Models\Staff;
use App\Services\ShiftCalendarService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShiftCalendarServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_effective_color_uses_custom_color(): void
    {
        $serviceShiftTemplate = ServiceShiftTemplate::factory()->create([
            'custom_color' => '#dc3545',
            'shift_template_id' => ShiftTemplate::factory()->create(['color' => '#0d6efd'])->id,
        ]);

        $this->assertSame('#dc3545', app(ShiftCalendarService::class)->effectiveColor($serviceShiftTemplate));
    }

    public function test_effective_color_inherits_shift_template_color(): void
    {
        $serviceShiftTemplate = ServiceShiftTemplate::factory()->create([
            'custom_color' => null,
            'shift_template_id' => ShiftTemplate::factory()->create(['color' => '#198754'])->id,
        ]);

        $this->assertSame('#198754', app(ShiftCalendarService::class)->effectiveColor($serviceShiftTemplate));
    }

    public function test_effective_name_uses_custom_name_or_base_name(): void
    {
        $base = ShiftTemplate::factory()->create(['name' => 'Mañana']);
        $custom = ServiceShiftTemplate::factory()->create([
            'shift_template_id' => $base->id,
            'custom_name' => 'Mañana Emergencia',
        ]);
        $inherited = ServiceShiftTemplate::factory()->create([
            'shift_template_id' => $base->id,
            'custom_name' => null,
        ]);

        $service = app(ShiftCalendarService::class);

        $this->assertSame('Mañana Emergencia', $service->effectiveName($custom));
        $this->assertSame('Mañana', $service->effectiveName($inherited));
    }

    public function test_event_keeps_night_shift_end_on_next_day(): void
    {
        $assignment = $this->assignment([
            'start_at' => '2026-06-10 21:00:00',
            'end_at' => '2026-06-11 07:00:00',
        ]);

        $event = app(ShiftCalendarService::class)->toEvent($assignment->fresh([
            'staff',
            'hospitalService',
            'serviceShiftTemplate.shiftTemplate',
        ]));

        $this->assertSame('2026-06-10T21:00:00', $event['start']);
        $this->assertSame('2026-06-11T07:00:00', $event['end']);
        $this->assertSame('2026-06-11 07:00', $event['extendedProps']['end_time']);
    }

    public function test_events_exclude_cancelled_assignments(): void
    {
        $included = $this->assignment(['status' => ShiftAssignment::STATUS_CHANGED]);
        $cancelled = $this->assignment(['status' => ShiftAssignment::STATUS_CANCELLED]);

        $events = app(ShiftCalendarService::class)->events(
            now()->parse('2026-06-01'),
            now()->parse('2026-07-01')
        );

        $ids = collect($events)->pluck('id')->all();

        $this->assertContains((string) $included->id, $ids);
        $this->assertNotContains((string) $cancelled->id, $ids);
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    private function assignment(array $overrides = []): ShiftAssignment
    {
        $hospitalService = HospitalService::factory()->create();
        $staff = Staff::factory()->create(['hospital_service_id' => $hospitalService->id]);
        $shiftTemplate = ShiftTemplate::factory()->create([
            'name' => 'Noche',
            'code' => 'N',
            'color' => '#6610f2',
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
