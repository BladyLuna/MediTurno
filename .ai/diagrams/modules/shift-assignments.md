# Shift Assignments

- Propósito: Representar la asignacion de turnos al personal, la validacion de disponibilidad y el alcance administrativo/jefatura.
- Actores: `admin`, `jefe_servicio`.
- Evidencia usada: .ai/knowledge-base/features.md (FEAT-008, FEAT-009, FEAT-019, FEAT-020), .ai/knowledge-base/decisions.md (DEC-003, DEC-004, DEC-012, DEC-014), .ai/analysis/modules/shift-assignments/02-actors.md, .ai/analysis/modules/shift-assignments/03-use-cases.md, .ai/analysis/modules/shift-assignments/06-routes.md.
- Módulos relacionados: shift-assignments, staff, hospital-services, shift-templates, service-managers, calendar, reports, shift-change-requests
- Casos de uso: List/filter, create, edit, cancel/logically delete assignments; check staff availability
- Diagramas exportados:
  - Casos de uso Mermaid: [`../mermaid/modules/shift-assignments.mmd`](../mermaid/modules/shift-assignments.mmd)
  - Casos de uso PlantUML: [`../plantuml/modules/shift-assignments.puml`](../plantuml/modules/shift-assignments.puml)
  - Actividad Mermaid: [`../mermaid/modules/shift-assignments-activity.mmd`](../mermaid/modules/shift-assignments-activity.mmd)
  - Actividad PlantUML: [`../plantuml/modules/shift-assignments-activity.puml`](../plantuml/modules/shift-assignments-activity.puml)
  - Secuencia Mermaid: [`../mermaid/modules/shift-assignments-sequence.mmd`](../mermaid/modules/shift-assignments-sequence.mmd)
  - Secuencia PlantUML: [`../plantuml/modules/shift-assignments-sequence.puml`](../plantuml/modules/shift-assignments-sequence.puml)
- Estado Mermaid: [`../mermaid/modules/shift-assignments-state.mmd`](../mermaid/modules/shift-assignments-state.mmd)
  - Estado PlantUML: [`../plantuml/modules/shift-assignments-state.puml`](../plantuml/modules/shift-assignments-state.puml)
  - Motivo: La asignacion transita por assigned, changed, cancelled y eliminacion logica.
