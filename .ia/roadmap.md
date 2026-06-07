# Roadmap MediTurno

## Enfoque

El proyecto mantiene un alcance realista para proyecto de grado:

- Primero se construye un MVP funcional y demostrable.
- Las funcionalidades complejas se conservan dentro del dominio, pero se
  clasifican como obligatorias, opcionales o post-MVP.
- La auditoría se implementa desde las primeras operaciones críticas, no al final.

## Clasificación de Funcionalidades del Dominio

### MVP obligatorio

- Autenticación y roles.
- Usuarios.
- Servicios hospitalarios.
- Personal de salud.
- Tipos y plantillas de turno por servicio.
- Asignación de turnos.
- Validación de conflictos.
- Calendario mensual.
- Reportes básicos.
- Auditoría mínima de operaciones críticas.

Justificación:
Estas funcionalidades permiten demostrar el objetivo central del sistema:
reemplazar el Excel, asignar turnos, controlar errores y visualizar el rol mensual.

### MVP opcional

- `shift_change_requests`: solicitudes de cambio de turno.
- `notifications`: notificaciones internas básicas.
- Exportación avanzada en PDF y Excel.

Justificación:
Son funcionalidades valiosas para el usuario final, pero no son indispensables para
probar la gestión principal de turnos. Pueden incorporarse si el tiempo del proyecto
lo permite después de completar asignaciones, calendario y auditoría.

### Post-MVP

- `absences`: ausencias, permisos o bajas.
- `vacations`: vacaciones del personal.
- Notificaciones externas por correo, WhatsApp u otros canales.
- Estadísticas avanzadas de equidad, carga horaria y cobertura.

Justificación:
Estas funcionalidades amplían el sistema hacia gestión de recursos humanos. Deben
mantenerse en el modelo conceptual, pero implementarlas en el MVP puede aumentar
demasiado el alcance para un proyecto de grado.

## Sprints Recomendados

### Sprint 1 - Base del sistema

- Login.
- Logout.
- Roles.
- Dashboard inicial.
- Middleware, Gates o Policies.
- Estructura visual base.

Resultado esperado:
Sistema con acceso controlado por rol.

### Sprint 2 - Usuarios y auditoría inicial

- CRUD de usuarios.
- Activación y desactivación de usuarios.
- Validaciones backend.
- Inicio de auditoría mínima.

Resultado esperado:
Administración segura de usuarios y primeras trazas de cambios críticos.

### Sprint 3 - Servicios hospitalarios

- CRUD de servicios.
- Asignación de jefe de servicio.
- Restricción de acceso por servicio.
- Auditoría de servicios.

Resultado esperado:
Servicios administrables y base para filtrar personal y turnos.

### Sprint 4 - Personal de salud

- CRUD de personal.
- Asociación con servicio.
- Asociación opcional con usuario.
- Auditoría de personal.

Resultado esperado:
Personal registrado y organizado por servicio.

### Sprint 5 - Tipos y plantillas de turno

- CRUD de tipos de turno.
- Configuración de turnos por servicio.
- Colores del calendario.
- Validaciones de horarios.

Resultado esperado:
Turnos configurables por servicio sin crear un sistema excesivamente libre.

### Sprint 6 - Asignaciones y auditoría obligatoria

- Crear asignaciones.
- Editar asignaciones.
- Eliminar lógicamente asignaciones.
- Validar conflictos por fecha y horario.
- Registrar auditoría obligatoria de cada cambio.

Resultado esperado:
Núcleo funcional del sistema con trazabilidad.

### Sprint 7 - Calendario mensual

- Vista mensual con FullCalendar.
- Filtros por servicio y personal.
- Eventos JSON.
- Colores por tipo de turno.
- Vista según rol.

Resultado esperado:
Visualización clara del rol mensual.

### Sprint 8 - Reportes básicos

- Reporte por servicio.
- Reporte por empleado.
- Filtro por rango de fechas.
- Exportación básica si el tiempo lo permite.

Resultado esperado:
Información útil para administración y defensa académica.

### Sprint 9 - Funcionalidades opcionales del MVP

- Solicitudes de cambio de turno.
- Notificaciones internas básicas.
- Historial de solicitudes.

Resultado esperado:
Mejora operativa sin comprometer el MVP principal.

### Sprint 10 - Cierre, pruebas y despliegue

- Pruebas funcionales.
- Revisión de permisos.
- Revisión de auditoría.
- Documentación final.
- Deploy y landing page.

Resultado esperado:
Sistema listo para presentación, con documentación técnica y académica.
