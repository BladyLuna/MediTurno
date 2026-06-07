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
                    'Calendario mensual',
                    'Reportes',
                    'Auditoría',
                    'Solicitudes y notificaciones',
                ],
            ],
            'jefe_servicio' => [
                'title' => 'Panel de jefatura',
                'subtitle' => 'Revisión administrativa de solicitudes de servicios asignados.',
                'items' => [
                    'Revisión de solicitudes',
                    'Aprobación o rechazo administrativo',
                    'Notificaciones internas',
                    'Servicios asignados',
                ],
            ],
            'personal' => [
                'title' => 'Panel personal',
                'subtitle' => 'Seguimiento de solicitudes y notificaciones de turnos.',
                'items' => [
                    'Solicitudes de cambio',
                    'Estado de revisión',
                    'Notificaciones internas',
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
