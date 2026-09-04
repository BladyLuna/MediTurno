# Módulo de Plantillas de Turno

## Objetivo

Mantener plantillas globales y configuraciones específicas por servicio.

## Actores

Administrador y Jefe de Servicio como consumidor de plantillas activas.

## Descripción general

El Administrador define códigos, nombres, horarios y colores globales, y configura
sus posibles personalizaciones por servicio.

## Casos de uso disponibles

Gestionar plantillas globales; activar o desactivar; configurar y personalizar
turnos por servicio.

## Reglas de negocio relevantes

- Las tablas oficiales son `shift_templates` y `service_shift_templates`.
- Código y nombre son únicos entre registros no eliminados.
- Horas personalizadas deben definirse juntas.
- Un inicio posterior al fin representa turno nocturno.
- Valores personalizados vacíos heredan la plantilla global.

## Diagramas incluidos

### Figura 24. Casos de Uso de Plantillas

- **Descripción:** representa gestión global y configuración por servicio.
- **Actores involucrados:** Administrador y Jefe de Servicio como consumidor.
- **Propósito:** delimitar configuración y uso.
- **Archivos:** `01-use-case-mermaid.mmd` y `01-use-case-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 25. Actividad de Configuración

- **Descripción:** muestra validación de horarios y persistencia.
- **Actores involucrados:** Administrador.
- **Propósito:** explicar la configuración de turnos.
- **Archivos:** `02-activity-mermaid.mmd` y
  `02-activity-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 26. Secuencia de Configuración

- **Descripción:** presenta la interacción entre interfaz, validación, modelo y
  auditoría.
- **Actores involucrados:** Administrador.
- **Propósito:** documentar el orden de mantenimiento.
- **Archivos:** `03-sequence-mermaid.mmd` y
  `03-sequence-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 27. Estados de Plantilla

- **Descripción:** representa plantilla activa, inactiva y eliminada
  lógicamente.
- **Actores involucrados:** Administrador.
- **Propósito:** explicar su ciclo de vida.
- **Archivos:** `04-state-mermaid.mmd` y `04-state-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

## Observaciones

El efecto de desactivar plantillas sobre asignaciones existentes permanece
pendiente de confirmación.

