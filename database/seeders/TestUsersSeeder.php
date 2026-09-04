<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrador MediTurno',
                'email' => 'admin@mediturno.test',
                'password' => '12345678',
                'role' => 'admin',
                'active' => true,
            ],
            [
                'name' => 'Jefe de Servicio MediTurno',
                'email' => '-',
                'password' => '12345678',
                'role' => 'jefe_servicio',
                'active' => true,
            ],
            [
                'name' => 'Personal MediTurno',
                'email' => 'personal@mediturno.test',
                'password' => '12345678',
                'role' => 'personal',
                'active' => true,
            ],
        ];

        foreach ($users as $data) {
            User::query()->updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'],
                    'active' => $data['active'],
                ]
            );
        }
    }
}
