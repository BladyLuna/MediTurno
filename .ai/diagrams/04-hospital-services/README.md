# Módulo de Servicios Hospitalarios

## Objetivo

Mantener las áreas hospitalarias que delimitan personal, turnos, asignaciones y
jefaturas.

## Actores

Administrador. Jefe de Servicio y Personal de Salud consumen la asociación de
forma indirecta.

## Descripción general

El Administrador gestiona el catálogo de servicios. Los demás módulos utilizan
`hospital_service_id` para establecer pertenencia y alcance.

## Casos de uso disponibles

Listar, crear, editar, activar, desactivar y eliminar lógicamente servicios.

## Reglas de negocio relevantes

- La clave oficial es `hospital_service_id`.
- El nombre es único entre registros no eliminados.
- Se aplican SoftDeletes, transacciones y auditoría.

## Diagramas incluidos

### Figura 12. Casos de Uso de Servicios Hospitalarios

- **Descripción:** muestra las operaciones de mantenimiento del catálogo.
- **Actores involucrados:** Administrador.
- **Propósito:** delimitar la gestión del servicio hospitalario.
- **Archivos:** `01-use-case-mermaid.mmd` y `01-use-case-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 13. Actividad de Gestión de Servicios

- **Descripción:** representa validación, escritura y auditoría.
- **Actores involucrados:** Administrador.
- **Propósito:** explicar el flujo de mantenimiento.
- **Archivos:** `02-activity-mermaid.mmd` y
  `02-activity-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 14. Secuencia de Gestión de Servicios

- **Descripción:** presenta la interacción entre interfaz, controlador, modelo y
  auditoría.
- **Actores involucrados:** Administrador.
- **Propósito:** documentar el orden de una operación crítica.
- **Archivos:** `03-sequence-mermaid.mmd` y
  `03-sequence-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 15. Estados del Servicio

- **Descripción:** representa servicio activo, inactivo y eliminado lógicamente.
- **Actores involucrados:** Administrador.
- **Propósito:** explicar su ciclo de vida.
- **Archivos:** `04-state-mermaid.mmd` y `04-state-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

## Observaciones

El flujo de restauración de servicios eliminados permanece pendiente de
confirmación.

