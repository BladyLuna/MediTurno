# 11 - Plan del Tablero Trello de MediTurno

Fecha: **2026-07-03**  
Metodología: **BDS**  
Rol: **System Analyst**  
Modo: **Trello Board Planning**

## Configuración general

**Nombre del tablero:** `MediTurno - Proyecto de Grado`

### Listas

1. Contexto del Proyecto
2. Módulos Implementados
3. Diagramas y Casos de Uso
4. Seguridad de la Información
5. Validación / QA Pendiente
6. Observaciones del Docente
7. Pendiente antes de entrega
8. Completado

### Etiquetas sugeridas

| Etiqueta | Color sugerido | Uso |
|---|---|---|
| Módulo | Azul | Funcionalidad implementada del sistema |
| Diagrama | Morado | Representación Mermaid, PlantUML o Workbench |
| Seguridad | Rojo | Diseño, riesgos, CIA y controles |
| QA | Amarillo | Pruebas y validaciones pendientes |
| Pendiente | Naranja | Trabajo requerido antes de la entrega |
| Entregado | Verde | Artefacto terminado y revisado |
| Riesgo | Negro | Riesgo, contradicción o bloqueo |
| Documento | Celeste | Documentación académica o técnica |

## 1. Contexto del Proyecto

### Tarjeta 1.1 - Resumen de MediTurno

- **Etiquetas:** Documento.
- **Descripción:** sistema web de gestión de turnos hospitalarios desarrollado
  como proyecto de grado. Sustituye la gestión manual mediante hojas de cálculo
  por una aplicación con roles, asignaciones, calendario, reportes, solicitudes,
  notificaciones y auditoría.
- **Estado:** Documentado.
- **Documentos relacionados:** `README.md`, `.ai/PROJECT_CONTEXT.md`,
  `.ai/context/PROJECT_STATE.md`.
- **Checklist:**
  - [x] Objetivo del proyecto.
  - [x] Problema identificado.
  - [x] Alcance implementado.
  - [x] Tecnologías documentadas.
  - [ ] Validación final con el docente.

### Tarjeta 1.2 - Actores y alcance por rol

- **Etiquetas:** Documento, Módulo.
- **Descripción:** actores confirmados: Invitado, Administrador, Jefe de
  Servicio y Personal de Salud. El Administrador posee alcance global; la
  jefatura se limita por `service_managers`; el personal por `staff.user_id`.
- **Estado:** Documentado.
- **Documentos relacionados:** `.ai/diagrams/01-general/README.md`,
  `.ai/analysis/00-project-inventory.md`, DEC-013 y DEC-014.
- **Checklist:**
  - [x] Invitado documentado.
  - [x] Administrador documentado.
  - [x] Jefe de Servicio documentado.
  - [x] Personal de Salud documentado.
  - [ ] Alinear el resumen del rol jefe en README.

### Tarjeta 1.3 - Arquitectura y tecnologías

- **Etiquetas:** Documento.
- **Descripción:** PHP 8.2, Laravel 10, Blade, Bootstrap 5, Vite,
  FullCalendar, MySQL 8 y Docker Compose con Nginx y PHP-FPM.
- **Estado:** Documentado.
- **Documentos relacionados:** `README.md`, `.ai/PROJECT_CONTEXT.md`,
  `.ai/diagrams/01-general/README.md`.
- **Checklist:**
  - [x] Backend documentado.
  - [x] Frontend documentado.
  - [x] Persistencia documentada.
  - [x] Infraestructura local documentada.
  - [ ] Confirmar infraestructura de producción.

### Tarjeta 1.4 - Decisiones oficiales DEC-001 a DEC-015

- **Etiquetas:** Documento, Entregado.
- **Descripción:** registro formal de decisiones sobre roles, traslapes, turnos
  nocturnos, servicios, estados, trazabilidad, alcance por rol y gobierno BDS.
- **Estado:** Documentado.
- **Documentos relacionados:** `docs/decisions.md`,
  `.ai/knowledge-base/decisions.md`.
