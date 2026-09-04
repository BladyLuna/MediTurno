# Audit

- Propósito: Representar la consulta administrativa del historial de auditoria y la generacion indirecta de eventos criticos.
- Actores: `admin`, `jefe_servicio`, `personal` como generadores indirectos.
- Evidencia usada: .ai/knowledge-base/features.md (FEAT-014), .ai/analysis/modules/audit/02-actors.md, .ai/analysis/modules/audit/03-use-cases.md, .ai/analysis/modules/audit/06-routes.md, .ai/analysis/modules/audit/07-controllers.md.
- Módulos relacionados: users, hospital-services, staff, shift-templates, shift-assignments, shift-change-requests, notifications
- Casos de uso: List audit events; open audit detail; generate audit event indirectly
- Diagramas exportados:
  - Casos de uso Mermaid: [`../mermaid/modules/audit.mmd`](../mermaid/modules/audit.mmd)
  - Casos de uso PlantUML: [`../plantuml/modules/audit.puml`](../plantuml/modules/audit.puml)
  - Actividad Mermaid: [`../mermaid/modules/audit-activity.mmd`](../mermaid/modules/audit-activity.mmd)
  - Actividad PlantUML: [`../plantuml/modules/audit-activity.puml`](../plantuml/modules/audit-activity.puml)
  - Secuencia Mermaid: [`../mermaid/modules/audit-sequence.mmd`](../mermaid/modules/audit-sequence.mmd)
  - Secuencia PlantUML: [`../plantuml/modules/audit-sequence.puml`](../plantuml/modules/audit-sequence.puml)
- Estado: no aplica. El audit log es append-only y no tiene ciclo de estado funcional propio.
