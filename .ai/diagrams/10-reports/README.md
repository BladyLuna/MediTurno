# Módulo de Reportes

## Objetivo

Presentar resúmenes y detalles por servicio o empleado con salida HTML, CSV y
PDF.

## Actores

Administrador y Jefe de Servicio.

## Descripción general

El Administrador consulta globalmente y la jefatura solo servicios asociados.
Las operaciones son de lectura y reutilizan los mismos filtros en las
exportaciones.

## Casos de uso disponibles

Filtrar, consultar resumen/detalle, exportar CSV y exportar PDF.

## Reglas de negocio relevantes

- Incluye `assigned` y `changed`; excluye `cancelled` y eliminados.
- Filtra por intersección del intervalo real.
- Calcula horas desde `start_at` y `end_at`.
- Exportaciones reutilizan los filtros de la vista.
- Las lecturas de reportes no se auditan.

## Diagramas incluidos

### Figura 35. Casos de Uso de Reportes

- **Descripción:** representa consulta y exportación según alcance.
- **Actores involucrados:** Administrador y Jefe de Servicio.
- **Propósito:** delimitar salidas y restricciones.
- **Archivos:** `01-use-case-mermaid.mmd` y `01-use-case-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 36. Actividad de Generación de Reporte

- **Descripción:** muestra validación de filtros, consulta, agrupación y salida.
- **Actores involucrados:** Administrador o Jefe de Servicio.
- **Propósito:** explicar el procesamiento de lectura.
- **Archivos:** `02-activity-mermaid.mmd` y
  `02-activity-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 37. Secuencia de Generación de Reporte

- **Descripción:** presenta interacción entre actor, controlador, servicio y
  formato de salida.
- **Actores involucrados:** Administrador o Jefe de Servicio.
- **Propósito:** documentar la reutilización de filtros.
- **Archivos:** `03-sequence-mermaid.mmd` y
  `03-sequence-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

## Observaciones

No se incluye diagrama de estados porque el reporte es una consulta calculada y
no posee persistencia ni ciclo de vida propio.

