DEC-001

Roles se almacenarán en users.role

Motivo:
Proyecto pequeño.

Alternativas:
Paquetes externos de permisos.

Decisión:
No usar paquetes externos de permisos.

Fecha:
2026-06-06

---

DEC-002

La documentación queda congelada.

Fuente de verdad:
`.ia/*`

Impacto:
A partir de este punto cualquier cambio de alcance, modelo de datos o reglas de
negocio debe registrarse en `decisions.md`.

Fecha:
2026-06-07

---

DEC-003

La regla oficial de conflicto de turnos es:

"No se permiten turnos traslapados".

Motivo:
Permite modelar correctamente asignaciones por intervalos de fecha y hora.

Impacto:
Las asignaciones deben validarse con `start_at` y `end_at`.

Fecha:
2026-06-06

---

DEC-004

Los turnos nocturnos se almacenarán con `start_at` en la fecha asignada y `end_at`
en la fecha siguiente cuando crucen medianoche.

Ejemplo:
21:00 a 07:00 se guarda como inicio en el día asignado y fin al día siguiente.

Motivo:
Permitir validación correcta de traslapes.

Fecha:
2026-06-06

---

DEC-005

El nombre oficial de la clave foránea hacia servicios será `hospital_service_id`.

Motivo:
Evitar inconsistencias de nombres en relaciones hacia servicios hospitalarios.

Fecha:
2026-06-06

---

DEC-006

Un jefe de servicio puede administrar múltiples servicios.

Motivo:
Algunos contextos hospitalarios pueden requerir que una persona supervise más de
un área.

Impacto:
Usar relación `service_managers`.

Fecha:
2026-06-06

---

DEC-007

El calendario se actualizará mediante recarga de vista o nueva consulta al endpoint
de eventos.

Motivo:
Mantener el alcance realista para proyecto de grado.

Alternativa descartada:
Actualización automática continua con WebSockets.

Fecha:
2026-06-06

---

DEC-008

Estados permitidos:

- `shift_assignments.status`: `assigned`, `changed`, `cancelled`.
- `shift_change_requests.status`: `pending`, `approved`, `rejected`, `cancelled`.
- `absences.status`: `pending`, `approved`, `rejected`, `cancelled`.
- `vacations.status`: `pending`, `approved`, `rejected`, `cancelled`.

Motivo:
Evitar estados ambiguos y facilitar validaciones, reportes y auditoría.

Fecha:
2026-06-06

---

DEC-009

Reglas de proteccion para administradores:

- No se permite desactivar el ultimo usuario `admin` activo.
- No se permite eliminar logicamente el ultimo usuario `admin` activo.
- No se permite que un administrador se desactive a si mismo.
- No se permite que un administrador se elimine a si mismo.

Motivo:
Evitar que el sistema quede sin usuarios con capacidad de administracion y
prevenir bloqueos accidentales de acceso durante la gestion de usuarios.

Impacto:
El CRUD de usuarios debe validar estas reglas antes de desactivar o eliminar
logicamente cuentas con rol `admin`.

Fecha:
2026-06-07

---

DEC-010

Asociacion entre personal de salud y usuarios:

Si un registro de `staff` se asocia con un `user`, ese usuario debe tener rol
`personal`.

No se permite asociar personal de salud a usuarios con rol `admin` o
`jefe_servicio`.

Motivo:
Evitar mezclar cuentas administrativas o de jefatura con perfiles operativos de
personal de salud.

Impacto:
Las validaciones del CRUD de personal deben restringir `user_id` a usuarios con
rol `personal` y mantener la asociacion como opcional.

Fecha:
2026-06-07

---

DEC-011

Horarios personalizados en turnos por servicio:

En `service_shift_templates`, si se define `custom_start_time` o
`custom_end_time`, ambos campos deben definirse juntos.

Se permiten horarios donde la hora de inicio sea mayor que la hora de fin. Ese
caso representa un turno nocturno que cruza al dia siguiente.

Motivo:
Evitar configuraciones incompletas de horario y mantener compatibilidad con
turnos nocturnos como `21:00` a `07:00`.

Impacto:
Las validaciones de turnos por servicio no deben rechazar turnos nocturnos, pero
si deben rechazar configuraciones con solo una hora personalizada.

Fecha:
2026-06-07
