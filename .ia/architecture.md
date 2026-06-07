# Arquitectura MediTurno

## Fuente de Verdad

Los documentos dentro de `.ia/` son la fuente de verdad del proyecto.

Si existe una diferencia entre `.ia/*`, `README.md` o `CLAUDE.md`, debe prevalecer
la documentación de `.ia/*`.

## Principios de Arquitectura

MediTurno debe mantenerse como un sistema Laravel MVC de alcance académico,
pero con separación clara de responsabilidades:

- Controladores para recibir la petición y devolver vistas o respuestas.
- Form Requests para validación.
- Policies o Gates para autorización.
- Modelos Eloquent para relaciones de datos.
- Servicios de dominio para reglas críticas.
- Auditoría centralizada para registrar operaciones importantes.

## Capas Recomendadas

### Presentación

- Blade Templates.
- Bootstrap 5.
- FullCalendar para calendario mensual.
- JavaScript mínimo para interacción visual.

### Aplicación

- Controllers por módulo.
- Form Requests por operación.
- Policies o Gates por entidad.
- Middlewares de autenticación y rol.
- Roles almacenados en `users.role`.

No se usarán paquetes externos de permisos.

### Dominio

Servicios recomendados:

- `ShiftConflictService`: validación de conflictos y traslapes.
- `AuditLogService`: registro de operaciones críticas.
- `ReportService`: generación de reportes.
- `NotificationService`: notificaciones internas, opcional para MVP.

## Nombres Oficiales

- La clave foránea oficial hacia servicios es `hospital_service_id`.
- El modelo de turnos usa `shift_templates` y `service_shift_templates`.
- Las asignaciones usan `service_shift_template_id`.

### Persistencia

- MySQL 8 como base principal.
- Eloquent ORM.
- Migraciones versionadas.
- SoftDeletes en entidades administrables.
- Índices y claves foráneas.

## Transacciones de Base de Datos

Toda operación crítica deberá ejecutarse mediante transacciones.

Casos obligatorios:

- Crear usuario.
- Actualizar usuario.
- Activar o desactivar usuario.
- Crear empleado.
- Actualizar empleado.
- Eliminar lógicamente empleado.
- Crear servicio.
- Actualizar servicio.
- Crear turno.
- Modificar turno.
- Configurar turno por servicio.
- Asignar turno.
- Modificar asignación.
- Eliminar asignación.
- Registrar auditoría.
- Aprobar o rechazar solicitud de cambio, si entra al MVP.

Si alguna operación falla:

- Realizar rollback.
- Registrar error en logs.
- Mostrar mensaje controlado al usuario.

## Auditoría

La auditoría debe iniciar en el Sprint 2, junto con la gestión de usuarios.

Motivo:
Desde usuarios, servicios, personal y asignaciones ya existen operaciones que
afectan permisos, trazabilidad e integridad del sistema. Implementar auditoría al
final impide reconstruir cambios importantes.

### Alcance mínimo de auditoría para MVP

Registrar:

- Usuario que ejecuta la acción.
- Acción realizada.
- Entidad afectada.
- ID del registro afectado.
- Valores anteriores cuando existan.
- Valores nuevos cuando existan.
- Dirección IP.
- Fecha y hora.

### Entidades obligatorias a auditar

- `users`
- `hospital_services`
- `staff`
- `shift_templates`
- `service_shift_templates`
- `shift_assignments`

### Entidades opcionales a auditar

- `shift_change_requests`
- `absences`
- `vacations`
- `notifications`

Estas entidades se auditan cuando sean implementadas.

## Impacto Arquitectónico de Auditoría

- Agregar tabla `audit_logs`.
- Agregar servicio centralizado de auditoría.
- Usar transacciones para guardar cambios y auditoría en la misma operación.
- Evitar duplicar lógica de auditoría en cada controlador.
- Registrar auditoría desde la capa de aplicación o dominio, no desde la vista.

## Funcionalidades del Dominio

Las siguientes funcionalidades pertenecen al dominio del sistema, aunque no todas
son obligatorias en el MVP:

- `shift_change_requests`: solicitudes de cambio de turno.
- `absences`: ausencias, permisos o bajas.
- `vacations`: vacaciones del personal.
- `notifications`: avisos internos o externos sobre cambios.

Clasificación:

- MVP obligatorio: no incluye estas cuatro como núcleo obligatorio.
- MVP opcional: `shift_change_requests` y `notifications` internas básicas.
- Post-MVP: `absences`, `vacations` y notificaciones externas.

Esta clasificación permite conservar una arquitectura preparada para crecer sin
sobrecargar la primera versión del proyecto.

## Calendario

La actualización del calendario será mediante recarga de la vista o nueva consulta
al endpoint de eventos.

No se implementará actualización automática continua en el MVP.
