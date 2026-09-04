# Casos de Uso - Servicios Hospitalarios

## HOS-01. Listar servicios

- **Actor:** Administrador.
- **Objetivo:** consultar el catálogo hospitalario.
- **Escenario:** el Administrador abre el módulo.
- **Precondiciones:** sesión activa y rol `admin`.
- **Flujo principal:** autorizar; consultar registros no eliminados; mostrar
  listado.
- **Flujos alternativos:** otros roles no acceden al CRUD.
- **Postcondiciones:** catálogo visible sin cambios.
- **Reglas de negocio relacionadas:** gestión exclusiva del Administrador.
- **Módulo:** Servicios Hospitalarios.
- **Evidencia utilizada:** FEAT-003; análisis `03-use-cases.md` y
  `05-permissions.md`.

## HOS-02. Crear servicio

- **Actor:** Administrador.
- **Objetivo:** registrar un área hospitalaria.
- **Escenario:** se envía un nombre y datos descriptivos.
- **Precondiciones:** autorización administrativa.
- **Flujo principal:** validar nombre único entre no eliminados; crear en
  transacción; auditar.
- **Flujos alternativos:** nombre duplicado o datos inválidos impiden guardar.
- **Postcondiciones:** servicio disponible con su estado inicial.
- **Reglas de negocio relacionadas:** DEC-005; unicidad entre no eliminados.
- **Módulo:** Servicios Hospitalarios.
- **Evidencia utilizada:** análisis `04-business-rules.md` y
  `07-controllers.md`.

## HOS-03. Editar servicio

- **Actor:** Administrador.
- **Objetivo:** actualizar información del servicio.
- **Escenario:** se modifica un registro existente.
- **Precondiciones:** servicio no eliminado y autorización.
- **Flujo principal:** cargar; validar unicidad; actualizar en transacción;
  auditar.
- **Flujos alternativos:** nombre duplicado o validación fallida conservan datos.
- **Postcondiciones:** servicio actualizado.
- **Reglas de negocio relacionadas:** nombre único; operaciones críticas
  auditadas.
- **Módulo:** Servicios Hospitalarios.
- **Evidencia utilizada:** análisis `03-use-cases.md` y
  `04-business-rules.md`.

## HOS-04. Activar o desactivar servicio

- **Actor:** Administrador.
- **Objetivo:** controlar su disponibilidad operativa.
- **Escenario:** se cambia el estado `active`.
- **Precondiciones:** servicio existente y autorización.
- **Flujo principal:** actualizar estado en transacción; registrar auditoría.
- **Flujos alternativos:** solicitud no autorizada se rechaza.
- **Postcondiciones:** nuevo estado persistido.
- **Reglas de negocio relacionadas:** registros administrables poseen estado
  activo.
- **Módulo:** Servicios Hospitalarios.
- **Evidencia utilizada:** análisis `03-use-cases.md`,
  `04-business-rules.md` y `10-flow.md`.

## HOS-05. Eliminar servicio lógicamente

- **Actor:** Administrador.
- **Objetivo:** retirar un servicio sin borrar su historial.
- **Escenario:** se solicita eliminación.
- **Precondiciones:** servicio existente y autorización.
- **Flujo principal:** comprobar operación; aplicar SoftDelete en transacción;
  auditar.
- **Flujos alternativos:** dependencias o restricciones pueden impedir la
  operación; el comportamiento completo está pendiente de confirmación.
- **Postcondiciones:** servicio eliminado lógicamente o sin cambios.
- **Reglas de negocio relacionadas:** SoftDeletes e integridad referencial.
- **Módulo:** Servicios Hospitalarios.
- **Evidencia utilizada:** análisis `04-business-rules.md`, `09-database.md` y
  `11-pending.md`.

