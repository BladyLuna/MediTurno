<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShiftTemplate>
 */
class ShiftTemplateFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('??#')),
            'name' => fake()->unique()->words(2, true),
            'start_time' => '08:00',
            'end_time' => '16:00',
            'color' => '#0d6efd',
            'is_working_shift' => true,
            'active' => true,
        ];
    }
}
