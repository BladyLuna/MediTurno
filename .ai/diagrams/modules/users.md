# Users

- Propósito: Representar el CRUD administrativo de usuarios, activacion/desactivacion y eliminacion logica.
- Actores: `admin`.
- Evidencia usada: .ai/knowledge-base/features.md (FEAT-002), .ai/knowledge-base/decisions.md (DEC-001, DEC-009), .ai/analysis/modules/users/02-actors.md, .ai/analysis/modules/users/03-use-cases.md, .ai/analysis/modules/users/06-routes.md.
- Módulos relacionados: users, audit, notifications, staff, service-managers
- Casos de uso: USR-01 List users; USR-02 Create user; USR-03 Edit user; USR-04 Activate/deactivate; USR-05 Delete logically
- Diagramas exportados:
  - Casos de uso Mermaid: [`../mermaid/modules/users.mmd`](../mermaid/modules/users.mmd)
  - Casos de uso PlantUML: [`../plantuml/modules/users.puml`](../plantuml/modules/users.puml)
  - Actividad Mermaid: [`../mermaid/modules/users-activity.mmd`](../mermaid/modules/users-activity.mmd)
  - Actividad PlantUML: [`../plantuml/modules/users-activity.puml`](../plantuml/modules/users-activity.puml)
  - Secuencia Mermaid: [`../mermaid/modules/users-sequence.mmd`](../mermaid/modules/users-sequence.mmd)
  - Secuencia PlantUML: [`../plantuml/modules/users-sequence.puml`](../plantuml/modules/users-sequence.puml)
- Estado Mermaid: [`../mermaid/modules/users-state.mmd`](../mermaid/modules/users-state.mmd)
  - Estado PlantUML: [`../plantuml/modules/users-state.puml`](../plantuml/modules/users-state.puml)
  - Motivo: El ciclo de usuario confirma estados activos e inactivos y eliminacion logica protegida.
