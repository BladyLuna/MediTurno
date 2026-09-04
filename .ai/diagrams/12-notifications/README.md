# Módulo de Notificaciones

## Objetivo

Persistir y mostrar notificaciones internas y su estado de lectura.

## Actores

Administrador, Jefe de Servicio y Personal de Salud como usuarios autenticados
activos. Los servicios internos participan como componentes de soporte, no como
actores del sistema.

## Descripción general

Cada usuario consulta y actualiza únicamente sus notificaciones. Los eventos de
solicitudes generan mensajes internos.

## Casos de uso disponibles

Listar notificaciones propias, marcar una como leída, marcar todas como leídas y
recibir notificaciones del ciclo de solicitudes.

## Reglas de negocio relevantes

- Cada notificación pertenece a un usuario.
- El estado de lectura se representa mediante `read_at`.
- Un usuario no puede actualizar notificaciones ajenas.
- Canales externos permanecen Post-MVP.

## Diagramas incluidos

### Figura 42. Casos de Uso de Notificaciones

- **Descripción:** representa consulta y actualización de lectura.
- **Actores involucrados:** usuarios autenticados activos.
- **Propósito:** delimitar propiedad de mensajes.
- **Archivos:** `01-use-case-mermaid.mmd` y `01-use-case-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 43. Actividad de Notificaciones

- **Descripción:** muestra consulta o marcación de lectura con validación de
  propiedad.
- **Actores involucrados:** usuario autenticado.
- **Propósito:** explicar el flujo de consumo.
- **Archivos:** `02-activity-mermaid.mmd` y
  `02-activity-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 44. Secuencia de Notificaciones

- **Descripción:** presenta interacción entre usuario, controlador, Policy y
  persistencia.
- **Actores involucrados:** usuario autenticado.
- **Propósito:** documentar la protección de propiedad.
- **Archivos:** `03-sequence-mermaid.mmd` y
  `03-sequence-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 45. Estados de Notificación

- **Descripción:** representa notificación no leída y leída.
- **Actores involucrados:** usuario autenticado.
- **Propósito:** explicar el cambio de `read_at`.
- **Archivos:** `04-state-mermaid.mmd` y `04-state-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

## Observaciones

La retención y archivo de notificaciones permanecen pendientes de confirmación.