- **Checklist:**
  - [x] DEC-001 a DEC-012 preservadas.
  - [x] DEC-013 sobre vistas por rol.
  - [x] DEC-014 sobre operación de jefatura.
  - [x] DEC-015 sobre fuente de verdad `.ai/`.
  - [ ] Registrar cualquier nueva decisión antes de cambiar alcance.

## 2. Módulos Implementados

Todas las tarjetas de esta lista usan el estado compuesto:
**Implementado / Documentado / Pendiente QA actual**.

### Tarjeta 2.1 - Autenticación y Dashboard

- **Etiquetas:** Módulo, QA.
- **Objetivo:** proporcionar login, logout y dashboard según rol.
- **Actores:** Invitado, Administrador, Jefe de Servicio y Personal de Salud.
- **Funcionalidades principales:** abrir login, autenticarse, ver dashboard y
  cerrar sesión.
- **Diagramas disponibles:** casos de uso, actividad, secuencia y estados.
- **Documentos relacionados:** `.ai/analysis/modules/authentication-dashboard/`,
  `.ai/diagrams/02-authentication-dashboard/`.
- **Estado:** Implementado / Documentado / Pendiente QA.
- **Checklist:**
  - [x] Análisis funcional.
  - [x] Casos de uso.
  - [x] Diagrama de casos de uso.
  - [x] Diagrama de actividad.
  - [x] Diagrama de secuencia.
  - [x] Reglas de negocio.
  - [x] Permisos.
  - [ ] QA actual: login, cuenta inactiva, roles y logout.

### Tarjeta 2.2 - Usuarios

- **Etiquetas:** Módulo, QA.
- **Objetivo:** administrar cuentas, roles, activación y eliminación lógica.
- **Actores:** Administrador.
- **Funcionalidades principales:** listar, crear, editar, activar/desactivar y
  eliminar lógicamente; proteger al último admin activo.
- **Diagramas disponibles:** casos de uso, actividad, secuencia y estados.
- **Documentos relacionados:** `.ai/analysis/modules/users/`,
  `.ai/diagrams/03-users/`, DEC-001 y DEC-009.
- **Estado:** Implementado / Documentado / Pendiente QA.
- **Checklist:**
  - [x] Análisis funcional.
  - [x] Casos de uso.
  - [x] Diagrama de casos de uso.
  - [x] Diagrama de actividad.
  - [x] Diagrama de secuencia.
  - [x] Reglas de negocio.
  - [x] Permisos.
  - [ ] QA actual: CRUD, estado y protección del último admin.

### Tarjeta 2.3 - Servicios Hospitalarios

- **Etiquetas:** Módulo, QA.
- **Objetivo:** mantener las áreas que delimitan personal, turnos y jefaturas.
- **Actores:** Administrador; consumo indirecto por Jefe de Servicio y Personal.
- **Funcionalidades principales:** listar, crear, editar, activar, desactivar y
  eliminar lógicamente.
- **Diagramas disponibles:** casos de uso, actividad, secuencia y estados.
- **Documentos relacionados:** `.ai/analysis/modules/hospital-services/`,
  `.ai/diagrams/04-hospital-services/`, DEC-005.
- **Estado:** Implementado / Documentado / Pendiente QA.
- **Checklist:**
  - [x] Análisis funcional.
  - [x] Casos de uso.
  - [x] Diagrama de casos de uso.
  - [x] Diagrama de actividad.
  - [x] Diagrama de secuencia.
  - [x] Reglas de negocio.
  - [x] Permisos.
  - [ ] QA actual: unicidad, estados y eliminación lógica.

### Tarjeta 2.4 - Personal de Salud

- **Etiquetas:** Módulo, QA.
- **Objetivo:** mantener personal, servicio y asociación opcional con usuario.
- **Actores:** Administrador y Jefe de Servicio.
- **Funcionalidades principales:** CRUD, filtros, activación y lectura
  restringida por servicio.
