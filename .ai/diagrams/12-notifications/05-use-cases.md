# Casos de Uso - Notificaciones

## NTF-01. Listar notificaciones propias

- **Actor:** Usuario autenticado activo.
- **Objetivo:** consultar mensajes recibidos.
- **Escenario:** el usuario abre notificaciones.
- **Precondiciones:** sesión activa.
- **Flujo principal:** autorizar; filtrar por usuario; mostrar mensajes y estado.
- **Flujos alternativos:** sin mensajes se muestra lista vacía.
- **Postcondiciones:** notificaciones propias visibles.
- **Reglas de negocio relacionadas:** cada notificación pertenece a un usuario.
- **Módulo:** Notificaciones.
- **Evidencia utilizada:** FEAT-016; análisis `03-use-cases.md` y
  `05-permissions.md`.

## NTF-02. Marcar notificación como leída

- **Actor:** Usuario autenticado activo.
- **Objetivo:** registrar lectura de un mensaje propio.
- **Escenario:** el usuario abre o marca una notificación.
- **Precondiciones:** notificación perteneciente al usuario.
- **Flujo principal:** autorizar propiedad; establecer `read_at`; guardar.
- **Flujos alternativos:** notificación ajena se rechaza; una ya leída conserva
  estado.
- **Postcondiciones:** `read_at` definido.
- **Reglas de negocio relacionadas:** usuarios no actualizan mensajes ajenos.
- **Módulo:** Notificaciones.
- **Evidencia utilizada:** análisis `04-business-rules.md` y
  diagrama de estados.

## NTF-03. Marcar todas como leídas

- **Actor:** Usuario autenticado activo.
- **Objetivo:** actualizar sus mensajes pendientes en conjunto.
- **Escenario:** el usuario ejecuta la acción global.
- **Precondiciones:** sesión activa.
- **Flujo principal:** filtrar notificaciones no leídas propias; establecer
  `read_at`; guardar.
- **Flujos alternativos:** sin pendientes no se requieren cambios.
- **Postcondiciones:** notificaciones propias marcadas como leídas.
- **Reglas de negocio relacionadas:** alcance por propietario.
- **Módulo:** Notificaciones.
- **Evidencia utilizada:** análisis `03-use-cases.md` y
  `05-permissions.md`.

## NTF-04. Recibir notificación de solicitud

- **Actor:** Administrador, Jefe de Servicio o Personal de Salud como usuario
  destinatario.
- **Objetivo:** informar un evento del ciclo de solicitudes.
- **Escenario:** se crea, cancela, aprueba o rechaza una solicitud.
- **Precondiciones:** operación de solicitud confirmada.
- **Flujo principal:** determinar destinatarios; crear mensaje interno con datos
  del evento.
- **Flujos alternativos:** canales externos no se ejecutan por estar Post-MVP.
- **Postcondiciones:** notificación interna pendiente de lectura.
- **Reglas de negocio relacionadas:** notificaciones internas básicas; canales
  externos fuera de alcance.
- **Módulo:** Notificaciones.
- **Evidencia utilizada:** FEAT-016; análisis `01-summary.md`,
  `03-use-cases.md` y `04-business-rules.md`.
