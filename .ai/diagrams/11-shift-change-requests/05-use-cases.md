# Casos de Uso - Solicitudes de Cambio

## SCR-01. Listar solicitudes propias

- **Actor:** Personal de Salud.
- **Objetivo:** consultar solicitudes realizadas.
- **Escenario:** el personal abre su listado.
- **Precondiciones:** sesión activa, rol `personal` y perfil asociado.
- **Flujo principal:** identificar usuario; consultar solicitudes propias;
  mostrar estados.
- **Flujos alternativos:** sin solicitudes se muestra lista vacía.
- **Postcondiciones:** historial propio visible.
- **Reglas de negocio relacionadas:** propiedad por solicitante.
- **Módulo:** Solicitudes de Cambio.
- **Evidencia utilizada:** FEAT-015; análisis `03-use-cases.md` y
  `05-permissions.md`.

## SCR-02. Crear solicitud

- **Actor:** Personal de Salud.
- **Objetivo:** pedir revisión de una asignación propia.
- **Escenario:** se selecciona asignación y se registra motivo.
- **Precondiciones:** asignación propia en estado permitido.
- **Flujo principal:** autorizar propiedad; validar motivo y asignación; crear
  `pending` en transacción; auditar; notificar revisores.
- **Flujos alternativos:** asignación ajena, cancelada o datos inválidos impiden
  crear.
- **Postcondiciones:** solicitud pendiente y notificaciones generadas.
- **Reglas de negocio relacionadas:** estados de DEC-008; operación auditada.
- **Módulo:** Solicitudes de Cambio.
- **Evidencia utilizada:** DEC-008; análisis `04-business-rules.md` y
  `10-flow.md`.

## SCR-03. Consultar solicitud propia

- **Actor:** Personal de Salud.
- **Objetivo:** revisar detalle y estado.
- **Escenario:** se abre una solicitud.
- **Precondiciones:** solicitud perteneciente al usuario.
- **Flujo principal:** autorizar propiedad; cargar detalle; mostrar datos.
- **Flujos alternativos:** solicitud ajena produce denegación.
- **Postcondiciones:** detalle visible sin cambios.
- **Reglas de negocio relacionadas:** acceso limitado al propietario.
- **Módulo:** Solicitudes de Cambio.
- **Evidencia utilizada:** análisis `03-use-cases.md` y
  `05-permissions.md`.

## SCR-04. Cancelar solicitud

- **Actor:** Personal de Salud.
- **Objetivo:** retirar una solicitud pendiente propia.
- **Escenario:** se ejecuta cancelación.
- **Precondiciones:** propiedad y estado `pending`.
- **Flujo principal:** autorizar; cambiar a `cancelled` en transacción; auditar;
  notificar cuando corresponda.
- **Flujos alternativos:** solicitud aprobada, rechazada, cancelada o ajena se
  rechaza.
- **Postcondiciones:** solicitud cancelada.
- **Reglas de negocio relacionadas:** solo pendientes pueden cancelarse.
- **Módulo:** Solicitudes de Cambio.
- **Evidencia utilizada:** análisis `04-business-rules.md` y
  diagrama de estados.

## SCR-05. Listar solicitudes para revisión

- **Actor:** Administrador o Jefe de Servicio.
- **Objetivo:** consultar solicitudes autorizadas.
- **Escenario:** el revisor abre la bandeja.
- **Precondiciones:** rol permitido; jefatura con servicios asociados.
- **Flujo principal:** determinar alcance; consultar solicitudes; mostrar
  listado.
- **Flujos alternativos:** jefatura no visualiza solicitudes de otros servicios.
- **Postcondiciones:** bandeja autorizada visible.
- **Reglas de negocio relacionadas:** Administrador global; jefatura limitada.
- **Módulo:** Solicitudes de Cambio.
- **Evidencia utilizada:** FEAT-017; análisis `02-actors.md` y
  `05-permissions.md`.

## SCR-06. Aprobar o rechazar solicitud

- **Actor:** Administrador o Jefe de Servicio.
- **Objetivo:** registrar una decisión administrativa.
- **Escenario:** el revisor selecciona aprobación o rechazo y observaciones.
- **Precondiciones:** solicitud `pending` y dentro del alcance.
- **Flujo principal:** autorizar; validar decisión; actualizar estado y revisor
  en transacción; auditar; notificar al solicitante.
- **Flujos alternativos:** solicitud no pendiente o fuera de alcance se rechaza.
- **Postcondiciones:** estado `approved` o `rejected`.
- **Reglas de negocio relacionadas:** DEC-008; CONFLICT-004 se conserva sin
  resolución.
- **Módulo:** Solicitudes de Cambio.
- **Evidencia utilizada:** análisis `04-business-rules.md`,
  `10-flow.md` y `11-pending.md`.

## SCR-07. Consultar historial de auditoría

- **Actor:** Administrador.
- **Objetivo:** rastrear operaciones sobre solicitudes.
- **Escenario:** se consulta la evidencia registrada.
- **Precondiciones:** rol `admin` y eventos existentes.
- **Flujo principal:** autorizar acceso a auditoría; localizar eventos; presentar
  detalle.
- **Flujos alternativos:** otros roles no poseen acceso global confirmado.
- **Postcondiciones:** trazabilidad visible sin cambios.
- **Reglas de negocio relacionadas:** operaciones críticas auditadas.
- **Módulo:** Solicitudes de Cambio.
- **Evidencia utilizada:** análisis `03-use-cases.md`; módulo de auditoría.