- **Diagramas disponibles:** casos de uso, actividad, secuencia y estados.
- **Documentos relacionados:** `.ai/analysis/modules/staff/`,
  `.ai/diagrams/05-staff/`, DEC-010 y DEC-013.
- **Estado:** Implementado / Documentado / Pendiente QA.
- **Checklist:**
  - [x] Análisis funcional.
  - [x] Casos de uso.
  - [x] Diagrama de casos de uso.
  - [x] Diagrama de actividad.
  - [x] Diagrama de secuencia.
  - [x] Reglas de negocio.
  - [x] Permisos.
  - [ ] QA actual: filtros, rol `personal` y alcance de jefatura.

### Tarjeta 2.5 - Jefaturas por Servicio

- **Etiquetas:** Módulo, QA.
- **Objetivo:** asociar jefaturas con uno o varios servicios.
- **Actores:** Administrador y Jefe de Servicio.
- **Funcionalidades principales:** listar, crear y eliminar asociaciones;
  proporcionar alcance operativo.
- **Diagramas disponibles:** casos de uso, actividad, secuencia y estados.
- **Documentos relacionados:** `.ai/analysis/modules/service-managers/`,
  `.ai/diagrams/06-service-managers/`, DEC-006.
- **Estado:** Implementado / Documentado / Pendiente QA.
- **Checklist:**
  - [x] Análisis funcional.
  - [x] Casos de uso.
  - [x] Diagrama de casos de uso.
  - [x] Diagrama de actividad.
  - [x] Diagrama de secuencia.
  - [x] Reglas de negocio.
  - [x] Permisos.
  - [ ] QA actual: múltiples servicios y pares no duplicados.

### Tarjeta 2.6 - Plantillas de Turno

- **Etiquetas:** Módulo, QA.
- **Objetivo:** mantener plantillas globales y configuraciones por servicio.
- **Actores:** Administrador; Jefe de Servicio como consumidor.
- **Funcionalidades principales:** CRUD, estados, horarios nocturnos,
  personalización e herencia.
- **Diagramas disponibles:** casos de uso, actividad, secuencia y estados.
- **Documentos relacionados:** `.ai/analysis/modules/shift-templates/`,
  `.ai/diagrams/07-shift-templates/`, DEC-011.
- **Estado:** Implementado / Documentado / Pendiente QA.
- **Checklist:**
  - [x] Análisis funcional.
  - [x] Casos de uso.
  - [x] Diagrama de casos de uso.
  - [x] Diagrama de actividad.
  - [x] Diagrama de secuencia.
  - [x] Reglas de negocio.
  - [x] Permisos.
  - [ ] QA actual: nocturnos, herencia y horas personalizadas.

### Tarjeta 2.7 - Asignaciones de Turno

- **Etiquetas:** Módulo, QA, Riesgo.
- **Objetivo:** asignar turnos al personal sin traslapes y con trazabilidad.
- **Actores:** Administrador y Jefe de Servicio.
- **Funcionalidades principales:** listar, crear, editar, cancelar, consultar
  disponibilidad, calcular intervalos y validar conflictos.
- **Diagramas disponibles:** casos de uso, actividad, secuencia y estados.
- **Documentos relacionados:** `.ai/analysis/modules/shift-assignments/`,
  `.ai/diagrams/08-shift-assignments/`, DEC-003, DEC-004, DEC-012 y DEC-014.
- **Estado:** Implementado / Documentado / Pendiente QA.
- **Checklist:**
  - [x] Análisis funcional.
  - [x] Casos de uso.
  - [x] Diagrama de casos de uso.
  - [x] Diagrama de actividad.
  - [x] Diagrama de secuencia.
  - [x] Reglas de negocio.
  - [x] Permisos.
  - [ ] QA actual: traslapes, consecutivos, nocturnos y seguridad de alcance.

### Tarjeta 2.8 - Calendario

