# Shift Change Requests

- Propósito: Representar la creacion y revision de solicitudes de cambio de turno.
- Actores: `personal`, `admin`, `jefe_servicio`.
- Evidencia usada: .ai/knowledge-base/features.md (FEAT-015), .ai/knowledge-base/decisions.md (DEC-008), .ai/analysis/modules/shift-change-requests/02-actors.md, .ai/analysis/modules/shift-change-requests/03-use-cases.md, .ai/analysis/modules/shift-change-requests/06-routes.md.
- Módulos relacionados: shift-assignments, notifications, audit
- Casos de uso: Personal create/cancel own; admin/jefatura review scoped requests
- Diagramas exportados:
  - Casos de uso Mermaid: [`../mermaid/modules/shift-change-requests.mmd`](../mermaid/modules/shift-change-requests.mmd)
  - Casos de uso PlantUML: [`../plantuml/modules/shift-change-requests.puml`](../plantuml/modules/shift-change-requests.puml)
  - Actividad Mermaid: [`../mermaid/modules/shift-change-requests-activity.mmd`](../mermaid/modules/shift-change-requests-activity.mmd)
  - Actividad PlantUML: [`../plantuml/modules/shift-change-requests-activity.puml`](../plantuml/modules/shift-change-requests-activity.puml)
  - Secuencia Mermaid: [`../mermaid/modules/shift-change-requests-sequence.mmd`](../mermaid/modules/shift-change-requests-sequence.mmd)
  - Secuencia PlantUML: [`../plantuml/modules/shift-change-requests-sequence.puml`](../plantuml/modules/shift-change-requests-sequence.puml)
- Estado Mermaid: [`../mermaid/modules/shift-change-requests-state.mmd`](../mermaid/modules/shift-change-requests-state.mmd)
  - Estado PlantUML: [`../plantuml/modules/shift-change-requests-state.puml`](../plantuml/modules/shift-change-requests-state.puml)
  - Motivo: Las solicitudes se mueven entre pending, approved, rejected y cancelled.
