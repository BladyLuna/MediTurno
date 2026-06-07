# Backlog MediTurno

## Criterio de Alcance

El backlog se organiza para un proyecto de grado con MVP realista:

- El MVP obligatorio demuestra la gestión central de turnos.
- El MVP opcional agrega valor si queda tiempo.
- El Post-MVP conserva funcionalidades del dominio sin comprometer la entrega.

## MVP obligatorio

### Autenticación y roles

- Como usuario, quiero iniciar sesión para acceder al sistema.
- Como usuario, quiero cerrar sesión para proteger mi cuenta.
- Como sistema, quiero redirigir según rol para mostrar solo opciones permitidas.

Justificación:
Es la base de seguridad del sistema.

### Usuarios

- Como administrador, quiero crear usuarios.
- Como administrador, quiero editar usuarios.
- Como administrador, quiero activar o desactivar usuarios.
- Como administrador, quiero asignar rol a cada usuario.

Justificación:
Permite controlar quién accede al sistema.

### Servicios hospitalarios

- Como administrador, quiero registrar servicios.
- Como administrador, quiero editar servicios.
- Como administrador, quiero asignar jefe de servicio.

Justificación:
Los turnos se organizan por área hospitalaria.

### Personal de salud

- Como administrador, quiero registrar personal.
- Como administrador, quiero asignar personal a un servicio.
- Como jefe de servicio, quiero ver el personal de mi servicio.

Justificación:
El personal es la entidad principal sobre la que se asignan turnos.

### Turnos y plantillas por servicio

- Como administrador, quiero crear tipos de turno.
- Como administrador, quiero definir horarios y colores.
- Como administrador, quiero configurar qué turnos usa cada servicio.

Justificación:
Permite adaptar el sistema a servicios con horarios distintos sin perder control.

### Asignación de turnos

- Como administrador o jefe de servicio, quiero asignar turnos por fecha.
- Como administrador o jefe de servicio, quiero modificar asignaciones.
- Como administrador o jefe de servicio, quiero eliminar lógicamente asignaciones.
- Como sistema, quiero validar conflictos de horario.

Justificación:
Es el núcleo funcional del proyecto.

### Calendario

- Como usuario autorizado, quiero ver los turnos en calendario mensual.
- Como jefe de servicio, quiero filtrar por mi servicio.
- Como personal de salud, quiero ver mis propios turnos.

Justificación:
Reemplaza visualmente el Excel y mejora la consulta de información.

### Reportes básicos

- Como administrador, quiero generar reportes por servicio.
- Como administrador, quiero generar reportes por empleado.
- Como administrador, quiero filtrar por rango de fechas.

Justificación:
Permite demostrar utilidad administrativa.

### Auditoría mínima

- Como sistema, quiero registrar cambios críticos.
- Como administrador, quiero consultar trazabilidad básica.

Justificación:
Protege integridad, trazabilidad y defensa técnica del sistema.

## MVP opcional

### Solicitudes de cambio de turno

- Como personal de salud, quiero solicitar un cambio de turno.
- Como jefe de servicio, quiero aprobar o rechazar solicitudes.
- Como sistema, quiero registrar el historial de la solicitud.

Justificación:
Es parte natural del dominio, pero depende de que asignaciones y calendario estén
terminados.

### Notificaciones internas

- Como usuario, quiero ver avisos internos cuando cambie un turno.
- Como sistema, quiero registrar si una notificación fue leída.

Justificación:
Mejora la comunicación, pero puede funcionar de manera simple dentro del sistema.

### Exportación avanzada

- Como administrador, quiero exportar reportes a PDF.
- Como administrador, quiero exportar reportes a Excel.

Justificación:
Es útil para administración, pero puede simplificarse si el tiempo es limitado.

## Post-MVP

### Ausencias

- Como jefe de servicio, quiero registrar ausencias.
- Como sistema, quiero impedir asignaciones durante una ausencia.

Justificación:
Requiere reglas adicionales de cobertura y reemplazo.

### Vacaciones

- Como administrador, quiero registrar vacaciones del personal.
- Como sistema, quiero considerar vacaciones al asignar turnos.

Justificación:
Pertenece a gestión de recursos humanos y amplía el alcance inicial.

### Notificaciones externas

- Como usuario, quiero recibir avisos por correo o canal externo.

Justificación:
Depende de servicios externos y configuración adicional.

### Estadísticas avanzadas

- Como administrador, quiero ver carga horaria, noches asignadas y distribución
  equitativa.

Justificación:
Es valioso, pero requiere reglas laborales claras que deben validarse con usuarios.

## Funcionalidades críticas adelantadas

Las siguientes funcionalidades deben adelantarse por trazabilidad, seguridad o
integridad de datos:

- Auditoría desde Sprint 2.
- Policies o Gates desde Sprint 1.
- Validaciones backend desde el primer CRUD.
- SoftDeletes desde las primeras migraciones.
- Transacciones desde operaciones que escriban más de una entidad.
- Validación de conflictos desde el primer desarrollo de asignaciones.
- Restricción por servicio desde que se implemente jefe de servicio.

## Deuda técnica para Sprint 10

### Revisión de dependencias Composer

- Revisar advisory de Composer.
- Ejecutar `composer audit`.
- Evaluar actualización segura de dependencias.
- No aplicar `composer update` masivo sin revisar impacto.
- Verificar que `php artisan test` siga pasando después de cualquier actualización.

Justificación:
La revisión de dependencias debe hacerse en fase de cierre para reducir riesgos de
seguridad sin introducir cambios masivos no controlados antes de estabilizar el MVP.