- **Etiquetas:** Módulo, QA.
- **Objetivo:** visualizar asignaciones mensuales según rol y alcance.
- **Actores:** Administrador, Jefe de Servicio y Personal de Salud.
- **Funcionalidades principales:** navegación mensual, filtros, endpoint de
  eventos y detalle de solo lectura.
- **Diagramas disponibles:** casos de uso, actividad y secuencia; estados no
  aplican.
- **Documentos relacionados:** `.ai/analysis/modules/calendar/`,
  `.ai/diagrams/09-calendar/`, DEC-007 y DEC-013.
- **Estado:** Implementado / Documentado / Pendiente QA.
- **Checklist:**
  - [x] Análisis funcional.
  - [x] Casos de uso.
  - [x] Diagrama de casos de uso.
  - [x] Diagrama de actividad.
  - [x] Diagrama de secuencia.
  - [x] Reglas de negocio.
  - [x] Permisos.
  - [ ] QA actual: filtros, colores, nocturnos y aislamiento por rol.

### Tarjeta 2.9 - Reportes y Exportaciones

- **Etiquetas:** Módulo, QA.
- **Objetivo:** presentar resúmenes y detalles por servicio o empleado.
- **Actores:** Administrador y Jefe de Servicio.
- **Funcionalidades principales:** filtros, agrupación, cálculo de horas y
  exportaciones HTML, CSV y PDF.
- **Diagramas disponibles:** casos de uso, actividad y secuencia; estados no
  aplican.
- **Documentos relacionados:** `.ai/analysis/modules/reports/`,
  `.ai/diagrams/10-reports/`.
- **Estado:** Implementado / Documentado / Pendiente QA.
- **Checklist:**
  - [x] Análisis funcional.
  - [x] Casos de uso.
  - [x] Diagrama de casos de uso.
  - [x] Diagrama de actividad.
  - [x] Diagrama de secuencia.
  - [x] Reglas de negocio.
  - [x] Permisos.
  - [ ] QA actual: rango real, horas, CSV/PDF y alcance de jefatura.

### Tarjeta 2.10 - Solicitudes de Cambio

- **Etiquetas:** Módulo, QA, Riesgo.
- **Objetivo:** gestionar solicitudes propias y revisión administrativa.
- **Actores:** Personal de Salud, Administrador y Jefe de Servicio.
- **Funcionalidades principales:** listar, crear, consultar, cancelar, aprobar,
  rechazar, notificar y auditar.
- **Diagramas disponibles:** casos de uso, actividad, secuencia y estados.
- **Documentos relacionados:** `.ai/analysis/modules/shift-change-requests/`,
  `.ai/diagrams/11-shift-change-requests/`, DEC-008.
- **Estado:** Implementado / Documentado / Pendiente QA.
- **Checklist:**
  - [x] Análisis funcional.
  - [x] Casos de uso.
  - [x] Diagrama de casos de uso.
  - [x] Diagrama de actividad.
  - [x] Diagrama de secuencia.
  - [x] Reglas de negocio.
  - [x] Permisos.
  - [ ] QA actual y resolución de CONFLICT-004.

### Tarjeta 2.11 - Notificaciones Internas

- **Etiquetas:** Módulo, QA.
- **Objetivo:** informar eventos y mantener estado de lectura por usuario.
- **Actores:** Administrador, Jefe de Servicio y Personal de Salud.
- **Funcionalidades principales:** listar propias, marcar una/todas como leídas
  y recibir eventos de solicitudes.
- **Diagramas disponibles:** casos de uso, actividad, secuencia y estados.
- **Documentos relacionados:** `.ai/analysis/modules/notifications/`,
  `.ai/diagrams/12-notifications/`.
- **Estado:** Implementado / Documentado / Pendiente QA.
- **Checklist:**
  - [x] Análisis funcional.
  - [x] Casos de uso.
  - [x] Diagrama de casos de uso.
  - [x] Diagrama de actividad.
  - [x] Diagrama de secuencia.
  - [x] Reglas de negocio.
  - [x] Permisos.
  - [ ] QA actual: propiedad, lectura y notificaciones de solicitudes.

