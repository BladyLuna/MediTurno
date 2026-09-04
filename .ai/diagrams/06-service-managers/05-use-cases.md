# Casos de Uso - Jefaturas por Servicio

## MGR-01. Listar asociaciones

- **Actor:** Administrador.
- **Objetivo:** consultar usuarios y servicios asociados.
- **Escenario:** el Administrador abre la gestión de jefaturas.
- **Precondiciones:** sesión activa y rol `admin`.
- **Flujo principal:** autorizar; consultar asociaciones activas; mostrar
  listado.
- **Flujos alternativos:** otros roles no acceden a la gestión.
- **Postcondiciones:** asociaciones visibles.
- **Reglas de negocio relacionadas:** gestión exclusiva del Administrador.
- **Módulo:** Jefaturas por Servicio.
- **Evidencia utilizada:** FEAT-004; análisis `03-use-cases.md` y
  `05-permissions.md`.

## MGR-02. Crear asociación

- **Actor:** Administrador.
- **Objetivo:** asignar un servicio a una jefatura.
- **Escenario:** se selecciona usuario y servicio.
- **Precondiciones:** usuario y servicio válidos y activos.
- **Flujo principal:** validar datos; comprobar ausencia de par activo duplicado;
  crear en transacción; auditar.
- **Flujos alternativos:** par duplicado o datos no válidos impiden crear.
- **Postcondiciones:** nuevo alcance disponible.
- **Reglas de negocio relacionadas:** DEC-006; pares activos únicos.
- **Módulo:** Jefaturas por Servicio.
- **Evidencia utilizada:** análisis `04-business-rules.md` y
  `07-controllers.md`.

## MGR-03. Eliminar asociación lógicamente

- **Actor:** Administrador.
- **Objetivo:** retirar un servicio del alcance de un usuario.
- **Escenario:** el Administrador elimina una asociación.
- **Precondiciones:** asociación activa.
- **Flujo principal:** autorizar; aplicar SoftDelete en transacción; auditar.
- **Flujos alternativos:** asociación inexistente o no autorizada se rechaza.
- **Postcondiciones:** relación fuera del alcance activo.
- **Reglas de negocio relacionadas:** SoftDeletes y auditoría.
- **Módulo:** Jefaturas por Servicio.
- **Evidencia utilizada:** análisis `03-use-cases.md` y
  `04-business-rules.md`.

## MGR-04. Consumir alcance de servicios

- **Actor:** Jefe de Servicio.
- **Objetivo:** operar únicamente servicios asociados.
- **Escenario:** la jefatura entra a calendario, personal, reportes,
  solicitudes o asignaciones.
- **Precondiciones:** rol `jefe_servicio` y asociaciones activas.
- **Flujo principal:** obtener IDs administrados; limitar consultas y
  operaciones; presentar datos autorizados.
- **Flujos alternativos:** sin asociaciones se muestran resultados vacíos; IDs
  ajenos se rechazan.
- **Postcondiciones:** acceso limitado al alcance persistido.
- **Reglas de negocio relacionadas:** DEC-006, DEC-013 y DEC-014.
- **Módulo:** Jefaturas por Servicio.
- **Evidencia utilizada:** FEAT-017, FEAT-019; análisis `10-flow.md`.

