# Context Transfer Oficial - MediTurno

Fecha de corte: **2026-07-02**.

Este documento puede copiarse a otra conversación para continuar MediTurno sin
leer el historial completo. Resume únicamente conocimiento ya validado. Las
contradicciones no están resueltas y deben conservarse como pendientes.

## 1. Resumen ejecutivo

MediTurno es un sistema web de gestión de turnos hospitalarios desarrollado como
proyecto de grado. Sustituye la gestión manual mediante hojas de cálculo por una
aplicación con autenticación, roles, servicios, personal, plantillas de turno,
asignaciones, validación de traslapes, calendario, reportes, solicitudes de
cambio, notificaciones y auditoría.

El estado funcional documentado corresponde al MVP cerrado más las ampliaciones
de Versión 2 y Versión 3, hasta Sprint 12. No existe una etiqueta semántica de
release confirmada. La operatividad actual requiere nueva evidencia de QA.

## 2. Estado del proyecto

- 21 funcionalidades están declaradas como implementadas y activas.
- 4 funcionalidades permanecen Post-MVP: ausencias, vacaciones, notificaciones
  externas y estadísticas avanzadas.
- Existen datos demo y flujo de defensa documentados.
- El análisis funcional de 12 módulos está completo.
- La representación gráfica está cerrada.
- El diseño académico de seguridad está completo con cobertura estimada del
  96 %, sin equivaler a certificación productiva.
- `.ai/` es la fuente de verdad del ecosistema de análisis.
- `.ia/` es legado temporal y no debe eliminarse.

## 3. Arquitectura

| Área | Definición confirmada |
|---|---|
| Backend | PHP 8.2 y Laravel 10 |
| Frontend | Blade, Bootstrap 5, Vite y FullCalendar |
| Base de datos | MySQL 8 mediante Eloquent y migraciones |
| Autenticación | Sesión web nativa de Laravel |
| Autorización | `users.role`, middleware, Policies y filtros backend |
| Infraestructura local | Docker Compose, PHP-FPM, Nginx y MySQL |
| Reportes | HTML, CSV y PDF básico |

Servicios de dominio documentados: autenticación, auditoría, cálculo horario,
conflictos, calendario, reportes, alcance por usuario, disponibilidad,
solicitudes de cambio y notificaciones.

Entidades principales: `User`, `HospitalService`, `Staff`, `ServiceManager`,
`ShiftTemplate`, `ServiceShiftTemplate`, `ShiftAssignment`,
`ShiftChangeRequest`, `InternalNotification` y `AuditLog`.

## 4. Módulos

1. Autenticación y dashboard.
2. Usuarios y control de estado.
3. Servicios hospitalarios.
4. Personal de salud.
5. Jefaturas por servicio.
6. Plantillas globales y turnos por servicio.
7. Asignaciones y disponibilidad.
8. Calendario global, por servicio y personal.
9. Reportes y exportaciones HTML, CSV y PDF.
10. Solicitudes de cambio de turno.
11. Notificaciones internas.
12. Auditoría.

Cada módulo tiene resumen, actores, casos de uso, reglas, permisos, rutas,
controladores, modelos, base de datos, flujo y pendientes en
`.ai/analysis/modules/`.

## 5. Actores

| Actor | Responsabilidad |
|---|---|
| Invitado | Iniciar sesión |
| Administrador | Administración global; calendario y reportes globales; auditoría |
| Jefe de Servicio | Operar y consultar únicamente servicios asociados mediante `service_managers` |
| Personal de Salud | Consultar turnos propios y gestionar solicitudes y notificaciones propias mediante `staff.user_id` |

## 6. Decisiones importantes

- **DEC-001:** roles en `users.role`; no usar paquete externo de permisos.
- **DEC-003:** no se permiten turnos traslapados.
- **DEC-004:** los turnos nocturnos terminan en la fecha siguiente.
- **DEC-005:** usar `hospital_service_id`.
- **DEC-006:** un jefe puede administrar múltiples servicios.
- **DEC-007:** calendario mediante recarga/consulta, sin WebSockets.
- **DEC-008:** estados controlados para asignaciones y solicitudes.
- **DEC-009:** proteger el último admin activo y prohibir
  auto-desactivación/eliminación.
- **DEC-010:** `staff.user_id` solo puede asociar usuarios `personal`.
- **DEC-011:** horas personalizadas se definen juntas y pueden cruzar medianoche.
- **DEC-012:** cancelar asignación, aplicar SoftDelete y auditar.
- **DEC-013:** vistas y consultas limitadas por rol, servicio o personal.
- **DEC-014:** jefatura opera asignaciones solo dentro de servicios asociados,
  con transacciones y auditoría.
- **DEC-015:** `.ai/` es la fuente de verdad del análisis; `.ia/` queda como
  legado temporal.

