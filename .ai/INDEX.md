# Indice del Ecosistema `.ai`

## Naturaleza de este directorio

De acuerdo con DEC-015, `.ai/` es la nueva fuente de verdad del ecosistema de
analisis y documentacion tecnica en proceso de MediTurno. Reune contexto, reglas
copiadas, prompts, plantillas, inventarios, diagramas y reportes sin alterar los
archivos heredados.

Esta migracion sigue siendo transitoria:

- `.ia/` queda como carpeta heredada temporal y conserva los archivos originales
  usados durante la migracion.
- No se debe borrar, mover ni archivar `.ia/` todavia.
- Las copias bajo `.ai/` son la referencia activa para nuevos analisis, pero su
  migracion sigue parcialmente validada y pueden contener referencias heredadas.
- `docs/decisions.md` sigue siendo obligatorio para decisiones de alcance,
  arquitectura, datos o reglas de negocio.

## Ecosistemas documentales

| Ubicacion | Funcion |
|---|---|
| `.ai/` | Nueva fuente de verdad para analisis, reglas copiadas, prompts, plantillas, reportes, diagramas y documentacion tecnica en proceso |
| `.codex/` | Skills y workflows propios de Codex; estaba vacio en el inventario inicial |
| `docs/` | Documentacion final entregable, QA, despliegue, demo y decisiones |
| `.ia/` | Carpeta heredada temporal; no debe eliminarse sin validacion y aprobacion humana |
| `.commandcode/` | Origen documentado de skills externas o heredadas |

## Documentos principales

| Documento | Proposito |
|---|---|
| [`PROJECT_CHARTER.md`](PROJECT_CHARTER.md) | Alcance, gobierno y restricciones del ecosistema |
| [`PROJECT_CONTEXT.md`](PROJECT_CONTEXT.md) | Contexto sintetico y estado observado de MediTurno |
| [`ROADMAP.md`](ROADMAP.md) | Secuencia de trabajo documental, no roadmap del producto |
| [`analysis/00-project-inventory.md`](analysis/00-project-inventory.md) | Inventario tecnico y documental inicial |
| [`analysis/01-existing-documentation-map.md`](analysis/01-existing-documentation-map.md) | Mapa y evaluacion preliminar de documentos existentes |
| [`reports/00-reorganization-plan.md`](reports/00-reorganization-plan.md) | Plan seguro de reorganizacion pendiente de aprobacion |
| [`reports/01-copy-migration-map.md`](reports/01-copy-migration-map.md) | Registro de origen, destino y estado de cada copia |
| [`reports/02-document-conflicts.md`](reports/02-document-conflicts.md) | Conflictos y desfases documentales sin resolver |
| [`reports/03-legacy-ia-retirement-plan.md`](reports/03-legacy-ia-retirement-plan.md) | Condiciones para un retiro futuro y seguro de `.ia/` |
| [`reports/04-migration-verification-report.md`](reports/04-migration-verification-report.md) | Verificacion BDS del cierre documental |
| [`reports/05-knowledge-base-core-report.md`](reports/05-knowledge-base-core-report.md) | Resultado de la definicion del Knowledge Base Core |

## BDS Core

El BDS Core contiene contratos reutilizables para preservar y consumir
conocimiento antes de crear roles especializados. No contiene documentacion de
MediTurno.

### Knowledge Base Core

Ubicacion: [`core/knowledge-base/`](core/knowledge-base/README.md)

| Documento | Proposito |
|---|---|
| [`KB_CHARTER.md`](core/knowledge-base/KB_CHARTER.md) | Definicion, autoridad, limites y relacion con roles |
| [`KB_SCHEMA.md`](core/knowledge-base/KB_SCHEMA.md) | Esquema minimo de la futura Knowledge Base |
| [`KB_RULES.md`](core/knowledge-base/KB_RULES.md) | Evidencia, estados, contradicciones y trazabilidad |
| [`KB_LIFECYCLE.md`](core/knowledge-base/KB_LIFECYCLE.md) | Ciclo de captura, validacion, consumo y archivo |

