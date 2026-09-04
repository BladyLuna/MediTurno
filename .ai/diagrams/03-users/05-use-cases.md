# Casos de Uso - Usuarios

## USR-01. Listar usuarios

- **Actor:** Administrador.
- **Objetivo:** consultar cuentas administrables.
- **Escenario:** el Administrador abre la gestión de usuarios.
- **Precondiciones:** sesión activa y rol `admin`.
- **Flujo principal:** autorizar acceso; aplicar consulta; mostrar listado
  paginado.
- **Flujos alternativos:** otros roles reciben denegación.
- **Postcondiciones:** listado visible sin modificar datos.
- **Reglas de negocio relacionadas:** CRUD exclusivo del Administrador.
- **Módulo:** Usuarios.
- **Evidencia utilizada:** FEAT-002; análisis `03-use-cases.md` y
  `05-permissions.md`.

## USR-02. Crear usuario

- **Actor:** Administrador.
- **Objetivo:** registrar una cuenta con rol oficial.
- **Escenario:** el Administrador completa y envía el formulario.
- **Precondiciones:** autorización administrativa.
- **Flujo principal:** validar datos y correo único; validar rol; crear dentro de
  transacción; registrar auditoría.
- **Flujos alternativos:** datos inválidos, correo duplicado o rol no permitido
  impiden la creación.
- **Postcondiciones:** cuenta persistida con estado definido.
- **Reglas de negocio relacionadas:** DEC-001; email único; operación
  transaccional y auditada.
- **Módulo:** Usuarios.
- **Evidencia utilizada:** USR-02; DEC-001; análisis `04-business-rules.md`.

## USR-03. Editar usuario

- **Actor:** Administrador.
- **Objetivo:** actualizar datos, rol o contraseña de una cuenta.
- **Escenario:** el Administrador modifica un usuario existente.
- **Precondiciones:** usuario existente y autorización.
- **Flujo principal:** cargar registro; validar cambios; actualizar en
  transacción; auditar valores anteriores y nuevos.
- **Flujos alternativos:** datos inválidos o correo duplicado conservan el estado
  anterior.
- **Postcondiciones:** cuenta actualizada y cambio auditado.
- **Reglas de negocio relacionadas:** roles oficiales; email único.
- **Módulo:** Usuarios.
- **Evidencia utilizada:** USR-03; análisis `07-controllers.md` y
  `04-business-rules.md`.

## USR-04. Activar o desactivar usuario

- **Actor:** Administrador.
- **Objetivo:** controlar la posibilidad de acceso.
- **Escenario:** el Administrador cambia el campo `active`.
- **Precondiciones:** usuario existente y autorización.
- **Flujo principal:** comprobar reglas de protección; actualizar estado en
  transacción; auditar.
- **Flujos alternativos:** se rechaza autodesactivación o desactivación del último
  administrador activo.
- **Postcondiciones:** estado actualizado o rechazo sin cambios.
- **Reglas de negocio relacionadas:** DEC-009.
- **Módulo:** Usuarios.
- **Evidencia utilizada:** USR-04; DEC-009; análisis `04-business-rules.md`.

## USR-05. Eliminar usuario lógicamente

- **Actor:** Administrador.
- **Objetivo:** retirar una cuenta conservando trazabilidad.
- **Escenario:** el Administrador solicita eliminación.
- **Precondiciones:** usuario existente, no eliminado y autorizado.
- **Flujo principal:** comprobar reglas de protección; aplicar SoftDelete en
  transacción; auditar.
- **Flujos alternativos:** se rechaza autoeliminación o eliminación del último
  administrador activo.
- **Postcondiciones:** `deleted_at` establecido o registro sin cambios.
- **Reglas de negocio relacionadas:** DEC-009; SoftDeletes.
- **Módulo:** Usuarios.
- **Evidencia utilizada:** USR-05; DEC-009; FEAT-014.

