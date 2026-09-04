# Módulo de Usuarios

## Objetivo

Administrar cuentas, roles, activación y eliminación lógica.

## Actores

Administrador.

## Descripción general

El Administrador lista, crea, modifica, activa, desactiva y elimina lógicamente
usuarios. Las operaciones críticas son transaccionales y auditadas.

## Casos de uso disponibles

Listar, crear, editar, activar/desactivar y eliminar lógicamente usuarios.

## Reglas de negocio relevantes

- Roles oficiales almacenados en `users.role`.
- No se puede desactivar o eliminar al último administrador activo.
- Un administrador no puede desactivarse ni eliminarse a sí mismo.
- El correo es único y los usuarios usan SoftDeletes.

## Diagramas incluidos

### Figura 8. Casos de Uso de Usuarios

- **Descripción:** presenta las operaciones administrativas sobre cuentas.
- **Actores involucrados:** Administrador.
- **Propósito:** delimitar el CRUD y control de estado.
- **Archivos:** `01-use-case-mermaid.mmd` y `01-use-case-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 9. Actividad de Gestión de Usuarios

- **Descripción:** representa validación, persistencia y auditoría de una
  operación administrativa.
- **Actores involucrados:** Administrador.
- **Propósito:** explicar el flujo de una modificación de usuario.
- **Archivos:** `02-activity-mermaid.mmd` y
  `02-activity-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 10. Secuencia de Gestión de Usuarios

- **Descripción:** muestra la interacción entre Administrador, interfaz,
  controlador, validación y persistencia.
- **Actores involucrados:** Administrador.
- **Propósito:** documentar responsabilidades y orden de ejecución.
- **Archivos:** `03-sequence-mermaid.mmd` y
  `03-sequence-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 11. Estados del Usuario

- **Descripción:** representa los estados activo, inactivo y eliminado
  lógicamente.
- **Actores involucrados:** Administrador.
- **Propósito:** explicar el ciclo de vida administrable de una cuenta.
- **Archivos:** `04-state-mermaid.mmd` y `04-state-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

## Observaciones

El módulo es de administración global y no concede CRUD a otros roles.