### Tarjeta 2.12 - Auditoría

- **Etiquetas:** Módulo, QA, Seguridad.
- **Objetivo:** preservar trazabilidad de operaciones críticas.
- **Actores:** Administrador como lector; actores autorizados generan eventos
  indirectamente.
- **Funcionalidades principales:** listar, consultar detalle y registrar actor,
  acción, entidad, cambios y metadatos.
- **Diagramas disponibles:** casos de uso, actividad y secuencia; estados no
  aplican.
- **Documentos relacionados:** `.ai/analysis/modules/audit/`,
  `.ai/diagrams/13-audit/`.
- **Estado:** Implementado / Documentado / Pendiente QA.
- **Checklist:**
  - [x] Análisis funcional.
  - [x] Casos de uso.
  - [x] Diagrama de casos de uso.
  - [x] Diagrama de actividad.
  - [x] Diagrama de secuencia.
  - [x] Reglas de negocio.
  - [x] Permisos.
  - [ ] QA actual: cobertura de operaciones críticas y acceso solo admin.

## 3. Diagramas y Casos de Uso

### Tarjeta 3.1 - Diagrama general de casos de uso

- **Etiquetas:** Diagrama, Documento, Entregado.
- **Descripción:** representa los cuatro actores y los principales casos de uso
  del sistema.
- **Estado:** Documentado.
- **Archivos:** `.ai/diagrams/01-general/01-general-use-case-mermaid.mmd`,
  `.ai/diagrams/01-general/01-general-use-case-plantuml.puml`.
- **Checklist:**
  - [x] Mermaid.
  - [x] PlantUML.
  - [x] Descripción académica.
  - [x] Actores.
  - [x] Fuente: Elaboración propia (2026).
  - [ ] Exportar imagen legible para el documento final.

### Tarjeta 3.2 - Diagrama general de clases

- **Etiquetas:** Diagrama, Documento, Entregado.
- **Descripción:** representa las clases del dominio, relaciones y dependencias
  de servicios.
- **Estado:** Documentado.
- **Archivos:** `.ai/diagrams/01-general/02-domain-class-mermaid.mmd`,
  `.ai/diagrams/01-general/02-domain-class-plantuml.puml`.
- **Checklist:**
  - [x] Mermaid.
  - [x] PlantUML.
  - [x] Diferenciado del ERD físico.
  - [x] Descripción académica.
  - [ ] Exportar imagen legible para el documento final.

### Tarjeta 3.3 - Diagramas y 57 casos de uso por módulo

- **Etiquetas:** Diagrama, Documento, Entregado.
- **Descripción:** paquete con 12 módulos, 48 figuras lógicas, 96 fuentes y 57
  casos de uso documentados individualmente.
- **Estado:** Documentado.
- **Documentos relacionados:** `.ai/diagrams/README.md`,
  `.ai/reports/10-academic-diagram-documentation.md`.
- **Checklist:**
  - [x] 12 diagramas de casos de uso.
  - [x] 12 diagramas de actividad.
  - [x] 12 diagramas de secuencia.
  - [x] 9 diagramas de estados.
  - [x] 57 casos documentados.
  - [ ] Renderizar e insertar figuras seleccionadas en la memoria.

## 4. Seguridad de la Información

### Tarjeta 4.1 - Documento de seguridad

- **Etiquetas:** Seguridad, Documento, Entregado.
- **Descripción:** diseño de seguridad de la información con descripción,
  activos, riesgos, CIA, controles y conclusiones.
- **Estado:** Documentado; cobertura académica estimada del 96 %.
- **Archivo:** `docs/security/01-information-security-design.md`.
- **Checklist:**
  - [x] Descripción del proyecto.
  - [x] Activos de información.
  - [x] Análisis de riesgos.
  - [x] Tríada CIA.
  - [x] Controles.
  - [x] Conclusiones y anexos.
  - [ ] Validación final con el docente.

