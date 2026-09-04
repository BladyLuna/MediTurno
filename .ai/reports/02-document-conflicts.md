# Conflictos y Desfases Documentales

Fecha de corte: 2026-06-19.

## Criterio

Este reporte registra diferencias detectadas entre `README.md`, `CLAUDE.md`,
`.ia/*`, `.ai/*` y `docs/*`. No resuelve conflictos ni modifica fuentes.

Estados usados:

- `CONFLICTO`: dos fuentes expresan comportamientos incompatibles.
- `DESFASE`: una fuente refleja una etapa anterior o informacion incompleta.
- `NO CONFIRMADO`: la afirmacion no tiene evidencia suficiente en el repositorio.
- `RIESGO DE DIVERGENCIA`: copias actualmente iguales que pueden separarse.
- `ARTEFACTO`: posible error de formato que requiere revision.

## Conflictos detectados

| ID | Fuentes | Conflicto o diferencia | Estado | Impacto | Accion pendiente |
|---|---|---|---|---|---|
| DOC-001 | DEC-002, DEC-015, `.ia/architecture.md`, `.ai/INDEX.md` | DEC-015 establece `.ai/` como nueva fuente de verdad del analisis y deja `.ia/` como legado; los archivos copiados aun contienen referencias internas a DEC-002 y `.ia/` | RESUELTO EN DECISION / IMPLEMENTACION PENDIENTE | La autoridad fue definida, pero falta normalizar referencias heredadas | Aplicar DEC-015 y mantener `.ia/` hasta completar validacion y limpieza |
| DOC-002 | `.ia/roadmap.md`, `.ia/backlog.md`, DEC-013 y DEC-014 | Roadmap y backlog terminan en Sprint 10, pero decisiones posteriores describen Sprints 11 y 12 | DESFASE | La historia del producto queda incompleta | Decidir si actualizar originales o documentar extensiones por separado |
| DOC-003 | `README.md`, DEC-013, DEC-014, `CLAUDE.md` | README limita al jefe principalmente a revision de solicitudes; decisiones posteriores permiten calendario, reportes y gestion operativa de asignaciones | CONFLICTO/DESFASE | Descripcion incorrecta de capacidades por rol | Validar matriz definitiva de permisos y actualizar documentos finales despues |
| DOC-004 | `.ia/business-rules.md` BR-010, `README.md`, `docs/demo-flow.md`, `docs/qa-checklist.md` | BR-010 usa como ejemplo aprobar una solicitud y actualizar la asignacion; los otros documentos indican que la aprobacion no modifica asignaciones automaticamente | CONFLICTO CRITICO | Afecta regla operativa y trazabilidad | Registrar decision explicita o corregir fuente oficial tras aprobacion humana |
| DOC-005 | `CLAUDE.md`, `README.md`, rutas observadas | CLAUDE usa rutas historicas como `/admin/services`, `/admin/shifts`, `/admin/assignments`, `/calendar` y `/admin/config`; README y el sistema usan otros nombres | DESFASE | Puede inducir implementacion o pruebas sobre rutas inexistentes | Generar inventario de rutas y corregir CLAUDE posteriormente |
| DOC-006 | `CLAUDE.md`, `README.md`, dependencias observadas | CLAUDE prescribe FullCalendar mediante CDN; el proyecto documenta e implementa integracion mediante Vite | CONFLICTO TECNICO | Instrucciones de frontend incompatibles | Mantener Vite como evidencia actual y revisar CLAUDE |
| DOC-007 | `CLAUDE.md`, `README.md`, `composer.json` | CLAUDE plantea Excel con Maatwebsite; README declara HTML, CSV y PDF y el paquete Excel no esta instalado | CONFLICTO DE ALCANCE | Sugiere una funcionalidad no implementada | Confirmar si Excel sigue fuera de alcance |
| DOC-008 | `CLAUDE.md`, estructura del repositorio, `docs/` | CLAUDE declara GitHub Actions, Render y landing en GitHub Pages; no se encontro workflow ni landing en la estructura revisada | NO CONFIRMADO | Puede presentar como entregado algo inexistente | Validar infraestructura externa y corregir estado documental |
| DOC-009 | `CLAUDE.md`, `.ia/database-design.md`, `.ai/rules/database-design.md` | CLAUDE describe `audit_logs.model` y timestamps; el diseno oficial usa `model_type` y solo `created_at` | CONFLICTO DE MODELO | Riesgo de diagramas y consultas incorrectas | Usar diseno oficial mientras se revisa CLAUDE |
| DOC-010 | `CLAUDE.md`, `docs/` | CLAUDE define `docs/` como landing page; actualmente contiene decisiones, QA, demo, deploy y una entrevista | CONFLICTO DE PROPOSITO | Confunde documentacion entregable con hosting estatico | Definir proposito oficial de `docs/` antes de reorganizar |
| DOC-011 | `docs/demo-flow.md`, `docs/qa-checklist.md`, DEC-014 | Demo y QA cubren revision de solicitudes del jefe, pero no toda la operacion de asignaciones y disponibilidad agregada despues | DESFASE | Defensa y QA no cubren el alcance real | Ampliar solo tras validar Sprints 11 y 12 |
| DOC-012 | `.ia/*`, copias `.ai/rules/*`, `.ai/project/*` | Las copias son iguales al momento de migracion, pero no existe sincronizacion automatica | RIESGO DE DIVERGENCIA | Pueden aparecer dos versiones distintas de una regla | Definir autoridad, version y proceso de sincronizacion antes de archivar `.ia/` |
| DOC-013 | `.ia/architecture.md`, `.ai/rules/architecture.md` | Existe una linea `++` antes de `Capas Recomendadas` | ARTEFACTO | Puede ser error accidental de formato heredado | Revisar el original; no corregir durante esta fase |
| DOC-014 | `.ia/skill/documentation.md`, repositorio | La regla menciona actualizar `CHANGELOG`, pero no se detecto `CHANGELOG.md` | NO CONFIRMADO | Workflow documental incompleto | Decidir si crear CHANGELOG o ajustar la regla |
| DOC-015 | `.ia/project-grade.md`, objetivos academicos | El archivo contiene solo una lista de capitulos y conceptos | DESFASE/INCOMPLETO | No sirve aun como estructura academica desarrollada | Requiere elaboracion y revision del responsable academico |

## Prioridad de revision humana

1. DOC-004: comportamiento de solicitudes aprobadas.
2. DOC-001: completar la implementacion documental de DEC-015.
3. DOC-003: permisos reales de jefatura.
4. DOC-009: modelo de auditoria.
5. DOC-005 a DOC-008: instrucciones tecnicas y estado de despliegue.
6. DOC-002 y DOC-011: historia de Sprints 11 y 12.

## Regla temporal

Durante la transicion definida por DEC-015:

- No borrar `.ia/`.
- Usar `.ai/` como fuente de verdad para nuevos analisis y documentacion tecnica
  en proceso.
- Conservar `.ia/` como referencia heredada hasta validar todas las copias.
- No corregir documentos originales desde este reporte.
- Registrar cualquier decision de alcance, arquitectura, datos o negocio en
  `docs/decisions.md`.
