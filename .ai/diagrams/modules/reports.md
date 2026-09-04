# Reports

- Propósito: Representar reportes por servicio o por empleado con exportacion HTML, CSV y PDF.
- Actores: `admin`, `jefe_servicio`.
- Evidencia usada: .ai/knowledge-base/features.md (FEAT-011, FEAT-012, FEAT-013, FEAT-017), .ai/analysis/modules/reports/02-actors.md, .ai/analysis/modules/reports/03-use-cases.md, .ai/analysis/modules/reports/06-routes.md.
- Módulos relacionados: shift-assignments, staff, hospital-services, shift-templates
- Casos de uso: Filter date/service/staff/grouping; view summary/detail; export CSV or PDF
- Diagramas exportados:
  - Casos de uso Mermaid: [`../mermaid/modules/reports.mmd`](../mermaid/modules/reports.mmd)
  - Casos de uso PlantUML: [`../plantuml/modules/reports.puml`](../plantuml/modules/reports.puml)
  - Actividad Mermaid: [`../mermaid/modules/reports-activity.mmd`](../mermaid/modules/reports-activity.mmd)
  - Actividad PlantUML: [`../plantuml/modules/reports-activity.puml`](../plantuml/modules/reports-activity.puml)
  - Secuencia Mermaid: [`../mermaid/modules/reports-sequence.mmd`](../mermaid/modules/reports-sequence.mmd)
  - Secuencia PlantUML: [`../plantuml/modules/reports-sequence.puml`](../plantuml/modules/reports-sequence.puml)
- Estado: no aplica. El reporte es de solo lectura y no modela estados internos.
