<?php

namespace Database\Factories;

use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use App\Models\ShiftChangeRequest;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShiftChangeRequest>
 */
class ShiftChangeRequestFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $serviceShiftTemplate = ServiceShiftTemplate::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_STAFF]);
        $staff = Staff::factory()->create([
            'user_id' => $user->id,
            'hospital_service_id' => $serviceShiftTemplate->hospital_service_id,
        ]);
        $assignment = ShiftAssignment::factory()->create([
            'staff_id' => $staff->id,
            'hospital_service_id' => $serviceShiftTemplate->hospital_service_id,
            'service_shift_template_id' => $serviceShiftTemplate->id,
        ]);

        return [
            'shift_assignment_id' => $assignment->id,
            'requested_by' => $user->id,
            'reviewed_by' => null,
            'reason' => fake()->sentence(),
            'status' => ShiftChangeRequest::STATUS_PENDING,
            'review_notes' => null,
        ];
    }
}
