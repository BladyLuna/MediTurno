# Inventario Inicial del Proyecto

Fecha del inventario: 2026-06-19.

> Nota historica: este inventario refleja el estado anterior a DEC-015. Desde esa
> decision, `.ai/` es la fuente de verdad del ecosistema de analisis y `.ia/`
> permanece como carpeta heredada temporal.

## Alcance de esta inspeccion

Se revisaron documentos Markdown del repositorio, directorios de herramientas,
estructura Laravel, rutas, controladores, servicios, modelos, migraciones, vistas,
pruebas y archivos de dependencias. No se modifico ningun archivo existente.

Se excluyeron `vendor/`, `node_modules/` y `storage/` del inventario documental por
contener dependencias o archivos generados, no documentacion propia del proyecto.

## Identificacion

| Elemento | Valor observado | Evidencia |
|---|---|---|
| Proyecto | MediTurno | `README.md` |
| Tipo | Sistema web de turnos hospitalarios | `README.md`, `.ia/project-grade.md` |
| Backend | PHP 8.2, Laravel 10 | `composer.json`, `README.md` |
| Base de datos | MySQL 8 | `docker-compose.yml`, `.ia/architecture.md` |
| Frontend | Blade, Bootstrap 5, Vite | `package.json`, `resources/views/` |
| Calendario | FullCalendar 6 | `package.json` |
| PDF | DomPDF para Laravel | `composer.json` |
| Infraestructura local | Docker Compose, PHP-FPM, Nginx y MySQL | `Dockerfile`, `docker-compose.yml`, `docker/` |
| Autenticacion | Sesion web nativa de Laravel | `routes/web.php`, `LoginController` |
| Roles | `admin`, `jefe_servicio`, `personal` | `.ia/business-rules.md`, `User.php` |

## Magnitud tecnica observada

| Componente | Cantidad | Observacion |
|---|---:|---|
| Rutas no pertenecientes a vendor | 91 | Resultado de `php artisan route:list --except-vendor` |
| Controladores PHP | 28 | Incluye controlador base |
| Modelos Eloquent | 10 | Entidades principales del dominio implementado |
| Servicios de aplicacion/dominio | 10 | Incluye autenticacion, auditoria, horarios y reportes |
| Policies | 9 | Autorizacion por entidad |
| Migraciones | 14 | Incluye tablas base de Laravel |
| Vistas Blade | 49 | Administracion, jefatura, personal y autenticacion |
| Archivos de prueba PHP | 19 | Feature, Unit y soporte de pruebas |
| Seeders | 3 | Base, usuarios de prueba y datos demo |

## Modelos detectados

- `User`
- `HospitalService`
- `Staff`
- `ServiceManager`
- `ShiftTemplate`
- `ServiceShiftTemplate`
- `ShiftAssignment`
- `ShiftChangeRequest`
- `InternalNotification`
- `AuditLog`

## Servicios detectados

- `LoginService`
- `AuditLogService`
- `ShiftTimeService`
- `ShiftConflictService`
- `ShiftCalendarService`
- `ReportService`
- `UserScopeService`
- `ServiceAvailabilityService`
- `ShiftChangeRequestService`
- `NotificationService`

## Modulos funcionales detectados

1. Autenticacion y dashboard.
2. Usuarios.
3. Servicios hospitalarios.
4. Personal de salud.
5. Jefaturas por servicio.
6. Plantillas de turno.
7. Turnos por servicio.
8. Asignaciones y disponibilidad.
9. Calendario.
10. Reportes y exportaciones.
11. Solicitudes de cambio y notificaciones.
12. Auditoria.

## Superficies por rol

- Administrador: CRUD global, calendario, reportes y auditoria.
- Jefe de servicio: dashboard, asignaciones, disponibilidad, calendario, personal,
  reportes y revision de solicitudes dentro de servicios asociados.
- Personal: calendario propio, solicitudes propias y notificaciones.

## Inventario documental inicial

- 22 archivos Markdown propios anteriores a la creacion de `.ai`.
- 1 entrevista DOCX dentro de `docs/`.
- 1 PDF de requerimientos en la raiz.
- `.agents/` y `.codex/` estaban vacios.
- `.commandcode/` contenia una skill de diseno frontend.
- `.ai/` no existia al comenzar esta fase.

El detalle se encuentra en
[`01-existing-documentation-map.md`](01-existing-documentation-map.md).

## Areas ausentes o poco claras

- No se encontro `.github/workflows/deploy.yml`, aunque `CLAUDE.md` lo describe.
- No se encontro landing page en `docs/`, aunque `CLAUDE.md` la plantea.
- El roadmap oficial llega a Sprint 10; DEC-013 y DEC-014 documentan ampliaciones
  posteriores.
- `.ia/project-grade.md` es solo un esquema tematico.
- El contenido del PDF y DOCX requiere revision especializada o humana antes de
  asignarle autoridad documental.

## Nivel de confianza

### Confirmado por codigo

- Stack principal, rutas, modelos, servicios, vistas, permisos y pruebas listados.
- Existencia de vistas diferenciadas para administrador, jefatura y personal.
- Operacion restringida por `service_managers` y `staff.user_id`.

### Confirmado por documentacion

- `.ia/*` es la fuente de verdad.
- El proyecto tiene alcance academico.
- Reglas de traslape, turnos nocturnos, auditoria y SoftDeletes.
- Decisiones DEC-001 a DEC-014.

### Inferido

- La implementacion actual corresponde al MVP mas las ampliaciones descritas por
  DEC-013 y DEC-014.
- Algunos documentos de cierre quedaron desactualizados al continuar el desarrollo.

### Pendiente de confirmar

- Estado real de despliegue productivo, CI/CD, Render y GitHub Pages.
- Vigencia de advisories de dependencias documentados anteriormente.
- Autoridad y vigencia de los documentos PDF y DOCX.
- Prioridad de una futura consolidacion entre `.ia`, `.ai`, `docs` y `CLAUDE.md`.
