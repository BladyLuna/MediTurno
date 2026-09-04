# MediTurno

Sistema web de gestión de turnos hospitalarios desarrollado como proyecto de grado.

MediTurno reemplaza la gestión manual en hojas de cálculo por una aplicación Laravel
con control de roles, asignación de turnos, validación de traslapes, calendario,
reportes, auditoría y flujo básico de solicitudes de cambio.

## Stack

| Capa | Tecnología |
| --- | --- |
| Backend | PHP 8.2 + Laravel 10 |
| Frontend | Blade + Bootstrap 5 + Vite |
| Calendario | FullCalendar |
| Base de datos | MySQL 8 |
| Reportes | HTML, CSV y PDF básico |
| Entorno local | Docker Compose |

## Estado del MVP

| Módulo | Estado |
| --- | --- |
| Login, logout y roles | Implementado |
| Usuarios | Implementado |
| Servicios hospitalarios | Implementado |
| Jefes de servicio | Implementado |
| Personal de salud | Implementado |
| Plantillas de turno | Implementado |
| Turnos por servicio | Implementado |
| Asignación de turnos | Implementado |
| Validación de traslapes | Implementado |
| Calendario mensual | Implementado |
| Reportes por servicio/empleado | Implementado |
| Exportación CSV | Implementado |
| Exportación PDF básica | Implementado |
| Auditoría | Implementado |
| Solicitudes de cambio de turno | Implementado como MVP opcional |
| Notificaciones internas | Implementado como MVP opcional |
| Ausencias y vacaciones | Post-MVP |

## Roles

| Rol | Alcance |
| --- | --- |
| `admin` | Administración completa del sistema. |
| `jefe_servicio` | Revisión de solicitudes de servicios asociados. |
| `personal` | Solicitudes de cambio y notificaciones propias. |

## Reglas principales

- Los roles se almacenan en `users.role`.
- No se usan paquetes externos de permisos.
- No se permiten turnos traslapados.
- Se permiten turnos consecutivos cuando el fin de uno coincide con el inicio de otro.
- Los turnos nocturnos guardan `start_at` en la fecha asignada y `end_at` al día siguiente.
- Las operaciones críticas se auditan.
- Los registros administrables usan SoftDeletes.
- Las solicitudes de cambio se aprueban o rechazan administrativamente; no modifican automáticamente asignaciones.

## Instalación con Docker

```bash
docker compose up -d
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan test
npm run build
```

URL local:

```text
http://localhost:8080
```

## Credenciales demo

| Rol | Correo | Contraseña |
| --- | --- | --- |
| Administrador | `admin@mediturno.test` | `12345678` |
| Jefe de servicio | `jefe@mediturno.test` | `12345678` |
| Personal | `personal@mediturno.test` | `12345678` |

## Datos demo

`DatabaseSeeder` ejecuta:

- `TestUsersSeeder`
- `DemoDataSeeder`

El sistema queda listo para defensa con:

- servicios: Emergencia, UCI y Laboratorio;
- turnos: Mañana, Tarde, Noche y Libre;
- turnos por servicio;
- personal demo asociado a servicios;
- `jefe@mediturno.test` asociado a Emergencia;
- asignaciones del mes actual, incluyendo turno nocturno;
- solicitudes de cambio en estado pendiente, aprobada y rechazada;
- notificaciones internas;
- auditoría demo básica.

Para reconstruir el entorno demo:

```bash
docker compose exec app php artisan migrate:fresh --seed
```

## Flujo de defensa recomendado

1. Entrar como `admin@mediturno.test`.
2. Revisar servicios, personal, turnos y turnos por servicio.
3. Mostrar asignaciones y validación de traslapes.
4. Mostrar calendario mensual con colores y turno nocturno.
5. Mostrar reportes HTML, CSV y PDF.
6. Mostrar auditoría.
7. Entrar como `personal@mediturno.test`.
8. Crear o revisar una solicitud de cambio.
9. Entrar como `jefe@mediturno.test`.
10. Aprobar o rechazar una solicitud del servicio Emergencia.
11. Volver a personal y mostrar notificación interna.

## Rutas principales

| Módulo | Ruta |
| --- | --- |
| Dashboard | `/dashboard` |
| Usuarios | `/admin/users` |
| Servicios | `/admin/hospital-services` |
| Personal | `/admin/staff` |
| Jefes de servicio | `/admin/service-managers` |
| Plantillas de turno | `/admin/shift-templates` |
| Turnos por servicio | `/admin/service-shift-templates` |
| Asignaciones | `/admin/shift-assignments` |
| Calendario | `/admin/calendar` |
| Reportes | `/admin/reports` |
| Exportar CSV | `/admin/reports/export` |
| Exportar PDF | `/admin/reports/pdf` |
| Auditoría | `/admin/audit-logs` |
| Solicitudes del personal | `/shift-change-requests` |
| Revisión de solicitudes | `/admin/shift-change-requests` |
| Notificaciones | `/notifications` |

## Verificación final

Comandos usados para cierre:

```bash
composer audit
npm audit
npm run build
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan test
```

## Auditoría de dependencias

Resultado Composer:

- Advisory en `laravel/framework 10.50.2`.
- CVE: `CVE-2026-48019`.
- Título: Laravel CRLF injection in default email rule.
- Acción recomendada: actualización dirigida de Laravel 10 cuando exista versión segura compatible, sin ejecutar `composer update` masivo, seguida de `php artisan test`.

Resultado npm:

- Vulnerabilidad moderada en `esbuild <=0.24.2` vía `vite`.
- La corrección sugerida por npm requiere `npm audit fix --force` y salto mayor de Vite.
- Acción recomendada: evaluar actualización controlada de Vite/esbuild en Sprint 10 o mantenimiento, sin aplicar `--force` sin revisión.

## Despliegue

Ver [docs/deploy.md](docs/deploy.md).

## QA

Ver [docs/qa-checklist.md](docs/qa-checklist.md).

## Flujo demo

Ver [docs/demo-flow.md](docs/demo-flow.md).


# solo el usuario debe saber su contrrasena
validacion de correo electronuo