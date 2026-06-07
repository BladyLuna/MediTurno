<?php

namespace Database\Factories;

use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShiftAssignment>
 */
class ShiftAssignmentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $serviceShiftTemplate = ServiceShiftTemplate::factory()->create();
        $staff = Staff::factory()->create([
            'hospital_service_id' => $serviceShiftTemplate->hospital_service_id,
        ]);
        $user = User::factory()->create(['role' => User::ROLE_ADMIN]);

        return [
            'staff_id' => $staff->id,
            'hospital_service_id' => $serviceShiftTemplate->hospital_service_id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
            'assignment_date' => '2026-06-07',
            'start_at' => '2026-06-07 08:00:00',
            'end_at' => '2026-06-07 16:00:00',
            'status' => ShiftAssignment::STATUS_ASSIGNED,
            'notes' => null,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];
    }
}
