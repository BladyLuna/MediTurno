# MediTurno - Módulos Funcionales

## Listas

1. 📋 Pendiente
2. 🚧 En desarrollo
3. 🔍 En revisión
4. ✅ Finalizado

## Etiquetas sugeridas

- **Módulo** — azul.
- **En revisión** — amarillo.

## 📋 Pendiente

Sin tarjetas.

## 🚧 En desarrollo

Sin tarjetas.

## 🔍 En revisión

### Autenticación y Dashboard

- **Objetivo del módulo:** permitir el inicio y cierre de sesión y mostrar el
  dashboard correspondiente al usuario autenticado.
- **Actor(es):** Invitado, Administrador, Jefe de Servicio y Personal de Salud.
- **Funcionalidades principales:** formulario de login, autenticación, control
  de cuenta activa, dashboard por rol y logout.
- **Estado del módulo:** En revisión.
- **Checklist resumido:**
  - [x] Implementación
  - [x] Casos de uso
  - [x] Diagramas
  - [x] Documentación
  - [ ] QA

### Usuarios

- **Objetivo del módulo:** administrar cuentas, roles, estado activo y
  eliminación lógica.
- **Actor(es):** Administrador.
- **Funcionalidades principales:** listar, crear, editar, activar, desactivar y
  eliminar lógicamente usuarios.
- **Estado del módulo:** En revisión.
- **Checklist resumido:**
  - [x] Implementación
  - [x] Casos de uso
  - [x] Diagramas
  - [x] Documentación
  - [ ] QA

### Servicios Hospitalarios

- **Objetivo del módulo:** mantener las áreas hospitalarias utilizadas para
  organizar personal, turnos y jefaturas.
- **Actor(es):** Administrador.
- **Funcionalidades principales:** listar, crear, editar, activar, desactivar y
  eliminar lógicamente servicios.
- **Estado del módulo:** En revisión.
- **Checklist resumido:**
  - [x] Implementación
  - [x] Casos de uso
  - [x] Diagramas
  - [x] Documentación
  - [ ] QA

### Personal de Salud

- **Objetivo del módulo:** administrar al personal, su servicio y su asociación
  opcional con una cuenta.
- **Actor(es):** Administrador y Jefe de Servicio.
- **Funcionalidades principales:** CRUD, filtros por nombre, CI y servicio,
  control de estado y consulta restringida por servicio.
- **Estado del módulo:** En revisión.
- **Checklist resumido:**
  - [x] Implementación
  - [x] Casos de uso
  - [x] Diagramas
  - [x] Documentación
  - [ ] QA

### Jefaturas por Servicio

- **Objetivo del módulo:** asociar usuarios de jefatura con uno o varios
  servicios hospitalarios.
- **Actor(es):** Administrador y Jefe de Servicio.
- **Funcionalidades principales:** listar, crear y eliminar asociaciones y
  aplicar el alcance operativo por servicio.
- **Estado del módulo:** En revisión.
- **Checklist resumido:**
  - [x] Implementación
  - [x] Casos de uso
  - [x] Diagramas
  - [x] Documentación
  - [ ] QA

### Plantillas de Turno

- **Objetivo del módulo:** administrar plantillas globales y configuraciones de
  turnos por servicio.
- **Actor(es):** Administrador y Jefe de Servicio.
- **Funcionalidades principales:** CRUD de plantillas, horarios diurnos y
  nocturnos, colores, estados, personalización e herencia por servicio.
- **Estado del módulo:** En revisión.
- **Checklist resumido:**
  - [x] Implementación
  - [x] Casos de uso
  - [x] Diagramas
  - [x] Documentación
  - [ ] QA

### Asignaciones

- **Objetivo del módulo:** asignar turnos al personal sin traslapes y conservar
  trazabilidad.
- **Actor(es):** Administrador y Jefe de Servicio.
- **Funcionalidades principales:** listar, crear, editar, cancelar, consultar
  disponibilidad, calcular intervalos y validar conflictos.
- **Estado del módulo:** En revisión.
- **Checklist resumido:**
  - [x] Implementación
  - [x] Casos de uso
  - [x] Diagramas
  - [x] Documentación
  - [ ] QA

### Calendario

- **Objetivo del módulo:** visualizar las asignaciones mensuales autorizadas
  para cada rol.
- **Actor(es):** Administrador, Jefe de Servicio y Personal de Salud.
- **Funcionalidades principales:** navegación mensual, filtros, eventos,
  colores, turnos nocturnos y detalle de solo lectura.
- **Estado del módulo:** En revisión.
- **Checklist resumido:**
  - [x] Implementación
  - [x] Casos de uso
  - [x] Diagramas
  - [x] Documentación
  - [ ] QA

### Reportes

- **Objetivo del módulo:** presentar resúmenes y detalles de turnos por servicio
  o empleado.
- **Actor(es):** Administrador y Jefe de Servicio.
- **Funcionalidades principales:** filtros por fechas, servicio y personal,
  agrupación, cálculo de horas y exportaciones HTML, CSV y PDF.
- **Estado del módulo:** En revisión.
- **Checklist resumido:**
  - [x] Implementación
  - [x] Casos de uso
  - [x] Diagramas
  - [x] Documentación
  - [ ] QA

### Solicitudes de Cambio

- **Objetivo del módulo:** permitir solicitudes propias y su revisión
  administrativa.
- **Actor(es):** Personal de Salud, Administrador y Jefe de Servicio.
- **Funcionalidades principales:** listar, crear, consultar, cancelar, aprobar y
  rechazar solicitudes.
- **Estado del módulo:** En revisión.
- **Checklist resumido:**
  - [x] Implementación
  - [x] Casos de uso
  - [x] Diagramas
  - [x] Documentación
  - [ ] QA

### Notificaciones

- **Objetivo del módulo:** informar eventos internos y conservar el estado de
  lectura por usuario.
- **Actor(es):** Administrador, Jefe de Servicio y Personal de Salud.
- **Funcionalidades principales:** listar notificaciones propias, marcar una o
  todas como leídas y recibir avisos de solicitudes.
- **Estado del módulo:** En revisión.
- **Checklist resumido:**
  - [x] Implementación
  - [x] Casos de uso
  - [x] Diagramas
  - [x] Documentación
  - [ ] QA

### Auditoría

- **Objetivo del módulo:** conservar y consultar la trazabilidad de operaciones
  críticas.
- **Actor(es):** Administrador como lector; usuarios autorizados generan eventos
  mediante sus operaciones.
- **Funcionalidades principales:** listar eventos, consultar detalle y registrar
  actor, acción, entidad, cambios y metadatos.
- **Estado del módulo:** En revisión.
- **Checklist resumido:**
  - [x] Implementación
  - [x] Casos de uso
  - [x] Diagramas
  - [x] Documentación
  - [ ] QA

## ✅ Finalizado

Sin tarjetas.

