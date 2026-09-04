# Calendar

- Propósito: Representar la visualizacion mensual de asignaciones para admin, jefatura y personal.
- Actores: `admin`, `jefe_servicio`, `personal`.
- Evidencia usada: .ai/knowledge-base/features.md (FEAT-010, FEAT-017, FEAT-018), .ai/knowledge-base/decisions.md (DEC-007, DEC-013), .ai/analysis/modules/calendar/02-actors.md, .ai/analysis/modules/calendar/03-use-cases.md, .ai/analysis/modules/calendar/06-routes.md.
- Módulos relacionados: shift-assignments, staff, hospital-services, shift-templates
- Casos de uso: View monthly calendar, navigate months, filter by service/staff, open event detail
- Diagramas exportados:
  - Casos de uso Mermaid: [`../mermaid/modules/calendar.mmd`](../mermaid/modules/calendar.mmd)
  - Casos de uso PlantUML: [`../plantuml/modules/calendar.puml`](../plantuml/modules/calendar.puml)
  - Actividad Mermaid: [`../mermaid/modules/calendar-activity.mmd`](../mermaid/modules/calendar-activity.mmd)
  - Actividad PlantUML: [`../plantuml/modules/calendar-activity.puml`](../plantuml/modules/calendar-activity.puml)
  - Secuencia Mermaid: [`../mermaid/modules/calendar-sequence.mmd`](../mermaid/modules/calendar-sequence.mmd)
  - Secuencia PlantUML: [`../plantuml/modules/calendar-sequence.puml`](../plantuml/modules/calendar-sequence.puml)
- Estado: no aplica. Es una vista de solo lectura sin ciclo propio de vida.
