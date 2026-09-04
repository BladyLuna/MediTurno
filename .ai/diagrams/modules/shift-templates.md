# Shift Templates

- Propósito: Representar la gestion de plantillas globales de turno y su activacion por servicio.
- Actores: `admin`, `jefe_servicio`.
- Evidencia usada: .ai/knowledge-base/features.md (FEAT-006, FEAT-007), .ai/knowledge-base/decisions.md (DEC-011), .ai/analysis/modules/shift-templates/02-actors.md, .ai/analysis/modules/shift-templates/03-use-cases.md, .ai/analysis/modules/shift-templates/06-routes.md.
- Módulos relacionados: shift-templates, service-managers, shift-assignments, calendar, reports
- Casos de uso: Manage global shift code, name, times, color and working flag; configure service templates
- Diagramas exportados:
  - Casos de uso Mermaid: [`../mermaid/modules/shift-templates.mmd`](../mermaid/modules/shift-templates.mmd)
  - Casos de uso PlantUML: [`../plantuml/modules/shift-templates.puml`](../plantuml/modules/shift-templates.puml)
  - Actividad Mermaid: [`../mermaid/modules/shift-templates-activity.mmd`](../mermaid/modules/shift-templates-activity.mmd)
  - Actividad PlantUML: [`../plantuml/modules/shift-templates-activity.puml`](../plantuml/modules/shift-templates-activity.puml)
  - Secuencia Mermaid: [`../mermaid/modules/shift-templates-sequence.mmd`](../mermaid/modules/shift-templates-sequence.mmd)
  - Secuencia PlantUML: [`../plantuml/modules/shift-templates-sequence.puml`](../plantuml/modules/shift-templates-sequence.puml)
- Estado Mermaid: [`../mermaid/modules/shift-templates-state.mmd`](../mermaid/modules/shift-templates-state.mmd)
  - Estado PlantUML: [`../plantuml/modules/shift-templates-state.puml`](../plantuml/modules/shift-templates-state.puml)
  - Motivo: Las plantillas globales y por servicio comparten estados de activacion y eliminacion logica.
