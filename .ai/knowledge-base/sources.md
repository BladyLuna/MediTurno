# Sources Registry

## Convencion

El estado confirma la existencia y disponibilidad de la fuente, no que todas sus
afirmaciones sean correctas entre si.

| ID | Fuente | Tipo | Alcance preservado | Autoridad o uso | Estado |
|---|---|---|---|---|---|
| SRC-001 | [`../../README.md`](../../README.md) | Documento raiz | Estado declarado del producto, stack, demo, rutas y advisories | Resumen operativo; presenta desfases conocidos | `CONFIRMED` |
| SRC-002 | [`../../docs/decisions.md`](../../docs/decisions.md) | Registro de decisiones | DEC-001 a DEC-015 | Fuente formal de decisiones | `CONFIRMED` |
| SRC-003 | [`../PROJECT_CHARTER.md`](../PROJECT_CHARTER.md) | Charter | Gobierno del ecosistema `.ai` y BDS Core | Autoridad del ecosistema de analisis | `CONFIRMED` |
| SRC-004 | [`../PROJECT_CONTEXT.md`](../PROJECT_CONTEXT.md) | Contexto | Resumen, actores, modulos, arquitectura y pendientes | Vista sintetica derivada | `CONFIRMED` |
| SRC-005 | [`../project/roadmap.md`](../project/roadmap.md) | Roadmap heredado | Clasificacion y Sprints 1 a 10 | Plan historico del MVP | `CONFIRMED` |
| SRC-006 | [`../project/backlog.md`](../project/backlog.md) | Backlog heredado | Historias MVP, opcionales y Post-MVP | Alcance planificado | `CONFIRMED` |
| SRC-007 | [`../rules/business-rules.md`](../rules/business-rules.md) | Reglas copiadas | BR-001 a BR-017 | Regla heredada; contiene conflicto documentado | `CONFIRMED` |
| SRC-008 | [`../rules/database-design.md`](../rules/database-design.md) | Diseño de datos copiado | Entidades, campos, estados e indices | Referencia de modelo documental | `CONFIRMED` |
| SRC-009 | [`../rules/architecture.md`](../rules/architecture.md) | Arquitectura copiada | Capas, transacciones, auditoria y alcance | Referencia heredada; contiene artefacto conocido | `CONFIRMED` |
| SRC-010 | [`../reports/02-document-conflicts.md`](../reports/02-document-conflicts.md) | Reporte | DOC-001 a DOC-015 | Registro de contradicciones sin resolver | `CONFIRMED` |
| SRC-011 | [`../reports/04-migration-verification-report.md`](../reports/04-migration-verification-report.md) | Reporte BDS | Cierre documental y preservacion de `.ia/` | Evidencia de migracion | `CONFIRMED` |
| SRC-012 | [`../reports/05-knowledge-base-core-report.md`](../reports/05-knowledge-base-core-report.md) | Reporte BDS | Definicion del Knowledge Base Core | Evidencia de preparacion BDS | `CONFIRMED` |
| SRC-013 | [`../core/knowledge-base/KB_CHARTER.md`](../core/knowledge-base/KB_CHARTER.md) | Charter BDS | Definicion y gobierno de la KB | Contrato de esta instancia | `CONFIRMED` |
| SRC-014 | [`../core/knowledge-base/KB_SCHEMA.md`](../core/knowledge-base/KB_SCHEMA.md) | Esquema BDS | Archivos y responsabilidades minimas | Contrato estructural | `CONFIRMED` |
| SRC-015 | [`../core/knowledge-base/KB_RULES.md`](../core/knowledge-base/KB_RULES.md) | Reglas BDS | Evidencia, estados y trazabilidad | Contrato de preservacion | `CONFIRMED` |
| SRC-016 | [`../core/knowledge-base/KB_LIFECYCLE.md`](../core/knowledge-base/KB_LIFECYCLE.md) | Ciclo BDS | Captura, validacion, consumo y archivo | Contrato de ciclo de vida | `CONFIRMED` |
| SRC-017 | [`../../docs/qa-checklist.md`](../../docs/qa-checklist.md) | Checklist | QA manual por rol, seguridad y dependencias | Evidencia de alcance de cierre hasta MVP | `CONFIRMED` |
| SRC-018 | [`../../docs/demo-flow.md`](../../docs/demo-flow.md) | Guia | Flujo de defensa y demostracion | Evidencia de recorrido demo | `CONFIRMED` |
| SRC-019 | [`../../docs/deploy.md`](../../docs/deploy.md) | Guia | Preparacion de despliegue y seguridad | Requiere validar plataforma y vigencia | `CONFIRMED` |
| SRC-020 | [`../../CLAUDE.md`](../../CLAUDE.md) | Contexto de herramienta | Stack, planes, estructura y reglas historicas | Fuente con contradicciones documentadas | `CONFIRMED` |
| SRC-021 | [`../../routes/web.php`](../../routes/web.php) | Codigo usado como evidencia | Superficies web y restricciones de acceso | Evidencia tecnica; no modificada | `CONFIRMED` |
| SRC-022 | [`../../composer.json`](../../composer.json) | Manifiesto | Dependencias PHP declaradas | Evidencia tecnica | `CONFIRMED` |
| SRC-023 | [`../../package.json`](../../package.json) | Manifiesto | Dependencias frontend declaradas | Evidencia tecnica | `CONFIRMED` |
| SRC-024 | Historial disponible de esta sesion Codex | Conversacion | Prompts, secuencia de trabajo y restricciones | Fuente temporal preservada en `important-prompts.md` | `CONFIRMED` |
| SRC-025 | `../../Requerimientos para sistema web.pdf` | PDF, version 1.4, 8 paginas | Contenido no revisado | Fuente potencial de requerimientos | `PENDING CONFIRMATION` |
| SRC-026 | `../../docs/MediTurno_Entrevista_Bladimir_Luna.docx` | Microsoft Word 2007+ | Contenido no revisado | Fuente potencial de levantamiento | `PENDING CONFIRMATION` |
| SRC-027 | [`../reports/01-copy-migration-map.md`](../reports/01-copy-migration-map.md) | Reporte | Origen, destino y estado de copias | Evidencia de procedencia documental | `CONFIRMED` |
| SRC-028 | [`../reports/03-legacy-ia-retirement-plan.md`](../reports/03-legacy-ia-retirement-plan.md) | Plan | Riesgos y condiciones para retirar `.ia/` | Fuente de pendientes de migracion | `CONFIRMED` |

## Limites

- El contenido del PDF y DOCX no fue extraido ni validado.
- El historial de conversacion no tiene identificadores persistentes fuera de esta
  captura.
- El codigo se usa solo como evidencia, no como objeto de modificacion o analisis
  funcional en esta tarea.

