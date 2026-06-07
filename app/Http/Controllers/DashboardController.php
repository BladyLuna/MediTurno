<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $roleMeta = [
            'admin' => [
                'title' => 'Panel administrativo',
                'subtitle' => 'Gestión general del sistema MediTurno.',
                'items' => [
                    'Usuarios',
                    'Servicios hospitalarios',
                    'Personal de salud',
                    'Turnos y asignaciones',
                    'Reportes',
                    'Configuración',
                ],
            ],
            'jefe_servicio' => [
                'title' => 'Panel de jefatura',
                'subtitle' => 'Control de servicios y turnos bajo tu administración.',
                'items' => [
                    'Personal asignado',
                    'Turnos de servicios administrados',
                    'Calendario mensual',
                    'Reportes por servicio',
                ],
            ],
            'personal' => [
                'title' => 'Panel personal',
                'subtitle' => 'Consulta rápida de tus turnos programados.',
                'items' => [
                    'Mis turnos',
                    'Calendario mensual',
                    'Historial de asignaciones',
                ],
            ],
        ];

        $currentRole = $user?->role ?? 'personal';
        $meta = $roleMeta[$currentRole] ?? $roleMeta['personal'];

        return view('dashboard.index', [
            'user' => $user,
            'roleMeta' => $meta,
        ]);
    }
}
