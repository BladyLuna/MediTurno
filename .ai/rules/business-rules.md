# Reglas de Negocio MediTurno

## Fuente de Verdad

Las reglas definidas en `.ia/business-rules.md` tienen prioridad sobre reglas
descritas en `README.md` o `CLAUDE.md`.

## BR-001 - Acceso por rol

El sistema debe controlar el acceso según rol:

- Administrador: acceso total.
- Jefe de servicio: acceso limitado a los servicios que administra.
- Personal de salud: acceso a sus propios turnos.

Impacto:
Protege información sensible y evita modificaciones no autorizadas.

Decisión:
Los roles se almacenan en `users.role`. No se usarán paquetes externos de permisos.

## BR-002 - Gestión de usuarios

Solo el administrador puede crear, editar, activar o desactivar usuarios.

Impacto:
Evita que usuarios sin autorización alteren accesos del sistema.

## BR-003 - Personal por servicio

Cada integrante del personal debe pertenecer a un servicio hospitalario principal.

Impacto:
Permite filtrar turnos, reportes y permisos por servicio.

## BR-004 - Jefe de servicio

El jefe de servicio puede administrar múltiples servicios.

Solo puede gestionar información de los servicios asociados a su usuario.

Impacto:
Mantiene separación operativa entre áreas hospitalarias.

## BR-005 - Turnos configurables por servicio

El sistema debe usar plantillas de turno configurables por servicio.

Ejemplo:

- Emergencia puede usar mañana, tarde y noche.
- Laboratorio puede usar solo mañana y tarde.

Impacto:
Permite flexibilidad sin convertir el sistema en una configuración ilimitada y
difícil de mantener.

## BR-006 - Conflicto de asignación

Regla oficial:
No se permiten turnos traslapados.

Un empleado puede tener más de una asignación solo si los intervalos de tiempo no
se traslapan.

Impacto:
Evita errores operativos críticos.

## BR-006A - Turnos nocturnos

Un turno nocturno puede iniciar en una fecha y terminar al día siguiente.

Ejemplo:
Un turno de `21:00` a `07:00` asignado el 2025-03-10 debe almacenarse como:

- `start_at`: 2025-03-10 21:00
- `end_at`: 2025-03-11 07:00

Impacto:
Permite validar traslapes correctamente en turnos que cruzan medianoche.

## BR-007 - Asignación por servicio

Una asignación debe corresponder al servicio del empleado o a un servicio permitido
por regla administrativa.

Impacto:
Evita asignaciones incorrectas entre áreas.

## BR-008 - Eliminación lógica

Los registros administrables no deben borrarse físicamente.

Aplica a:

- Usuarios.
- Servicios.
- Personal.
- Turnos.
- Plantillas de turno por servicio.
- Asignaciones.

Impacto:
Conserva historial y permite auditoría.

## BR-009 - Auditoría obligatoria

Toda operación crítica debe registrarse en auditoría desde las primeras fases del
proyecto.

Entidades obligatorias:

- Usuarios.
- Servicios.
- Personal.
- Turnos.
- Plantillas de turno por servicio.
- Asignaciones de turno.

Datos mínimos:

- Usuario responsable.
- Acción realizada.
- Entidad afectada.
- Valores anteriores.
- Valores nuevos.
- IP.
- Fecha y hora.

Impacto:
Permite trazabilidad, defensa técnica y revisión de cambios.

## BR-010 - Consistencia transaccional

Toda operación que afecte más de una entidad debe ejecutarse dentro de una
transacción.

Ejemplos:

- Crear usuario y asociarlo a personal.
- Asignar turno y registrar auditoría.
- Modificar turno y registrar auditoría.
- Eliminar lógicamente personal con registros asociados.
- Aprobar una solicitud de cambio y actualizar asignación.

Impacto:
Garantiza la integridad de la información.

## BR-011 - Solicitudes de cambio de turno

Las solicitudes de cambio de turno pertenecen al dominio del sistema.

Clasificación:
MVP opcional.

Justificación:
Mejoran el flujo operativo, pero el MVP puede demostrar el objetivo principal sin
ellas. Deben implementarse después de asignaciones y calendario si el tiempo lo
permite.

## BR-012 - Ausencias

Las ausencias, permisos o bajas pertenecen al dominio del sistema.

Clasificación:
Post-MVP.

Justificación:
Son importantes para una solución hospitalaria completa, pero requieren reglas
adicionales de reemplazo, aprobación y cobertura que pueden ampliar demasiado el
alcance académico inicial.

## BR-013 - Vacaciones

Las vacaciones del personal pertenecen al dominio del sistema.

Clasificación:
Post-MVP.

Justificación:
Se relacionan con planificación de recursos humanos y disponibilidad del personal.
Deben contemplarse en el diseño de base de datos, pero no son necesarias para el
MVP de gestión de turnos.

## BR-014 - Notificaciones

Las notificaciones pertenecen al dominio del sistema.

Clasificación:

- MVP opcional: notificaciones internas básicas.
- Post-MVP: correo, WhatsApp u otros canales externos.

Justificación:
Avisar cambios mejora la experiencia del usuario, pero la prioridad del MVP es
asignar, validar, auditar y visualizar turnos correctamente.

## BR-015 - Reportes

El MVP debe incluir reportes básicos por servicio, empleado y rango de fechas.

Impacto:
Apoya la toma de decisiones y aporta evidencia para la defensa académica.

## BR-016 - Estados permitidos

Los campos `status` deben usar valores controlados.

Estados permitidos:

- `shift_assignments.status`: `assigned`, `changed`, `cancelled`.
- `shift_change_requests.status`: `pending`, `approved`, `rejected`, `cancelled`.
- `absences.status`: `pending`, `approved`, `rejected`, `cancelled`.
- `vacations.status`: `pending`, `approved`, `rejected`, `cancelled`.

Impacto:
Evita estados ambiguos y facilita validaciones, filtros y reportes.

## BR-017 - Actualización del calendario

El calendario no tendrá actualización automática continua en el MVP.

La actualización será mediante recarga de la vista o nueva consulta al endpoint de
eventos.

Impacto:
Mantiene el alcance técnico realista para proyecto de grado.
