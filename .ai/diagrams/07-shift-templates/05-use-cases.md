# Casos de Uso - Plantillas de Turno

## SHT-01. Listar plantillas

- **Actor:** Administrador.
- **Objetivo:** consultar plantillas globales y configuraciones por servicio.
- **Escenario:** el Administrador abre uno de los listados del módulo.
- **Precondiciones:** sesión activa y rol `admin`.
- **Flujo principal:** autorizar; consultar registros no eliminados; presentar
  datos y estados.
- **Flujos alternativos:** otros roles no acceden al CRUD.
- **Postcondiciones:** configuración visible sin modificaciones.
- **Reglas de negocio relacionadas:** gestión global exclusiva del
  Administrador.
- **Módulo:** Plantillas de Turno.
- **Evidencia utilizada:** FEAT-006/007; análisis `03-use-cases.md` y
  `05-permissions.md`.

## SHT-02. Crear plantilla global

- **Actor:** Administrador.
- **Objetivo:** definir un turno reutilizable.
- **Escenario:** se registran código, nombre, horarios, color y tipo.
- **Precondiciones:** autorización administrativa.
- **Flujo principal:** validar código y nombre únicos; aceptar intervalo diurno o
  nocturno; crear en transacción; auditar.
- **Flujos alternativos:** duplicidad o datos inválidos impiden guardar.
- **Postcondiciones:** plantilla global disponible.
- **Reglas de negocio relacionadas:** unicidad entre no eliminados; turnos
  nocturnos permitidos.
- **Módulo:** Plantillas de Turno.
- **Evidencia utilizada:** FEAT-006; DEC-011; análisis
  `04-business-rules.md`.

## SHT-03. Editar plantilla global

- **Actor:** Administrador.
- **Objetivo:** actualizar la definición de un turno.
- **Escenario:** se modifican datos de una plantilla existente.
- **Precondiciones:** plantilla no eliminada.
- **Flujo principal:** validar; actualizar en transacción; registrar auditoría.
- **Flujos alternativos:** código/nombre duplicado o datos inválidos conservan la
  versión anterior.
- **Postcondiciones:** plantilla actualizada.
- **Reglas de negocio relacionadas:** unicidad y auditoría.
- **Módulo:** Plantillas de Turno.
- **Evidencia utilizada:** análisis `03-use-cases.md` y
  `07-controllers.md`.

## SHT-04. Cambiar estado o eliminar plantilla

- **Actor:** Administrador.
- **Objetivo:** retirar temporal o lógicamente una plantilla.
- **Escenario:** se activa, desactiva o elimina el registro.
- **Precondiciones:** plantilla existente.
- **Flujo principal:** autorizar; actualizar estado o aplicar SoftDelete en
  transacción; auditar.
- **Flujos alternativos:** el efecto sobre asignaciones existentes permanece
  pendiente de confirmación.
- **Postcondiciones:** estado o `deleted_at` actualizado.
- **Reglas de negocio relacionadas:** SoftDeletes y operaciones auditadas.
- **Módulo:** Plantillas de Turno.
- **Evidencia utilizada:** análisis `04-business-rules.md` y
  `11-pending.md`.

## SST-01. Configurar turno por servicio

- **Actor:** Administrador.
- **Objetivo:** habilitar una plantilla para un servicio.
- **Escenario:** se asocian servicio y plantilla global.
- **Precondiciones:** servicio y plantilla existentes.
- **Flujo principal:** validar asociación; evitar duplicado activo; guardar en
  transacción; auditar.
- **Flujos alternativos:** asociación duplicada o datos inválidos impiden crear.
- **Postcondiciones:** turno disponible en el servicio.
- **Reglas de negocio relacionadas:** nombres oficiales
  `service_shift_templates` y `hospital_service_id`.
- **Módulo:** Plantillas de Turno.
- **Evidencia utilizada:** FEAT-007; análisis `04-business-rules.md`.

## SST-02. Personalizar turno por servicio

- **Actor:** Administrador.
- **Objetivo:** definir código, nombre, horario o color específico.
- **Escenario:** se editan valores opcionales de una configuración.
- **Precondiciones:** configuración por servicio existente.
- **Flujo principal:** validar que inicio y fin personalizados aparezcan juntos;
  aceptar cruce nocturno; guardar y auditar.
- **Flujos alternativos:** una sola hora personalizada se rechaza; valores vacíos
  heredan la plantilla global.
- **Postcondiciones:** personalización persistida o herencia conservada.
- **Reglas de negocio relacionadas:** DEC-011.
- **Módulo:** Plantillas de Turno.
- **Evidencia utilizada:** DEC-011; análisis `04-business-rules.md`.

