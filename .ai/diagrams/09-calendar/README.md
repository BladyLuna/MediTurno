# Módulo de Calendario

## Objetivo

Visualizar mensualmente asignaciones existentes según el alcance del usuario.

## Actores

Administrador, Jefe de Servicio y Personal de Salud.

## Descripción general

El Administrador consulta el calendario global, la jefatura solo sus servicios y
el personal únicamente sus asignaciones. El módulo es de solo lectura.

## Casos de uso disponibles

Abrir mes, navegar, filtrar, solicitar eventos JSON y consultar detalle.

## Reglas de negocio relevantes

- Incluye `assigned` y `changed`.
- Excluye `cancelled` y registros eliminados.
- Usa `start_at` y `end_at` reales.
- Colores y nombres heredan configuración específica o global.
- Se actualiza por recarga o consulta, sin WebSockets.

## Diagramas incluidos

### Figura 32. Casos de Uso del Calendario

- **Descripción:** representa consulta global, por servicio y personal.
- **Actores involucrados:** Administrador, Jefe de Servicio y Personal de Salud.
- **Propósito:** explicar los niveles de visibilidad.
- **Archivos:** `01-use-case-mermaid.mmd` y `01-use-case-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 33. Actividad de Consulta del Calendario

- **Descripción:** muestra filtros de alcance, consulta y presentación de
  eventos.
- **Actores involucrados:** Administrador, Jefe de Servicio o Personal de Salud.
- **Propósito:** documentar el flujo de lectura.
- **Archivos:** `02-activity-mermaid.mmd` y
  `02-activity-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 34. Secuencia de Consulta del Calendario

- **Descripción:** presenta la solicitud de eventos y la respuesta filtrada.
- **Actores involucrados:** Administrador, Jefe de Servicio o Personal de Salud.
- **Propósito:** explicar la interacción del endpoint de calendario.
- **Archivos:** `03-sequence-mermaid.mmd` y
  `03-sequence-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

## Observaciones

No se incluye diagrama de estados porque el calendario no posee ciclo de vida
propio; representa asignaciones de solo lectura cuyos estados pertenecen al
módulo de asignaciones.