### Tarjeta 4.2 - Matriz de riesgos

- **Etiquetas:** Seguridad, Riesgo, Documento.
- **Descripción:** matriz cualitativa de activos, amenazas, impacto,
  probabilidad y nivel de riesgo.
- **Estado:** Documentado.
- **Archivo:** `docs/security/02-risk-matrix.md`.
- **Checklist:**
  - [x] Activos identificados.
  - [x] Amenazas relacionadas.
  - [x] Impacto.
  - [x] Probabilidad.
  - [x] Nivel de riesgo.
  - [ ] Validar escala cualitativa con el docente.

### Tarjeta 4.3 - Tríada CIA

- **Etiquetas:** Seguridad, Documento.
- **Descripción:** evaluación de confidencialidad, integridad y disponibilidad
  con controles confirmados y vacíos pendientes.
- **Estado:** Documentado.
- **Archivo:** `docs/security/03-cia-analysis.md`.
- **Checklist:**
  - [x] Confidencialidad.
  - [x] Integridad.
  - [x] Disponibilidad.
  - [x] Balance CIA.
  - [ ] Confirmar controles operativos de producción.

### Tarjeta 4.4 - Controles de seguridad

- **Etiquetas:** Seguridad, Riesgo, Pendiente.
- **Descripción:** controles implementados, parciales y no confirmados.
- **Estado:** Documentado con mejoras pendientes.
- **Archivo:** `docs/security/04-security-controls.md`.
- **Checklist:**
  - [x] Controles existentes.
  - [x] Controles recomendados.
  - [x] Estado por control.
  - [ ] Rate limiting confirmado.
  - [ ] MFA.
  - [ ] Backup y restauración.
  - [ ] Monitoreo y respuesta a incidentes.

## 5. Validación / QA Pendiente

### Tarjeta 5.1 - Pendiente QA general

- **Etiquetas:** QA, Pendiente.
- **Descripción:** ejecutar una validación actual de las funcionalidades
  declaradas y preservar el resultado como evidencia nueva.
- **Estado:** Pendiente.
- **Documentos relacionados:** `docs/qa-checklist.md`,
  `.ai/knowledge-base/knowledge-gaps.md` GAP-012.
- **Checklist:**
  - [ ] Levantar Docker.
  - [ ] Ejecutar migraciones y datos demo.
  - [ ] Ejecutar pruebas automatizadas.
  - [ ] Ejecutar build frontend.
  - [ ] Recorrer checklist por rol.
  - [ ] Registrar fecha y resultado.

### Tarjeta 5.2 - QA de permisos por rol

- **Etiquetas:** QA, Seguridad, Pendiente.
- **Descripción:** confirmar aislamiento entre Administrador, Jefe de Servicio y
  Personal de Salud.
- **Estado:** Pendiente.
- **Checklist:**
  - [ ] Jefe no accede a servicios ajenos.
  - [ ] Jefe no accede a CRUD global.
  - [ ] Personal no consulta turnos ajenos.
  - [ ] Notificaciones respetan propiedad.
  - [ ] Auditoría global es solo para admin.

### Tarjeta 5.3 - Auditoría actual de dependencias

- **Etiquetas:** QA, Riesgo, Pendiente.
- **Descripción:** verificar la vigencia de los advisories documentados para
  Laravel y Vite/esbuild.
- **Estado:** Pendiente.
- **Checklist:**
  - [ ] Ejecutar `composer audit`.
  - [ ] Ejecutar `npm audit`.
  - [ ] Registrar resultados con fecha.
  - [ ] Evaluar actualizaciones dirigidas.
  - [ ] Ejecutar pruebas después de cualquier actualización.

## 6. Observaciones del Docente

### Tarjeta 6.1 - CONFLICT-003: alcance del Jefe de Servicio

