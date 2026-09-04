# Hospital Services

- Propósito: Representar el CRUD administrativo de servicios hospitalarios y su estado activo.
- Actores: `admin`, `jefe_servicio`, `personal`.
- Evidencia usada: .ai/knowledge-base/features.md (FEAT-003), .ai/knowledge-base/decisions.md (DEC-005), .ai/analysis/modules/hospital-services/02-actors.md, .ai/analysis/modules/hospital-services/03-use-cases.md, .ai/analysis/modules/hospital-services/06-routes.md.
- Módulos relacionados: hospital-services, staff, service-managers, shift-templates, shift-assignments, calendar, reports
- Casos de uso: Admin list/create/edit/activate/deactivate/delete hospital services
- Diagramas exportados:
  - Casos de uso Mermaid: [`../mermaid/modules/hospital-services.mmd`](../mermaid/modules/hospital-services.mmd)
  - Casos de uso PlantUML: [`../plantuml/modules/hospital-services.puml`](../plantuml/modules/hospital-services.puml)
  - Actividad Mermaid: [`../mermaid/modules/hospital-services-activity.mmd`](../mermaid/modules/hospital-services-activity.mmd)
  - Actividad PlantUML: [`../plantuml/modules/hospital-services-activity.puml`](../plantuml/modules/hospital-services-activity.puml)
  - Secuencia Mermaid: [`../mermaid/modules/hospital-services-sequence.mmd`](../mermaid/modules/hospital-services-sequence.mmd)
  - Secuencia PlantUML: [`../plantuml/modules/hospital-services-sequence.puml`](../plantuml/modules/hospital-services-sequence.puml)
- Estado Mermaid: [`../mermaid/modules/hospital-services-state.mmd`](../mermaid/modules/hospital-services-state.mmd)
  - Estado PlantUML: [`../plantuml/modules/hospital-services-state.puml`](../plantuml/modules/hospital-services-state.puml)
  - Motivo: Los servicios alternan entre activo, inactivo y eliminacion logica.
