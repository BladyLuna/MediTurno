# Class Traceability Matrix

| Clase | Modelo | Tabla | Caso(s) de uso | Módulo | Actor principal |
|---|---|---|---|---|---|
| User | `User` | `users` | AUTH-01..04; USR-01..05 | authentication-dashboard; users | Guest; admin |
| HospitalService | `HospitalService` | `hospital_services` | service CRUD/status | hospital-services | admin |
| Staff | `Staff` | `staff` | staff CRUD/status; service-staff list | staff | admin; jefe_servicio |
| ServiceManager | `ServiceManager` | `service_managers` | associate user/service; scoped access | service-managers | admin |
| ShiftTemplate | `ShiftTemplate` | `shift_templates` | global shift template CRUD/status | shift-templates | admin |
| ServiceShiftTemplate | `ServiceShiftTemplate` | `service_shift_templates` | service-specific shift configuration | shift-templates | admin |
| ShiftAssignment | `ShiftAssignment` | `shift_assignments` | assignment CRUD; availability; calendar; reports | shift-assignments; calendar; reports | admin; jefe_servicio |
| ShiftChangeRequest | `ShiftChangeRequest` | `shift_change_requests` | request create/cancel/review; notifications | shift-change-requests | personal; admin; jefe_servicio |
| InternalNotification | `InternalNotification` | `notifications` | list/read own notifications | notifications | authenticated active user |
| AuditLog | `AuditLog` | `audit_logs` | list/detail audit events | audit | admin |

