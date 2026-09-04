# Módulo de Asignaciones de Turno

## Objetivo

Asignar turnos fechados al personal, calcular intervalos, evitar traslapes,
consultar disponibilidad y conservar trazabilidad.

## Actores

Administrador y Jefe de Servicio.

## Descripción general

El Administrador opera globalmente. El Jefe de Servicio crea, edita y cancela
solo asignaciones de sus servicios y consulta disponibilidad dentro del mismo
alcance.

## Casos de uso disponibles

Listar y filtrar, crear, editar, cancelar/eliminar lógicamente y consultar
disponibilidad.

## Reglas de negocio relevantes

- No se permiten traslapes; sí se permiten turnos consecutivos.
- Los turnos nocturnos terminan al día siguiente.
- Personal y plantilla deben pertenecer al servicio activo seleccionado.
- Crear asigna estado `assigned`; editar, `changed`; cancelar, `cancelled` y
  SoftDelete.
- Jefatura no puede forzar IDs fuera de `service_managers`.
- Las operaciones críticas son transaccionales y auditadas.

## Diagramas incluidos

### Figura 28. Casos de Uso de Asignaciones

- **Descripción:** representa operaciones globales y restringidas por servicio.
- **Actores involucrados:** Administrador y Jefe de Servicio.
- **Propósito:** delimitar gestión, disponibilidad y seguridad de alcance.
- **Archivos:** `01-use-case-mermaid.mmd` y `01-use-case-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 29. Actividad de Asignación

- **Descripción:** muestra validación de alcance, intervalo, conflicto y
  persistencia.
- **Actores involucrados:** Administrador o Jefe de Servicio.
- **Propósito:** explicar el flujo crítico de creación/edición.
- **Archivos:** `02-activity-mermaid.mmd` y
  `02-activity-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 30. Secuencia de Asignación

- **Descripción:** presenta interacciones con servicios de tiempo, conflicto,
  alcance y auditoría.
- **Actores involucrados:** Administrador o Jefe de Servicio.
- **Propósito:** documentar responsabilidades de la operación.
- **Archivos:** `03-sequence-mermaid.mmd` y
  `03-sequence-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 31. Estados de Asignación

- **Descripción:** representa `assigned`, `changed` y `cancelled`.
- **Actores involucrados:** Administrador y Jefe de Servicio.
- **Propósito:** explicar el ciclo de vida de una asignación.
- **Archivos:** `04-state-mermaid.mmd` y `04-state-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

## Observaciones

No se documenta restauración de asignaciones eliminadas. Jefatura no puede operar
registros cancelados o eliminados.

