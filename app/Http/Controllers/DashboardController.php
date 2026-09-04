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
                    ['label' => 'Usuarios', 'route' => 'admin.users.index'],
                    ['label' => 'Servicios hospitalarios', 'route' => 'admin.hospital-services.index'],
                    ['label' => 'Personal de salud', 'route' => 'admin.staff.index'],
                    ['label' => 'Turnos y asignaciones', 'route' => 'admin.shift-assignments.index'],
                    ['label' => 'Calendario mensual', 'route' => 'admin.calendar.index'],
                    ['label' => 'Reportes', 'route' => 'admin.reports.index'],
                    ['label' => 'Auditoría', 'route' => 'admin.audit-logs.index'],
                    ['label' => 'Solicitudes y notificaciones', 'route' => 'admin.shift-change-requests.index'],
                ],
            ],
            'jefe_servicio' => [
                'title' => 'Panel de jefatura',
                'subtitle' => 'Consulta operativa de los servicios asignados.',
                'items' => [
                    ['label' => 'Dashboard operativo', 
                     'route' => 'service-dashboard.index'
                    ],
                    ['label' => 'Asignaciones del servicio', 'route' => 'service-assignments.index'],
                    ['label' => 'Disponibilidad del personal', 'route' => 'service-availability.index'],
                    ['label' => 'Calendario de servicios', 'route' => 'service-calendar.index'],
                    ['label' => 'Personal del servicio', 'route' => 'service-staff.index'],
                    ['label' => 'Reportes por servicio', 'route' => 'service-reports.index'],
                    ['label' => 'Revisión de solicitudes', 'route' => 'admin.shift-change-requests.index'],
                    ['label' => 'Notificaciones internas', 'route' => 'notifications.index'],
                ],
            ],
            'personal' => [
                'title' => 'Panel personal',
                'subtitle' => 'Consulta de tus turnos, solicitudes y notificaciones.',
                'items' => [
                    ['label' => 'Mis turnos', 'route' => 'my-schedule.index'],
                    ['label' => 'Solicitudes de cambio', 'route' => 'shift-change-requests.index'],
                    ['label' => 'Notificaciones internas', 'route' => 'notifications.index'],
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
