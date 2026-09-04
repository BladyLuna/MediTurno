# Casos de Uso - Personal de Salud

## STF-01. Listar y filtrar personal

- **Actor:** Administrador.
- **Objetivo:** consultar personal por nombre, CI o servicio.
- **Escenario:** el Administrador abre el listado y aplica filtros.
- **Precondiciones:** sesión activa y rol `admin`.
- **Flujo principal:** autorizar; validar filtros; consultar; presentar
  resultados.
- **Flujos alternativos:** filtros sin coincidencias muestran lista vacía.
- **Postcondiciones:** resultados visibles sin cambios.
- **Reglas de negocio relacionadas:** solo Administrador gestiona personal.
- **Módulo:** Personal de Salud.
- **Evidencia utilizada:** FEAT-005; análisis `03-use-cases.md` y
  `05-permissions.md`.

## STF-02. Crear personal

- **Actor:** Administrador.
- **Objetivo:** registrar personal en un servicio.
- **Escenario:** se envían datos personales, servicio y usuario opcional.
- **Precondiciones:** servicio válido y autorización.
- **Flujo principal:** validar CI; validar servicio obligatorio; validar que el
  usuario opcional tenga rol `personal`; crear y auditar en transacción.
- **Flujos alternativos:** CI duplicado, asociación duplicada o usuario con rol
  incorrecto impiden crear.
- **Postcondiciones:** personal persistido y asociado.
- **Reglas de negocio relacionadas:** DEC-005 y DEC-010.
- **Módulo:** Personal de Salud.
- **Evidencia utilizada:** análisis `04-business-rules.md`; DEC-010.

## STF-03. Editar personal

- **Actor:** Administrador.
- **Objetivo:** actualizar datos y asociaciones.
- **Escenario:** se modifica un registro existente.
- **Precondiciones:** personal no eliminado y autorización.
- **Flujo principal:** cargar; validar CI, servicio y usuario; actualizar y
  auditar en transacción.
- **Flujos alternativos:** validación fallida conserva los datos anteriores.
- **Postcondiciones:** personal actualizado.
- **Reglas de negocio relacionadas:** unicidad entre no eliminados; usuario
  opcional con rol `personal`.
- **Módulo:** Personal de Salud.
- **Evidencia utilizada:** análisis `03-use-cases.md`,
  `04-business-rules.md` y `07-controllers.md`.

## STF-04. Activar o desactivar personal

- **Actor:** Administrador.
- **Objetivo:** controlar disponibilidad operativa.
- **Escenario:** se cambia `active`.
- **Precondiciones:** personal existente.
- **Flujo principal:** autorizar; actualizar en transacción; auditar.
- **Flujos alternativos:** solicitud no autorizada se rechaza.
- **Postcondiciones:** estado actualizado.
- **Reglas de negocio relacionadas:** operaciones críticas auditadas.
- **Módulo:** Personal de Salud.
- **Evidencia utilizada:** análisis `03-use-cases.md` y `10-flow.md`.

## STF-05. Eliminar personal lógicamente

- **Actor:** Administrador.
- **Objetivo:** retirar el registro conservando historial.
- **Escenario:** se solicita eliminación.
- **Precondiciones:** personal existente y no eliminado.
- **Flujo principal:** autorizar; aplicar SoftDelete en transacción; auditar.
- **Flujos alternativos:** restricciones de relaciones pueden impedir cambios
  físicos asociados.
- **Postcondiciones:** `deleted_at` establecido.
- **Reglas de negocio relacionadas:** SoftDeletes.
- **Módulo:** Personal de Salud.
- **Evidencia utilizada:** análisis `04-business-rules.md` y `09-database.md`.

## STF-06. Consultar personal administrado

- **Actor:** Jefe de Servicio.
- **Objetivo:** ver personal de sus servicios.
- **Escenario:** la jefatura abre el listado y aplica filtros permitidos.
- **Precondiciones:** rol `jefe_servicio` y asociaciones en
  `service_managers`.
- **Flujo principal:** obtener servicios administrados; limitar consulta;
  aplicar filtros; mostrar resultados.
- **Flujos alternativos:** sin servicios asociados se muestra resultado vacío;
  un servicio ajeno no puede forzarse.
- **Postcondiciones:** listado de solo lectura dentro del alcance.
- **Reglas de negocio relacionadas:** DEC-013 y DEC-014.
- **Módulo:** Personal de Salud.
- **Evidencia utilizada:** FEAT-017; análisis `02-actors.md` y
  `05-permissions.md`.

