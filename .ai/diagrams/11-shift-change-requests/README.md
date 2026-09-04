# Módulo de Solicitudes de Cambio

## Objetivo

Permitir que el personal solicite revisión administrativa de asignaciones y que
actores autorizados aprueben o rechacen.

## Actores

Personal de Salud, Administrador y Jefe de Servicio.

## Descripción general

El personal gestiona solicitudes propias. El Administrador revisa globalmente y
la jefatura revisa solicitudes de servicios administrados.

## Casos de uso disponibles

Listar, crear, consultar y cancelar solicitudes propias; listar, consultar,
aprobar o rechazar solicitudes autorizadas; consultar historial de auditoría.

## Reglas de negocio relevantes

- Estados: `pending`, `approved`, `rejected` y `cancelled`.
- Solo solicitudes pendientes pueden revisarse o cancelarse.
- Crear, revisar y cancelar son operaciones transaccionales y auditadas.
- Las operaciones generan notificaciones internas.
- La modificación automática de la asignación al aprobar permanece en
  conflicto documental.

## Diagramas incluidos

### Figura 38. Casos de Uso de Solicitudes

- **Descripción:** representa solicitud personal y revisión administrativa.
- **Actores involucrados:** Personal de Salud, Administrador y Jefe de Servicio.
- **Propósito:** delimitar propiedad y alcance de revisión.
- **Archivos:** `01-use-case-mermaid.mmd` y `01-use-case-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 39. Actividad de Solicitud y Revisión

- **Descripción:** muestra creación, decisión y notificación.
- **Actores involucrados:** Personal de Salud y revisor autorizado.
- **Propósito:** explicar el flujo administrativo.
- **Archivos:** `02-activity-mermaid.mmd` y
  `02-activity-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 40. Secuencia de Solicitud y Revisión

- **Descripción:** presenta interacción entre actores, servicio, auditoría y
  notificaciones.
- **Actores involucrados:** Personal de Salud, Administrador o Jefe de Servicio.
- **Propósito:** documentar responsabilidades y efectos.
- **Archivos:** `03-sequence-mermaid.mmd` y
  `03-sequence-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 41. Estados de Solicitud

- **Descripción:** representa transiciones desde `pending` hacia aprobación,
  rechazo o cancelación.
- **Actores involucrados:** Personal de Salud y revisor autorizado.
- **Propósito:** explicar el ciclo de vida de la solicitud.
- **Archivos:** `04-state-mermaid.mmd` y `04-state-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

## Observaciones

CONFLICT-004 no debe resolverse desde estos diagramas. README, demo y QA indican
que la aprobación no modifica automáticamente la asignación.

