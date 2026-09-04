# Módulo de Autenticación y Dashboard

## Objetivo

Proporcionar inicio y cierre de sesión, además del punto de entrada autenticado
para cada rol.

## Actores

Invitado, Administrador, Jefe de Servicio y Personal de Salud.

## Descripción general

El módulo valida credenciales y estado activo, crea la sesión y dirige al
dashboard correspondiente. El cierre invalida la sesión.

## Casos de uso disponibles

Abrir login, autenticarse, ver dashboard y cerrar sesión.

## Reglas de negocio relevantes

- Roles oficiales: `admin`, `jefe_servicio` y `personal`.
- Las rutas protegidas requieren usuario autenticado y activo.
- No se utiliza un paquete externo de permisos.
- El throttling actual del login permanece pendiente de confirmación.

## Diagramas incluidos

### Figura 4. Casos de Uso de Autenticación y Dashboard

- **Descripción:** muestra ingreso, acceso al dashboard y cierre de sesión.
- **Actores involucrados:** Invitado y usuarios autenticados.
- **Propósito:** delimitar las funciones de acceso al sistema.
- **Archivos:** `01-use-case-mermaid.mmd` y `01-use-case-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 5. Actividad de Autenticación

- **Descripción:** presenta la validación de credenciales, cuenta activa y
  creación de sesión.
- **Actores involucrados:** Invitado y usuario autenticado.
- **Propósito:** explicar las decisiones del flujo de acceso.
- **Archivos:** `02-activity-mermaid.mmd` y
  `02-activity-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 6. Secuencia de Autenticación

- **Descripción:** representa la interacción entre actor, interfaz, controlador
  y autenticación.
- **Actores involucrados:** Invitado.
- **Propósito:** mostrar el orden de validación y respuesta.
- **Archivos:** `03-sequence-mermaid.mmd` y
  `03-sequence-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 7. Estados de Sesión

- **Descripción:** representa la transición entre sesión no autenticada,
  autenticada e invalidada.
- **Actores involucrados:** Invitado y usuario autenticado.
- **Propósito:** explicar el ciclo de vida de acceso.
- **Archivos:** `04-state-mermaid.mmd` y `04-state-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

## Observaciones

El detalle académico de los casos se encuentra en `05-use-cases.md`.

