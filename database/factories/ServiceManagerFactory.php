<?php

namespace Database\Factories;

use App\Models\HospitalService;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceManager>
 */
class ServiceManagerFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => User::ROLE_SERVICE_MANAGER])->id,
            'hospital_service_id' => HospitalService::factory(),
        ];
    }
}