- **Etiquetas:** Riesgo, Pendiente, Documento.
- **Descripción:** README limita al jefe principalmente a revisión de
  solicitudes, mientras DEC-013/014 documentan calendario, reportes y operación
  de asignaciones.
- **Estado:** Pendiente de confirmación.
- **Documentos relacionados:** `.ai/knowledge-base/problems.md`,
  `docs/decisions.md`.
- **Checklist:**
  - [ ] Confirmar alcance oficial con el docente.
  - [ ] Registrar decisión si corresponde.
  - [ ] Alinear README.
  - [ ] Alinear flujo demo y QA.

### Tarjeta 6.2 - CONFLICT-004: aprobación de solicitudes

- **Etiquetas:** Riesgo, Pendiente, Documento.
- **Descripción:** una regla heredada plantea actualizar la asignación al
  aprobar, pero README, demo y QA indican que la aprobación es administrativa y
  no modifica automáticamente asignaciones.
- **Estado:** Pendiente de confirmación.
- **Documentos relacionados:** `.ai/knowledge-base/problems.md`,
  `.ai/analysis/modules/shift-change-requests/11-pending.md`.
- **Checklist:**
  - [ ] Confirmar comportamiento oficial.
  - [ ] Registrar decisión formal.
  - [ ] Alinear reglas de negocio.
  - [ ] Alinear documentación académica.

## 7. Pendiente antes de entrega

### Tarjeta 7.1 - ERD desde MySQL Workbench

- **Etiquetas:** Diagrama, Pendiente, Documento.
- **Descripción:** generar el diagrama EER mediante ingeniería inversa del
  esquema MySQL real. El ERD Mermaid/PlantUML actual solo cumple parcialmente la
  consigna.
- **Estado:** Pendiente crítico.
- **Documento relacionado:**
  `.ai/reports/09-database-diagram-verification.md`.
- **Checklist:**
  - [ ] Levantar la base de datos actual.
  - [ ] Conectar MySQL Workbench.
  - [ ] Ejecutar `Database > Reverse Engineer`.
  - [ ] Ordenar tablas y relaciones.
  - [ ] Guardar archivo `.mwb`.
  - [ ] Exportar PNG o PDF legible.
  - [ ] Comparar con el ERD de apoyo.

### Tarjeta 7.2 - Alinear documentación con Versiones 2 y 3

- **Etiquetas:** Documento, Pendiente.
- **Descripción:** incorporar el alcance de DEC-013/014 en README, roadmap,
  backlog, QA y flujo demo cuando exista autorización.
- **Estado:** Pendiente.
- **Checklist:**
  - [ ] Actualizar descripción de jefatura.
  - [ ] Incorporar Sprints 11 y 12 al roadmap.
  - [ ] Incorporar Sprints 11 y 12 al backlog.
  - [ ] Ampliar QA de jefatura.
  - [ ] Ampliar flujo de defensa.

### Tarjeta 7.3 - Renderizar figuras académicas

- **Etiquetas:** Diagrama, Pendiente.
- **Descripción:** exportar las figuras seleccionadas a imágenes legibles para
  insertarlas en la memoria del proyecto.
- **Estado:** Pendiente.
- **Checklist:**
  - [ ] Seleccionar figuras obligatorias.
  - [ ] Renderizar Mermaid/PlantUML.
  - [ ] Verificar legibilidad A4.
  - [ ] Conservar número, nombre y fuente.
  - [ ] Insertar referencias cruzadas en el documento final.

### Tarjeta 7.4 - Evidencia mínima de seguridad operativa

- **Etiquetas:** Seguridad, Pendiente, Riesgo.
- **Descripción:** completar evidencia básica antes de presentar el sistema como
  preparado para producción.
- **Estado:** Pendiente.
- **Checklist:**
  - [ ] Confirmar HTTPS y `APP_DEBUG=false`.
  - [ ] Confirmar configuración segura de secretos.
  - [ ] Documentar backup y restauración.
  - [ ] Confirmar rate limiting.
  - [ ] Definir retención de auditoría.

