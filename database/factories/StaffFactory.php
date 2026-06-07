<?php

namespace Database\Factories;

use App\Models\HospitalService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'hospital_service_id' => HospitalService::factory(),
            'ci' => fake()->unique()->numerify('########'),
            'full_name' => fake()->name(),
            'position' => fake()->jobTitle(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'active' => true,
        ];
    }
}
