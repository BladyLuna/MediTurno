# Módulo de Jefaturas por Servicio

## Objetivo

Asociar usuarios de jefatura con uno o varios servicios hospitalarios.

## Actores

Administrador y Jefe de Servicio.

## Descripción general

El Administrador mantiene asociaciones usuario-servicio. El Jefe de Servicio
consume dichas asociaciones como alcance obligatorio en módulos operativos.

## Casos de uso disponibles

Listar, crear y eliminar lógicamente asociaciones; consumir alcance operativo.

## Reglas de negocio relevantes

- Un jefe puede administrar múltiples servicios.
- No se permiten pares activos duplicados de usuario y servicio.
- Las asociaciones usan SoftDeletes y auditoría.
- La restricción exacta de roles admitidos por la interfaz permanece pendiente
  de confirmación.

## Diagramas incluidos

### Figura 20. Casos de Uso de Jefaturas

- **Descripción:** muestra administración y consumo de asociaciones.
- **Actores involucrados:** Administrador y Jefe de Servicio.
- **Propósito:** explicar cómo se define el alcance de jefatura.
- **Archivos:** `01-use-case-mermaid.mmd` y `01-use-case-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 21. Actividad de Asociación

- **Descripción:** representa validación y creación de una relación
  usuario-servicio.
- **Actores involucrados:** Administrador.
- **Propósito:** documentar el flujo administrativo.
- **Archivos:** `02-activity-mermaid.mmd` y
  `02-activity-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 22. Secuencia de Asociación

- **Descripción:** presenta la interacción entre interfaz, validación,
  persistencia y auditoría.
- **Actores involucrados:** Administrador.
- **Propósito:** mostrar el orden de registro de una jefatura.
- **Archivos:** `03-sequence-mermaid.mmd` y
  `03-sequence-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 23. Estados de la Asociación

- **Descripción:** representa asociación activa y eliminada lógicamente.
- **Actores involucrados:** Administrador.
- **Propósito:** explicar el ciclo de vida del alcance.
- **Archivos:** `04-state-mermaid.mmd` y `04-state-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

## Observaciones

No existe flujo confirmado de restauración de asociaciones eliminadas.

