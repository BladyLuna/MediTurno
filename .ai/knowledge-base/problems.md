# Problems and Contradictions Registry

## Problemas con respuesta documentada

| ID | Problema preservado | Respuesta o solucion registrada | Fuente | Estado | Vigencia |
|---|---|---|---|---|---|
| PROB-001 | Gestion manual de turnos mediante hojas de calculo | MediTurno se presenta como reemplazo web con roles, asignaciones, calendario y reportes | SRC-001 | `CONFIRMED` | `ACTIVE` |
| PROB-002 | Asignaciones horarias incompatibles | Prohibir traslapes y validar intervalos `start_at`/`end_at` | SRC-002 DEC-003 | `CONFIRMED` | `ACTIVE` |
| PROB-003 | Turnos que cruzan medianoche | Guardar `end_at` en la fecha siguiente | SRC-002 DEC-004 | `CONFIRMED` | `ACTIVE` |
| PROB-004 | Riesgo de dejar el sistema sin administrador activo | Proteger ultimo admin y prohibir auto-desactivacion/eliminacion | SRC-002 DEC-009 | `CONFIRMED` | `ACTIVE` |
| PROB-005 | Configuracion parcial de horas personalizadas | Exigir ambas horas y permitir cruce nocturno | SRC-002 DEC-011 | `CONFIRMED` | `ACTIVE` |
| PROB-006 | Perdida de trazabilidad al eliminar asignaciones | Cambiar a `cancelled`, aplicar SoftDelete y auditar | SRC-002 DEC-012 | `CONFIRMED` | `ACTIVE` |
| PROB-007 | Acceso de jefatura fuera de su servicio | Aplicar alcance obligatorio mediante `service_managers` | SRC-002 DEC-013 y DEC-014 | `CONFIRMED` | `ACTIVE` |
| PROB-008 | Documentacion dispersa y riesgo de divergencia | Consolidar analisis en `.ai/` y conservar `.ia/` temporalmente | SRC-002 DEC-015 | `CONFIRMED` | `ACTIVE`; limpieza pendiente |
| PROB-009 | Dos archivos de `.ia/` pendientes de preservacion | Copiar `database.md` y registrar `system-analyst` con checksum | SRC-011 | `CONFIRMED` | `ACTIVE`; retiro de `.ia/` no autorizado |

## Contradicciones preservadas

Estas entradas no se resuelven en la Knowledge Base.

| ID | Informacion A | Informacion B | Posible conflicto | Evidencia | Estado |
|---|---|---|---|---|---|
| CONFLICT-001 | DEC-015 establece `.ai/` como fuente de verdad del analisis | Copias heredadas aun contienen referencias a `.ia/` | Gobierno definido, referencias no normalizadas | SRC-002, SRC-010 DOC-001 | `PENDING CONFIRMATION` |
| CONFLICT-002 | Roadmap y backlog terminan en Sprint 10 | DEC-013 y DEC-014 describen Version 2 y Version 3 | Historia documental incompleta | SRC-005, SRC-006, SRC-002, SRC-010 DOC-002 | `PENDING CONFIRMATION` |
| CONFLICT-003 | README limita al jefe principalmente a revision de solicitudes | DEC-013/014 permiten calendario, reportes y operacion de asignaciones | Capacidades del rol descritas de forma incompatible | SRC-001, SRC-002, SRC-010 DOC-003 | `PENDING CONFIRMATION` |
| CONFLICT-004 | BR-010 ejemplifica aprobar solicitud y actualizar asignacion | README, demo y QA indican que aprobar no modifica asignaciones automaticamente | Comportamiento operativo incompatible | SRC-007, SRC-001, SRC-017, SRC-018, SRC-010 DOC-004 | `PENDING CONFIRMATION` |
| CONFLICT-005 | CLAUDE usa rutas `/admin/services`, `/admin/shifts`, `/admin/assignments`, `/calendar`, `/admin/config` | README y rutas observadas usan nombres distintos | Rutas historicas frente a rutas actuales | SRC-020, SRC-001, SRC-021, SRC-010 DOC-005 | `PENDING CONFIRMATION` |
| CONFLICT-006 | CLAUDE prescribe FullCalendar por CDN | README y dependencias declaran Vite | Integracion frontend incompatible | SRC-020, SRC-001, SRC-023, SRC-010 DOC-006 | `PENDING CONFIRMATION` |
| CONFLICT-007 | CLAUDE plantea Excel con Maatwebsite | README declara CSV/PDF y Composer no declara ese paquete | Alcance de exportacion incompatible | SRC-020, SRC-001, SRC-022, SRC-010 DOC-007 | `PENDING CONFIRMATION` |
| CONFLICT-008 | CLAUDE declara GitHub Actions, Render y GitHub Pages | El inventario no encontro workflow ni landing | Estado de despliegue no confirmado | SRC-020, SRC-010 DOC-008 | `PENDING CONFIRMATION` |
| CONFLICT-009 | CLAUDE describe `audit_logs.model` y timestamps | Diseño de datos usa `model_type` y solo `created_at` | Modelo de auditoria incompatible | SRC-020, SRC-008, SRC-010 DOC-009 | `PENDING CONFIRMATION` |
| CONFLICT-010 | CLAUDE define `docs/` como landing page | `docs/` contiene decisiones, QA, demo, deploy y entrevista | Proposito del directorio incompatible | SRC-020, SRC-010 DOC-010 | `PENDING CONFIRMATION` |
| CONFLICT-011 | Demo y QA cubren revision de solicitudes por jefe | DEC-014 agrega gestion operativa y disponibilidad no cubierta | Cobertura de defensa y QA incompleta | SRC-017, SRC-018, SRC-002, SRC-010 DOC-011 | `PENDING CONFIRMATION` |
| CONFLICT-012 | Copias `.ai` fueron verificadas iguales a `.ia` | No existe sincronizacion automatica | Riesgo futuro de divergencia | SRC-011, SRC-027, SRC-010 DOC-012 | `PENDING CONFIRMATION` |
| CONFLICT-013 | `architecture.md` debe ser documento estructurado | Contiene una linea aislada `++` | Posible artefacto de edicion | SRC-009, SRC-010 DOC-013 | `PENDING CONFIRMATION` |
| CONFLICT-014 | Regla documental menciona actualizar `CHANGELOG` | No se detecto `CHANGELOG.md` | Workflow refiere un artefacto ausente | SRC-010 DOC-014 | `PENDING CONFIRMATION` |
| CONFLICT-015 | `project-grade.md` representa estructura academica | Solo contiene una lista breve de capitulos y conceptos | Documento incompleto | SRC-010 DOC-015 | `PENDING CONFIRMATION` |

## Riesgos de dependencias pendientes

| ID | Informacion preservada | Fuente | Estado |
|---|---|---|---|
| RISK-DEP-001 | README registra advisory `CVE-2026-48019` para Laravel 10.50.2 | SRC-001 | `PENDING CONFIRMATION`: no se ejecuto auditoria actual |
| RISK-DEP-002 | README registra vulnerabilidad moderada de `esbuild <=0.24.2` via Vite | SRC-001 | `PENDING CONFIRMATION`: no se ejecuto auditoria actual |

