# Notifications

- Propósito: Representar la bandeja interna de notificaciones y su estado de lectura.
- Actores: `personal`, `admin`, `jefe_servicio` y cualquier usuario autenticado activo que consuma sus propias notificaciones.
- Evidencia usada: .ai/knowledge-base/features.md (FEAT-016), .ai/analysis/modules/notifications/02-actors.md, .ai/analysis/modules/notifications/03-use-cases.md, .ai/analysis/modules/notifications/06-routes.md.
- Módulos relacionados: shift-change-requests, audit
- Casos de uso: List own notifications, mark one read, mark all own notifications read
- Diagramas exportados:
  - Casos de uso Mermaid: [`../mermaid/modules/notifications.mmd`](../mermaid/modules/notifications.mmd)
  - Casos de uso PlantUML: [`../plantuml/modules/notifications.puml`](../plantuml/modules/notifications.puml)
  - Actividad Mermaid: [`../mermaid/modules/notifications-activity.mmd`](../mermaid/modules/notifications-activity.mmd)
  - Actividad PlantUML: [`../plantuml/modules/notifications-activity.puml`](../plantuml/modules/notifications-activity.puml)
  - Secuencia Mermaid: [`../mermaid/modules/notifications-sequence.mmd`](../mermaid/modules/notifications-sequence.mmd)
  - Secuencia PlantUML: [`../plantuml/modules/notifications-sequence.puml`](../plantuml/modules/notifications-sequence.puml)
- Estado Mermaid: [`../mermaid/modules/notifications-state.mmd`](../mermaid/modules/notifications-state.mmd)
  - Estado PlantUML: [`../plantuml/modules/notifications-state.puml`](../plantuml/modules/notifications-state.puml)
  - Motivo: La notificacion solo requiere distinguir no leida y leida.