## 8. Completado

### Tarjeta 8.1 - Knowledge Base BDS

- **Etiquetas:** Documento, Entregado.
- **Descripción:** fuentes, decisiones, funcionalidades, problemas,
  contradicciones, vacíos y evidencia preservados.
- **Estado:** Completado.
- **Ubicación:** `.ai/knowledge-base/`.
- **Checklist:**
  - [x] Fuentes.
  - [x] Decisiones.
  - [x] Funcionalidades.
  - [x] Contradicciones.
  - [x] Vacíos.
  - [x] Evidencia.

### Tarjeta 8.2 - Análisis funcional de 12 módulos

- **Etiquetas:** Documento, Entregado, Módulo.
- **Descripción:** análisis por módulo con actores, casos, reglas, permisos,
  rutas, controladores, modelos, datos, flujos y pendientes.
- **Estado:** Completado.
- **Ubicación:** `.ai/analysis/modules/`.
- **Checklist:**
  - [x] 12 resúmenes.
  - [x] Actores.
  - [x] Casos de uso.
  - [x] Reglas.
  - [x] Permisos.
  - [x] Flujos.

### Tarjeta 8.3 - Paquete académico de diagramas

- **Etiquetas:** Diagrama, Documento, Entregado.
- **Descripción:** estructura numerada con 48 figuras y 57 casos de uso
  documentados.
- **Estado:** Completado.
- **Ubicación:** `.ai/diagrams/`.
- **Checklist:**
  - [x] Índice general.
  - [x] 12 módulos.
  - [x] Mermaid.
  - [x] PlantUML.
  - [x] Especificaciones de casos.
  - [x] Reporte de entrega.

### Tarjeta 8.4 - Paquete de transferencia de contexto

- **Etiquetas:** Documento, Entregado.
- **Descripción:** contexto portable para continuar el proyecto sin leer el
  historial completo.
- **Estado:** Completado.
- **Ubicación:** `.ai/context/`.
- **Checklist:**
  - [x] README.
  - [x] Estado del proyecto.
  - [x] Próxima sesión.
  - [x] Context Transfer.

## Resumen cuantitativo

| Lista | Tarjetas |
|---|---:|
| Contexto del Proyecto | 4 |
| Módulos Implementados | 12 |
| Diagramas y Casos de Uso | 3 |
| Seguridad de la Información | 4 |
| Validación / QA Pendiente | 3 |
| Observaciones del Docente | 2 |
| Pendiente antes de entrega | 4 |
| Completado | 4 |
| **Total** | **36** |

## Cómo copiar esto a Trello

1. Crear un tablero nuevo llamado **MediTurno - Proyecto de Grado**.
2. Crear las ocho listas en el orden indicado al inicio de este documento.
3. Crear las ocho etiquetas sugeridas y asignar sus colores.
4. Copiar cada encabezado `Tarjeta X.X` como título de una tarjeta.
5. Copiar sus campos de objetivo, actores, funcionalidades, diagramas,
   documentos y estado dentro de la descripción.
6. Crear un checklist en Trello con los elementos marcados en cada tarjeta.
7. Marcar como completados los elementos `[x]` y dejar abiertos los elementos
   `[ ]`.
8. Asignar las etiquetas indicadas.
9. Añadir fechas límite primero a las tarjetas de la lista
   **Pendiente antes de entrega**.
10. Mover una tarjeta a **Completado** solo cuando exista evidencia verificable.

## Pendientes críticos para presentar al docente

1. Generar el ERD oficial desde MySQL Workbench.
2. Ejecutar y registrar QA actual por rol y módulo.
3. Resolver CONFLICT-003 sobre alcance de jefatura.
4. Resolver CONFLICT-004 sobre aprobación de solicitudes.
5. Verificar advisories actuales de Composer y npm.
6. Renderizar las figuras que se incluirán en la memoria.
7. Alinear README, roadmap, backlog, QA y demo con DEC-013/014.

