# Diseño de Base de Datos MediTurno

## Fuente de Verdad

Este documento es la fuente de verdad para el modelo de base de datos.

Si `README.md` o `CLAUDE.md` usan nombres diferentes, prevalecen los nombres
definidos aquí.

## Enfoque

El diseño debe permitir implementar el MVP obligatorio sin bloquear el crecimiento
del sistema. Las entidades de solicitudes de cambio, ausencias, vacaciones y
notificaciones forman parte del dominio, pero no todas se implementan en el MVP.

## Tablas para MVP obligatorio

### `users`

Propósito:
Usuarios que acceden al sistema.

Campos principales:

- `id`
- `name`
- `email`
- `password`
- `role`
- `active`
- `timestamps`
- `deleted_at`

Reglas:

- `email` debe ser único.
- `role` debe limitarse a `admin`, `jefe_servicio`, `personal`.
- Los roles se almacenan en `users.role`.
- No se usarán paquetes externos de permisos.

### `hospital_services`

Propósito:
Servicios o áreas del hospital.

Campos principales:

- `id`
- `name`
- `description`
- `active`
- `timestamps`
- `deleted_at`

Reglas:

- El nombre del servicio debe ser único entre registros activos.

### `staff`

Propósito:
Personal de salud administrado por el sistema.

Campos principales:

- `id`
- `user_id`
- `hospital_service_id`
- `ci`
- `full_name`
- `position`
- `phone`
- `email`
- `active`
- `timestamps`
- `deleted_at`

Reglas:

- `ci` debe ser único entre registros activos.
- `user_id` puede ser nullable para permitir personal sin cuenta de acceso.

### `service_managers`

Propósito:
Relacionar jefes de servicio con uno o varios servicios.

Campos principales:

- `id`
- `user_id`
- `hospital_service_id`
- `timestamps`
- `deleted_at`

Reglas:

- El usuario asociado debe tener rol `jefe_servicio` o `admin`.
- Un jefe puede administrar múltiples servicios.
- Debe evitarse duplicar el mismo `user_id` con el mismo `hospital_service_id`.

### `shift_templates`

Propósito:
Definir turnos base del sistema.

Campos principales:

- `id`
- `code`
- `name`
- `start_time`
- `end_time`
- `color`
- `is_working_shift`
- `active`
- `timestamps`
- `deleted_at`

Ejemplos:

- Mañana.
- Tarde.
- Noche.
- Libre.

### `service_shift_templates`

Propósito:
Permitir que cada servicio active o personalice turnos.

Campos principales:

- `id`
- `hospital_service_id`
- `shift_template_id`
- `custom_code`
- `custom_name`
- `custom_start_time`
- `custom_end_time`
- `custom_color`
- `active`
- `timestamps`
- `deleted_at`

Reglas:

- Si no existen valores personalizados, se usan los valores de `shift_templates`.
- Permite flexibilidad controlada por servicio.
- Debe evitarse duplicar el mismo `shift_template_id` activo dentro del mismo
  `hospital_service_id`.

### `shift_assignments`

Propósito:
Registrar turnos asignados al personal.

Campos principales:

- `id`
- `staff_id`
- `hospital_service_id`
- `service_shift_template_id`
- `assignment_date`
- `start_at`
- `end_at`
- `status`
- `notes`
- `created_by`
- `updated_by`
- `timestamps`
- `deleted_at`

Reglas:

- No debe existir traslape de horarios para el mismo empleado.
- Toda creación, modificación o eliminación lógica debe auditarse.
- La asignación debe ejecutarse dentro de una transacción.
- Estados permitidos para `status`: `assigned`, `changed`, `cancelled`.
- `hospital_service_id` es el nombre oficial de la relación hacia servicios.
- `start_at` y `end_at` se usan para validar traslapes.

Turnos nocturnos:

- Si el turno termina al día siguiente, `end_at` debe guardar la fecha siguiente.
- Ejemplo: turno de `21:00` a `07:00` asignado el 2025-03-10:
  - `start_at`: 2025-03-10 21:00
  - `end_at`: 2025-03-11 07:00

### `audit_logs`

Propósito:
Registrar trazabilidad de cambios críticos.

Campos principales:

- `id`
- `user_id`
- `action`
- `model_type`
- `model_id`
- `old_values`
- `new_values`
- `ip_address`
- `user_agent`
- `created_at`

Reglas:

- Debe implementarse desde Sprint 2.
- Debe registrar operaciones críticas del MVP.
- No requiere `updated_at` ni `deleted_at`, porque representa un evento histórico.

## Tablas para MVP opcional

### `shift_change_requests`

Propósito:
Solicitudes de cambio de turno realizadas por el personal o por jefatura.

Campos principales:

- `id`
- `shift_assignment_id`
- `requested_by`
- `reviewed_by`
- `reason`
- `status`
- `review_notes`
- `timestamps`
- `deleted_at`

Clasificación:
MVP opcional.

Justificación:
Forma parte del flujo real de turnos, pero puede agregarse después del calendario y
reportes básicos.

Estados permitidos:

- `pending`
- `approved`
- `rejected`
- `cancelled`

### `notifications`

Propósito:
Avisos internos del sistema.

Campos principales:

- `id`
- `user_id`
- `type`
- `title`
- `message`
- `data`
- `read_at`
- `timestamps`

Clasificación:
MVP opcional para notificaciones internas.

Justificación:
Ayuda a comunicar cambios, pero no es imprescindible para asignar y visualizar
turnos.

## Tablas Post-MVP

### `absences`

Propósito:
Registrar ausencias, permisos o bajas del personal.

Campos principales:

- `id`
- `staff_id`
- `start_date`
- `end_date`
- `reason`
- `status`
- `created_by`
- `approved_by`
- `timestamps`
- `deleted_at`

Clasificación:
Post-MVP.

Justificación:
Requiere reglas de reemplazo y cobertura que amplían el alcance inicial.

Estados permitidos:

- `pending`
- `approved`
- `rejected`
- `cancelled`

### `vacations`

Propósito:
Registrar vacaciones del personal.

Campos principales:

- `id`
- `staff_id`
- `start_date`
- `end_date`
- `status`
- `created_by`
- `approved_by`
- `timestamps`
- `deleted_at`

Clasificación:
Post-MVP.

Justificación:
Pertenece a planificación de recursos humanos y debe incorporarse después del
módulo principal de turnos.

Estados permitidos:

- `pending`
- `approved`
- `rejected`
- `cancelled`

## Índices Recomendados

- `users.email`
- `staff.ci`
- `staff.hospital_service_id`
- `service_managers.user_id`
- `service_managers.hospital_service_id`
- `service_managers.user_id` + `service_managers.hospital_service_id`
- `service_shift_templates.hospital_service_id` + `service_shift_templates.shift_template_id`
- `shift_assignments.staff_id`
- `shift_assignments.hospital_service_id`
- `shift_assignments.assignment_date`
- `shift_assignments.start_at`
- `shift_assignments.end_at`
- `audit_logs.user_id`
- `audit_logs.model_type`
- `audit_logs.model_id`

## Integridad y Trazabilidad

La base de datos debe apoyar estas reglas:

- No borrar físicamente entidades administrables.
- Registrar auditoría de cambios críticos.
- Validar conflictos en backend.
- Usar claves foráneas.
- Usar transacciones en operaciones críticas.
- Mantener entidades opcionales preparadas en diseño, pero no necesariamente
  implementadas en el MVP.