El Core especifica la futura ruta `.ai/knowledge-base/`, pero no la crea todavia.
Knowledge Archivist tampoco se crea en esta fase.

## Copias heredadas de reglas

| Documento | Origen registrado |
|---|---|
| [`rules/architecture.md`](rules/architecture.md) | `.ia/architecture.md` |
| [`rules/business-rules.md`](rules/business-rules.md) | `.ia/business-rules.md` |
| [`rules/database-design.md`](rules/database-design.md) | `.ia/database-design.md` |
| [`rules/database.md`](rules/database.md) | `.ia/skill/database.md` |
| [`rules/security.md`](rules/security.md) | `.ia/skill/security.md` |
| [`rules/crud.md`](rules/crud.md) | `.ia/skill/crud.md` |
| [`rules/git.md`](rules/git.md) | `.ia/skill/git.md` |
| [`rules/planning.md`](rules/planning.md) | `.ia/skill/planning.md` |
| [`rules/documentation.md`](rules/documentation.md) | `.ia/skill/documentation.md` |

## Workflow y proyecto

| Documento | Origen registrado |
|---|---|
| [`workflows/workflow.md`](workflows/workflow.md) | `.ia/workflow.md` |
| [`project/project-grade.md`](project/project-grade.md) | `.ia/project-grade.md` |
| [`project/roadmap.md`](project/roadmap.md) | `.ia/roadmap.md` |
| [`project/backlog.md`](project/backlog.md) | `.ia/backlog.md` |

## Indice de skills externas

- [`skills-index/frontend-design.md`](skills-index/frontend-design.md): resumen de
  `.commandcode/skills/frontend-design/SKILL.md`.
- [`skills-index/system-analyst.md`](skills-index/system-analyst.md): referencia
  preservada de `.ia/skill/system-analyst/SKILL.md`; no se encontro copia en
  `.codex/`.

## Plantillas

- [`templates/module-template.md`](templates/module-template.md)
- [`templates/sprint-template.md`](templates/sprint-template.md)
- [`templates/actor-flow-template.md`](templates/actor-flow-template.md)
- [`templates/traceability-matrix-template.md`](templates/traceability-matrix-template.md)

## Prompt de analisis

- [`prompts/analyst.md`](prompts/analyst.md)

## Directorios reservados

| Directorio | Uso futuro |
|---|---|
| `analysis/sprints/` | Reconstruccion documentada de Sprints 1 a 12 |
| `analysis/modules/` | Analisis funcional y tecnico por modulo |
| `analysis/system-overview/` | Actores, arquitectura y trazabilidad global |
| `diagrams/mermaid/` | Fuentes Mermaid editables |
| `diagrams/plantuml/` | Fuentes PlantUML editables |
| `reports/` | Hallazgos, revisiones y propuestas |

## Estados de evidencia

- `CONFIRMADO`: respaldado por codigo o documento oficial.
- `INFERIDO`: conclusion razonable que requiere validacion.
- `PENDIENTE`: no existe evidencia suficiente.
- `INCONSISTENTE`: las fuentes disponibles se contradicen.

## Fuentes originales

- [`.ia/`](../.ia/)
- [`docs/`](../docs/)
- [`README.md`](../README.md)
- [`CLAUDE.md`](../CLAUDE.md)
- [`docs/decisions.md`](../docs/decisions.md)

## Estado de la migracion

DEC-015 formaliza `.ai/` como nueva fuente de verdad del ecosistema de analisis.
La cobertura documental necesaria para iniciar Knowledge Base esta completa:
13 archivos de `.ia/` fueron copiados y la skill `system-analyst` fue preservada
como referencia verificable. La limpieza final y el retiro de `.ia/` siguen
pendientes. El detalle de fuentes, destinos y verificaciones esta en
[`reports/01-copy-migration-map.md`](reports/01-copy-migration-map.md).

Plan de retiro seguro de la carpeta heredada:
[`reports/03-legacy-ia-retirement-plan.md`](reports/03-legacy-ia-retirement-plan.md).

Verificacion de cierre documental:
[`reports/04-migration-verification-report.md`](reports/04-migration-verification-report.md).
