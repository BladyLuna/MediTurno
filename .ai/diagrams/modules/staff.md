# Staff

- Propósito: Representar la gestion administrativa de personal y la consulta restringida por jefatura.
- Actores: `admin`, `jefe_servicio`.
- Evidencia usada: .ai/knowledge-base/features.md (FEAT-005, FEAT-018), .ai/knowledge-base/decisions.md (DEC-010, DEC-013), .ai/analysis/modules/staff/02-actors.md, .ai/analysis/modules/staff/03-use-cases.md, .ai/analysis/modules/staff/06-routes.md.
- Módulos relacionados: staff, hospital-services, service-managers, shift-assignments, shift-change-requests, calendar, reports
- Casos de uso: Admin CRUD/status; jefe list/filter read-only by managed services
- Diagramas exportados:
  - Casos de uso Mermaid: [`../mermaid/modules/staff.mmd`](../mermaid/modules/staff.mmd)
  - Casos de uso PlantUML: [`../plantuml/modules/staff.puml`](../plantuml/modules/staff.puml)
  - Actividad Mermaid: [`../mermaid/modules/staff-activity.mmd`](../mermaid/modules/staff-activity.mmd)
  - Actividad PlantUML: [`../plantuml/modules/staff-activity.puml`](../plantuml/modules/staff-activity.puml)
  - Secuencia Mermaid: [`../mermaid/modules/staff-sequence.mmd`](../mermaid/modules/staff-sequence.mmd)
  - Secuencia PlantUML: [`../plantuml/modules/staff-sequence.puml`](../plantuml/modules/staff-sequence.puml)
- Estado Mermaid: [`../mermaid/modules/staff-state.mmd`](../mermaid/modules/staff-state.mmd)
  - Estado PlantUML: [`../plantuml/modules/staff-state.puml`](../plantuml/modules/staff-state.puml)
  - Motivo: El personal mantiene un ciclo de activo, inactivo y eliminacion logica.
