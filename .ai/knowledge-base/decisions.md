# Decisions Registry

## Decisiones formales del proyecto

| ID | Fecha | Decision preservada | Consecuencia principal | Fuente | Estado | Vigencia |
|---|---|---|---|---|---|---|
| DEC-001 | 2026-06-06 | Roles en `users.role`; no usar paquetes externos de permisos | Autorizacion propia del proyecto | SRC-002 | `CONFIRMED` | `ACTIVE` |
| DEC-002 | 2026-06-07 | Congelar documentacion y usar `.ia/*` como fuente de verdad | Cambios de alcance, datos o reglas requieren decision | SRC-002 | `CONFIRMED` | `OBSOLETE` parcialmente por DEC-015 |
| DEC-003 | 2026-06-06 | No permitir turnos traslapados | Validar con `start_at` y `end_at` | SRC-002 | `CONFIRMED` | `ACTIVE` |
| DEC-004 | 2026-06-06 | Turnos nocturnos terminan en la fecha siguiente | Intervalos cruzan medianoche | SRC-002 | `CONFIRMED` | `ACTIVE` |
| DEC-005 | 2026-06-06 | Usar `hospital_service_id` | Nombre oficial de claves hacia servicios | SRC-002 | `CONFIRMED` | `ACTIVE` |
| DEC-006 | 2026-06-06 | Un jefe puede administrar multiples servicios | Usar `service_managers` | SRC-002 | `CONFIRMED` | `ACTIVE` |
| DEC-007 | 2026-06-06 | Calendario por recarga o consulta | WebSockets descartados para el alcance | SRC-002 | `CONFIRMED` | `ACTIVE` |
| DEC-008 | 2026-06-06 | Estados controlados para asignaciones, solicitudes, ausencias y vacaciones | Evitar estados ambiguos | SRC-002 | `CONFIRMED` | `ACTIVE` |
| DEC-009 | 2026-06-07 | Proteger ultimo admin y prohibir auto-desactivacion/eliminacion | Evitar bloqueo administrativo | SRC-002 | `CONFIRMED` | `ACTIVE` |
| DEC-010 | 2026-06-07 | `staff.user_id` solo puede asociar usuarios `personal` | Separar perfiles administrativos y operativos | SRC-002 | `CONFIRMED` | `ACTIVE` |
| DEC-011 | 2026-06-07 | Horas personalizadas deben definirse juntas y pueden cruzar medianoche | Evitar configuraciones incompletas | SRC-002 | `CONFIRMED` | `ACTIVE` |
| DEC-012 | 2026-06-07 | Cancelar asignacion, luego SoftDelete y auditar `cancelled/deleted` | Conservar trazabilidad semantica y tecnica | SRC-002 | `CONFIRMED` | `ACTIVE` |
| DEC-013 | 2026-06-07 | Vistas por rol y alcance de servicio/personal | Consultas restringidas desde backend | SRC-002 | `CONFIRMED` | `ACTIVE` |
| DEC-014 | 2026-06-07 | Jefatura puede operar asignaciones solo en servicios asociados | Operacion limitada, transaccional y auditada | SRC-002 | `CONFIRMED` | `ACTIVE` |
| DEC-015 | 2026-06-19 | `.ai/` es fuente de verdad del analisis; `.ia/` queda legado temporal | Migracion por copia y retiro sujeto a validacion | SRC-002 | `CONFIRMED` | `ACTIVE` |

## Directivas BDS documentadas

Estas entradas preservan directivas existentes; no crean nuevas decisiones de
arquitectura.

| ID | Fecha | Directiva preservada | Fuente | Estado | Vigencia |
|---|---|---|---|---|---|
| BDS-DIR-001 | 2026-07-01 | Separar contrato `.ai/core/knowledge-base/` de instancia `.ai/knowledge-base/` | SRC-012 | `CONFIRMED` | `ACTIVE` |
| BDS-DIR-002 | 2026-07-01 | Exigir evidencia, estados epistemicos y conservacion de conocimiento obsoleto | SRC-012, SRC-015 | `CONFIRMED` | `ACTIVE` |
| BDS-DIR-003 | 2026-07-01 | Preservar conocimiento antes del analisis tecnico | SRC-003 | `CONFIRMED` | `ACTIVE` |
| BDS-DIR-004 | 2026-07-01 | Knowledge Archivist solo preserva conocimiento y trabaja en `.ai/knowledge-base/` | SRC-024 | `CONFIRMED` | `ACTIVE` |

## Contradicciones relacionadas

Las decisiones no resuelven automaticamente los conflictos registrados en
[`problems.md`](problems.md). En particular, el comportamiento de aprobacion de
solicitudes de cambio permanece `PENDING CONFIRMATION`.
