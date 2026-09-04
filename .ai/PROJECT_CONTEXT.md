# Contexto del Proyecto MediTurno

## Resumen

MediTurno es un sistema web de gestion de turnos hospitalarios desarrollado como
proyecto de grado. Sustituye la administracion manual en hojas de calculo por una
aplicacion con roles, servicios, personal, turnos configurables, asignaciones,
calendario, reportes, auditoria y solicitudes de cambio.

Evidencia: [`README.md`](../README.md), [`.ia/architecture.md`](../.ia/architecture.md)
y [`docs/decisions.md`](../docs/decisions.md).

## Estado observado

- El roadmap oficial documenta el MVP en Sprints 1 a 10.
- DEC-013 agrega vistas por rol y reportes restringidos por servicio.
- DEC-014 agrega gestion operativa de asignaciones para jefatura.
- El codigo actual contiene rutas, controladores, vistas y pruebas para estas
  ampliaciones.

## Actores confirmados

| Rol | Responsabilidad general | Evidencia |
|---|---|---|
| `admin` | Administracion global del sistema | `.ia/business-rules.md`, `routes/web.php` |
| `jefe_servicio` | Operacion limitada a servicios asociados | DEC-013, DEC-014, `UserScopeService` |
| `personal` | Consulta de turnos propios y gestion de solicitudes | DEC-013, `routes/web.php` |

## Modulos observados

- Autenticacion y dashboard.
- Usuarios y control de estado.
- Servicios hospitalarios.
- Personal de salud.
- Jefaturas por servicio.
- Plantillas globales y turnos por servicio.
- Asignaciones y disponibilidad.
- Calendario global, por servicio y personal.
- Reportes HTML, CSV y PDF.
- Solicitudes de cambio.
- Notificaciones internas.
- Auditoria.

## Arquitectura resumida

- Backend: PHP 8.2 y Laravel 10.
- Presentacion: Blade, Bootstrap 5, Vite y FullCalendar.
- Persistencia: MySQL 8 mediante Eloquent y migraciones.
- Reglas criticas: servicios de dominio para horarios, traslapes, alcance por rol,
  reportes, auditoria y notificaciones.
- Infraestructura local: Docker Compose con PHP-FPM, Nginx y MySQL.

## Reglas estructurales

- `.ai/*` es la fuente de verdad del ecosistema de analisis segun DEC-015.
- `.ia/*` permanece como carpeta heredada temporal hasta validar su retiro.
- `docs/decisions.md` conserva las decisiones formales.
- Los roles se almacenan en `users.role`.
- No se permiten turnos traslapados; los consecutivos si son validos.
- Los turnos nocturnos cruzan al dia siguiente en `start_at` y `end_at`.
- Las operaciones criticas usan transacciones y auditoria.
- El alcance del jefe se deriva de `service_managers`.
- El personal se identifica por `staff.user_id`.

## Areas pendientes de validacion humana

- Estado real de CI/CD, Render y GitHub Pages descritos en `CLAUDE.md`.
- Vigencia de las rutas y nombres historicos incluidos en `CLAUDE.md`.
- Alineacion de README, QA y flujo demo con Sprints 11 y 12.
- Contenido y autoridad del PDF de requerimientos y de la entrevista DOCX.
