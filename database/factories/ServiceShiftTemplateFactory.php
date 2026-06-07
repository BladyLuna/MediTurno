<?php

namespace Database\Factories;

use App\Models\HospitalService;
use App\Models\ShiftTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceShiftTemplate>
 */
class ServiceShiftTemplateFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hospital_service_id' => HospitalService::factory(),
            'shift_template_id' => ShiftTemplate::factory(),
            'custom_code' => null,
            'custom_name' => null,
            'custom_start_time' => null,
            'custom_end_time' => null,
            'custom_color' => null,
            'active' => true,
        ];
    }
}
