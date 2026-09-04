# Módulo de Auditoría

## Objetivo

Conservar registros de operaciones críticas y ofrecer consulta básica de solo
lectura al Administrador.

## Actores

Administrador como lector. Administrador, Jefe de Servicio y Personal de Salud
pueden generar registros indirectamente al ejecutar operaciones críticas
autorizadas.

## Descripción general

La auditoría registra actor, acción, entidad, valores anteriores y nuevos,
dirección IP, agente de usuario y fecha cuando se ejecutan operaciones críticas.

## Casos de uso disponibles

Listar eventos, consultar detalle y registrar una operación crítica.

## Reglas de negocio relevantes

- La auditoría comienza desde las primeras operaciones críticas.
- El registro debe compartir transacción con la modificación cuando corresponda.
- Los reportes de lectura no se auditan.
- Solo el Administrador posee acceso global confirmado.

## Diagramas incluidos

### Figura 46. Casos de Uso de Auditoría

- **Descripción:** representa consulta y generación indirecta de eventos.
- **Actores involucrados:** Administrador y operadores autenticados.
- **Propósito:** delimitar lectura y trazabilidad.
- **Archivos:** `01-use-case-mermaid.mmd` y `01-use-case-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 47. Actividad de Auditoría

- **Descripción:** muestra captura de valores y creación del registro durante una
  operación crítica.
- **Actores involucrados:** operador autenticado.
- **Propósito:** explicar la trazabilidad transaccional.
- **Archivos:** `02-activity-mermaid.mmd` y
  `02-activity-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

### Figura 48. Secuencia de Auditoría

- **Descripción:** presenta interacción entre operación, servicio de auditoría y
  persistencia.
- **Actores involucrados:** operador autenticado y Administrador como lector.
- **Propósito:** documentar generación y consulta de evidencia.
- **Archivos:** `03-sequence-mermaid.mmd` y
  `03-sequence-plantuml.puml`.
- **Fuente:** Elaboración propia (2026).

## Observaciones

No se incluye diagrama de estados porque un evento de auditoría es un registro
histórico de solo creación; no tiene transiciones de negocio confirmadas. La
retención e inmutabilidad técnica permanecen pendientes de confirmación.
