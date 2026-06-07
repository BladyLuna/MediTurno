<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InternalNotification>
 */
class InternalNotificationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => 'test',
            'title' => fake()->sentence(3),
            'message' => fake()->sentence(),
            'data' => null,
            'read_at' => null,
        ];
    }
}
