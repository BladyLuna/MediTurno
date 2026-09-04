# Casos de Uso - Asignaciones de Turno

## ASN-01. Listar y filtrar asignaciones

- **Actor:** Administrador o Jefe de Servicio.
- **Objetivo:** consultar asignaciones dentro del alcance autorizado.
- **Escenario:** el actor abre el listado y aplica filtros.
- **Precondiciones:** sesión activa y rol permitido.
- **Flujo principal:** determinar alcance; validar filtros; consultar registros;
  mostrar resultados.
- **Flujos alternativos:** jefatura sin servicios obtiene lista vacía; IDs ajenos
  se rechazan.
- **Postcondiciones:** listado visible sin modificar datos.
- **Reglas de negocio relacionadas:** Administrador global; jefatura limitada
  por `service_managers`.
- **Módulo:** Asignaciones de Turno.
- **Evidencia utilizada:** FEAT-008/019; DEC-014; análisis
  `03-use-cases.md`.

## ASN-02. Crear asignación

- **Actor:** Administrador o Jefe de Servicio.
- **Objetivo:** asignar un turno fechado al personal.
- **Escenario:** se seleccionan servicio, personal, turno y fecha.
- **Precondiciones:** entidades activas, relacionadas y dentro del alcance.
- **Flujo principal:** validar alcance; calcular `start_at/end_at`; comprobar
  traslapes; crear con estado `assigned` en transacción; auditar.
- **Flujos alternativos:** conflicto horario, entidad inactiva, relación
  inconsistente o ID fuera de alcance impiden crear.
- **Postcondiciones:** asignación persistida sin traslapes.
- **Reglas de negocio relacionadas:** DEC-003, DEC-004 y DEC-014.
- **Módulo:** Asignaciones de Turno.
- **Evidencia utilizada:** FEAT-008/009/019; análisis
  `04-business-rules.md`.

## ASN-03. Editar asignación

- **Actor:** Administrador o Jefe de Servicio.
- **Objetivo:** modificar turno, fecha u observaciones autorizadas.
- **Escenario:** se envían cambios sobre una asignación existente.
- **Precondiciones:** asignación no cancelada ni eliminada; alcance válido.
- **Flujo principal:** autorizar; recalcular intervalo; comprobar conflicto
  excluyendo el registro actual; actualizar con estado `changed`; auditar.
- **Flujos alternativos:** conflicto, datos inconsistentes, estado cancelado o
  alcance ajeno producen rechazo.
- **Postcondiciones:** asignación actualizada y auditada.
- **Reglas de negocio relacionadas:** DEC-003, DEC-004 y DEC-014.
- **Módulo:** Asignaciones de Turno.
- **Evidencia utilizada:** análisis `03-use-cases.md`,
  `04-business-rules.md` y `10-flow.md`.

## ASN-04. Cancelar asignación

- **Actor:** Administrador o Jefe de Servicio.
- **Objetivo:** retirar una asignación conservando trazabilidad.
- **Escenario:** el actor solicita eliminar una asignación.
- **Precondiciones:** asignación autorizada, no cancelada y no eliminada.
- **Flujo principal:** establecer `cancelled`; aplicar SoftDelete; registrar
  acción `cancelled/deleted` dentro de transacción.
- **Flujos alternativos:** registro cancelado/eliminado o fuera de alcance se
  rechaza.
- **Postcondiciones:** asignación cancelada y eliminada lógicamente.
- **Reglas de negocio relacionadas:** DEC-012 y DEC-014.
- **Módulo:** Asignaciones de Turno.
- **Evidencia utilizada:** DEC-012; análisis `04-business-rules.md`.

## ASN-05. Consultar disponibilidad

- **Actor:** Jefe de Servicio.
- **Objetivo:** conocer conflictos antes de asignar.
- **Escenario:** la jefatura consulta personal, fecha y turno de su servicio.
- **Precondiciones:** servicio administrado y datos permitidos.
- **Flujo principal:** validar alcance; calcular intervalo; consultar conflicto;
  devolver disponibilidad.
- **Flujos alternativos:** IDs fuera del alcance o datos inválidos se rechazan.
- **Postcondiciones:** resultado informativo; no se crea asignación.
- **Reglas de negocio relacionadas:** DEC-003 y DEC-014.
- **Módulo:** Asignaciones de Turno.
- **Evidencia utilizada:** FEAT-020; análisis `03-use-cases.md` y
  `05-permissions.md`.

