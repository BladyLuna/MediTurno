# Service Managers

- Propósito: Representar la asignacion de uno o varios servicios a cada jefe.
- Actores: `admin`, `jefe_servicio`.
- Evidencia usada: .ai/knowledge-base/features.md (FEAT-004), .ai/knowledge-base/decisions.md (DEC-006), .ai/analysis/modules/service-managers/02-actors.md, .ai/analysis/modules/service-managers/03-use-cases.md, .ai/analysis/modules/service-managers/06-routes.md.
- Módulos relacionados: service-managers, users, hospital-services, staff, shift-assignments, calendar, reports
- Casos de uso: Admin list/create/remove service-manager associations; jefatura consumes scope
- Diagramas exportados:
  - Casos de uso Mermaid: [`../mermaid/modules/service-managers.mmd`](../mermaid/modules/service-managers.mmd)
  - Casos de uso PlantUML: [`../plantuml/modules/service-managers.puml`](../plantuml/modules/service-managers.puml)
  - Actividad Mermaid: [`../mermaid/modules/service-managers-activity.mmd`](../mermaid/modules/service-managers-activity.mmd)
  - Actividad PlantUML: [`../plantuml/modules/service-managers-activity.puml`](../plantuml/modules/service-managers-activity.puml)
  - Secuencia Mermaid: [`../mermaid/modules/service-managers-sequence.mmd`](../mermaid/modules/service-managers-sequence.mmd)
  - Secuencia PlantUML: [`../plantuml/modules/service-managers-sequence.puml`](../plantuml/modules/service-managers-sequence.puml)
- Estado Mermaid: [`../mermaid/modules/service-managers-state.mmd`](../mermaid/modules/service-managers-state.mmd)
  - Estado PlantUML: [`../plantuml/modules/service-managers-state.puml`](../plantuml/modules/service-managers-state.puml)
  - Motivo: La asociacion puede existir o ser removida logicamente.
