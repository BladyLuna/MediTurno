# Módulo de Personal de Salud

## Objetivo

Mantener al personal, su servicio principal y su asociación opcional con una
cuenta; ofrecer lectura restringida a jefatura.

## Actores

Administrador y Jefe de Servicio.

## Descripción general

El Administrador realiza el CRUD y control de estado. El Jefe de Servicio
consulta únicamente personal perteneciente a servicios administrados.

## Casos de uso disponibles

Listar y filtrar, crear, editar, activar, desactivar y eliminar personal; consultar
personal por servicio desde jefatura.

## Reglas de negocio relevantes

- `hospital_service_id` es obligatorio.
- `user_id` es opcional y debe corresponder a un usuario `personal`.
- CI y asociación activa de usuario son únicos entre registros no eliminados.
- Las escrituras son transaccionales, auditadas y usan SoftDeletes.

## Diagramas incluidos

### Figura 16. Casos de Uso de Personal

- **Descripción:** representa gestión administrativa y consulta por jefatura.
- **Actores involucrados:** Administrador y Jefe de Servicio.
- **Propósito:** diferenciar gestión global y lectura restringida.
- **Archivos:** `01-use-case-mermaid.mmd` y `01-use-case-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 17. Actividad de Gestión de Personal

- **Descripción:** muestra validación de servicio, usuario opcional y
  persistencia.
- **Actores involucrados:** Administrador.
- **Propósito:** explicar el flujo principal de mantenimiento.
- **Archivos:** `02-activity-mermaid.mmd` y
  `02-activity-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 18. Secuencia de Gestión de Personal

- **Descripción:** presenta las interacciones de una operación de personal.
- **Actores involucrados:** Administrador.
- **Propósito:** documentar validación, transacción y auditoría.
- **Archivos:** `03-sequence-mermaid.mmd` y
  `03-sequence-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 19. Estados del Personal

- **Descripción:** representa personal activo, inactivo y eliminado lógicamente.
- **Actores involucrados:** Administrador.
- **Propósito:** explicar el ciclo de vida del registro.
- **Archivos:** `04-state-mermaid.mmd` y `04-state-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

## Observaciones

El historial de transferencias entre servicios y la restauración permanecen
pendientes de confirmación.