Toda decisión nueva de alcance, arquitectura, datos o reglas debe agregarse al
final de `docs/decisions.md`.

## 7. Reglas esenciales

- Turnos consecutivos están permitidos cuando el fin de uno coincide con el
  inicio del siguiente.
- Personal, servicio y turno por servicio deben corresponder y estar activos al
  crear asignaciones.
- Jefatura no puede forzar IDs fuera de su alcance.
- Jefatura no puede editar o cancelar asignaciones canceladas o eliminadas
  lógicamente.
- Las operaciones críticas son transaccionales y auditadas.
- Las solicitudes se aprueban o rechazan administrativamente y, según README,
  demo y QA, no modifican automáticamente la asignación. Existe una regla
  heredada contradictoria; no resolver sin decisión formal.

## 8. Estado de BDS

- Knowledge Base operativa en `.ai/knowledge-base/`.
- DEC-001 a DEC-015 preservadas.
- 28 fuentes registradas en la captura inicial.
- 15 contradicciones y 15 vacíos de conocimiento preservados.
- Análisis modular completo en `.ai/analysis/`.
- Diagramas cerrados en `.ai/diagrams/`.
- Reportes BDS disponibles hasta
  `.ai/reports/08-information-security-review.md`.
- La migración documental permite usar `.ai/`, pero no autoriza eliminar
  `.ia/`.

## 9. Documentos generados

### Fuentes de continuidad

- `.ai/PROJECT_CONTEXT.md`
- `.ai/PROJECT_CHARTER.md`
- `.ai/knowledge-base/`
- `docs/decisions.md`
- `README.md`

### Análisis y gráficos

- `.ai/analysis/modules/`
- `.ai/analysis/system-overview/class-traceability.md`
- `.ai/diagrams/general/`
- `.ai/diagrams/modules/`
- `.ai/reports/06-system-analysis-audit.md`
- `.ai/reports/07-diagram-delivery-report.md`

### Seguridad

- `docs/security/01-information-security-design.md`
- `docs/security/02-risk-matrix.md`
- `docs/security/03-cia-analysis.md`
- `docs/security/04-security-controls.md`
- `docs/security/05-annexes.md`
- `.ai/reports/08-information-security-review.md`

## 10. Riesgos abiertos

1. Estado actual de advisories de Laravel y Vite/esbuild.
2. Ausencia de evidencia confirmada de backups y restauración.
3. MFA y rate limiting del login no confirmados.
4. Monitoreo, RTO/RPO y respuesta a incidentes no confirmados.
5. Retención e inmutabilidad de auditoría no definidas.
6. Exportaciones fuera del control del sistema después de descargarse.
7. Operatividad actual de las funcionalidades pendiente de QA nuevo.
8. Divergencia futura entre documentos copiados y fuentes heredadas.

## 11. Contradicciones

Las 15 contradicciones completas están en
`.ai/knowledge-base/problems.md`. Las prioritarias para continuidad son:

- **CONFLICT-002:** roadmap/backlog terminan en Sprint 10, aunque DEC-013/014
  documentan Versiones 2 y 3.
- **CONFLICT-003:** README subrepresenta el alcance de jefatura.
- **CONFLICT-004:** discrepancia sobre si aprobar una solicitud modifica la
  asignación.
- **CONFLICT-008:** CI/CD y plataformas de despliegue históricas no confirmadas.
- **CONFLICT-011:** QA y demo no cubren toda la operación de jefatura.
- **CONFLICT-012:** no hay sincronización automática de copias documentales.

No resolver ninguna contradicción por inferencia.

## 12. Recomendaciones

- Antes de ampliar el producto, ejecutar QA actual y preservar resultados.
- Resolver CONFLICT-003 y CONFLICT-004 mediante decisión formal.
- Actualizar roadmap/backlog y documentos de defensa si el usuario lo autoriza.
- Verificar advisories con auditorías actuales y aplicar solo actualizaciones
  dirigidas.
- Completar controles operativos mínimos antes de usar datos reales.
- Mantener `.ia/` intacta hasta cumplir su plan de retiro y obtener aprobación.
- No repetir Knowledge Base, análisis modular, diagramas ni revisión de
  seguridad sin evidencia nueva.

## 13. Siguiente objetivo

El siguiente objetivo recomendado es **validar el estado operativo y académico
actual**:

1. ejecutar QA y pruebas con fecha;
2. registrar la evidencia;
3. resolver las contradicciones prioritarias;
4. alinear README, roadmap, backlog, QA y demo con DEC-013/014;
5. cerrar los pendientes mínimos de seguridad para el contexto de entrega.

La siguiente IA debe confirmar con el usuario qué parte de este objetivo está
autorizada antes de modificar archivos o código.

