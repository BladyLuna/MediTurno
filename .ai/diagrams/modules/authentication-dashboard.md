# Authentication and Dashboard

- Propósito: Representar login, logout y el acceso al dashboard para los tres roles confirmados.
- Actores: `Guest`, `admin`, `jefe_servicio`, `personal`.
- Evidencia usada: .ai/knowledge-base/features.md (FEAT-001), .ai/analysis/modules/authentication-dashboard/02-actors.md, .ai/analysis/modules/authentication-dashboard/03-use-cases.md, .ai/analysis/modules/authentication-dashboard/06-routes.md, .ai/knowledge-base/decisions.md (DEC-001).
- Módulos relacionados: authentication-dashboard, users, calendar, shift-assignments, shift-change-requests, notifications, audit
- Casos de uso: AUTH-01 Open login; AUTH-02 Authenticate; AUTH-03 View dashboard; AUTH-04 Logout
- Diagramas exportados:
  - Casos de uso Mermaid: [`../mermaid/modules/authentication-dashboard.mmd`](../mermaid/modules/authentication-dashboard.mmd)
  - Casos de uso PlantUML: [`../plantuml/modules/authentication-dashboard.puml`](../plantuml/modules/authentication-dashboard.puml)
  - Actividad Mermaid: [`../mermaid/modules/authentication-dashboard-activity.mmd`](../mermaid/modules/authentication-dashboard-activity.mmd)
  - Actividad PlantUML: [`../plantuml/modules/authentication-dashboard-activity.puml`](../plantuml/modules/authentication-dashboard-activity.puml)
  - Secuencia Mermaid: [`../mermaid/modules/authentication-dashboard-sequence.mmd`](../mermaid/modules/authentication-dashboard-sequence.mmd)
  - Secuencia PlantUML: [`../plantuml/modules/authentication-dashboard-sequence.puml`](../plantuml/modules/authentication-dashboard-sequence.puml)
- Estado Mermaid: [`../mermaid/modules/authentication-dashboard-state.mmd`](../mermaid/modules/authentication-dashboard-state.mmd)
  - Estado PlantUML: [`../plantuml/modules/authentication-dashboard-state.puml`](../plantuml/modules/authentication-dashboard-state.puml)
  - Motivo: El flujo de autenticacion expone estados claros de invitado, autenticado, dashboard y denegado.
