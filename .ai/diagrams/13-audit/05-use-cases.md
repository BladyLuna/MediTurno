# Casos de Uso - Auditoría

## AUD-01. Listar eventos

- **Actor:** Administrador.
- **Objetivo:** consultar operaciones críticas registradas.
- **Escenario:** el Administrador abre la auditoría.
- **Precondiciones:** sesión activa y rol `admin`.
- **Flujo principal:** autorizar; consultar eventos; presentar listado.
- **Flujos alternativos:** otros roles no tienen acceso global confirmado.
- **Postcondiciones:** eventos visibles sin modificaciones.
- **Reglas de negocio relacionadas:** auditoría de solo lectura para
  Administrador.
- **Módulo:** Auditoría.
- **Evidencia utilizada:** FEAT-014; análisis `03-use-cases.md` y
  `05-permissions.md`.

## AUD-02. Consultar detalle de evento

- **Actor:** Administrador.
- **Objetivo:** revisar actor, acción, entidad y cambios.
- **Escenario:** se selecciona un evento.
- **Precondiciones:** evento existente y autorización.
- **Flujo principal:** cargar registro; presentar usuario, entidad, valores,
  metadatos y fecha.
- **Flujos alternativos:** evento inexistente produce respuesta controlada.
- **Postcondiciones:** detalle visible sin cambios.
- **Reglas de negocio relacionadas:** registro de valores anteriores y nuevos,
  IP y agente cuando estén disponibles.
- **Módulo:** Auditoría.
- **Evidencia utilizada:** análisis `03-use-cases.md`,
  `08-models.md` y `09-database.md`.

## AUD-03. Registrar operación crítica

- **Actor:** Administrador, Jefe de Servicio o Personal de Salud de forma
  indirecta, según la operación autorizada.
- **Objetivo:** conservar trazabilidad de una modificación.
- **Escenario:** una operación crítica crea, actualiza, cambia estado o elimina
  lógicamente una entidad.
- **Precondiciones:** operación autorizada y datos de auditoría disponibles.
- **Flujo principal:** ejecutar operación; capturar actor, acción, entidad,
  valores y metadatos; crear evento dentro de la transacción correspondiente.
- **Flujos alternativos:** los reportes de lectura no generan auditoría.
- **Postcondiciones:** operación y evento persistidos de forma coherente.
- **Reglas de negocio relacionadas:** auditoría desde fases tempranas; escrituras
  críticas transaccionales.
- **Módulo:** Auditoría.
- **Evidencia utilizada:** FEAT-014; análisis `04-business-rules.md` y
  `10-flow.md`.
