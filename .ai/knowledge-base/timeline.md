# Project Timeline

## Eventos con fecha confirmada

| ID | Fecha | Evento preservado | Fuente | Estado | Vigencia |
|---|---|---|---|---|---|
| TL-001 | 2026-06-06 | Se decide almacenar roles en `users.role` y no usar paquetes externos de permisos | SRC-002, DEC-001 | `CONFIRMED` | `ACTIVE` |
| TL-002 | 2026-06-06 | Se formalizan traslapes, turnos nocturnos, nombre `hospital_service_id`, multiples servicios por jefe, recarga de calendario y estados permitidos | SRC-002, DEC-003 a DEC-008 | `CONFIRMED` | `ACTIVE` |
| TL-003 | 2026-06-07 | Se congela la documentacion y `.ia/*` pasa a ser fuente de verdad; cambios futuros deben registrarse en decisiones | SRC-002, DEC-002 | `CONFIRMED` | `OBSOLETE` por DEC-015 respecto al ecosistema de analisis |
| TL-004 | 2026-06-07 | Se registran protecciones de administradores, asociacion staff-user, horarios personalizados y cancelacion con SoftDeletes | SRC-002, DEC-009 a DEC-012 | `CONFIRMED` | `ACTIVE` |
| TL-005 | 2026-06-07 | DEC-013 formaliza vistas por rol para administrador, jefe y personal | SRC-002 | `CONFIRMED` | `ACTIVE` |
| TL-006 | 2026-06-07 | DEC-014 formaliza gestion operativa limitada para jefatura | SRC-002 | `CONFIRMED` | `ACTIVE` |
| TL-007 | 2026-06-19 | DEC-015 establece `.ai/` como fuente de verdad del analisis y deja `.ia/` como legado temporal | SRC-002 | `CONFIRMED` | `ACTIVE` |
| TL-008 | 2026-06-19 | Se registra inventario, mapa documental, plan de reorganizacion y conflictos | SRC-010, SRC-027, SRC-028 | `CONFIRMED` | `ACTIVE` |
| TL-009 | 2026-07-01 | Se verifican 13 copias documentales y se preserva `system-analyst` como referencia | SRC-011 | `CONFIRMED` | `ACTIVE` |
| TL-010 | 2026-07-01 | Se define Knowledge Base Core con charter, esquema, reglas y ciclo de vida | SRC-012 a SRC-016 | `CONFIRMED` | `ACTIVE` |
| TL-011 | 2026-07-01 | Se activa Knowledge Archivist para poblar exclusivamente `.ai/knowledge-base/` | SRC-024 | `CONFIRMED` | `ACTIVE` |
| TL-012 | 2026-07-01 | Se crea la instancia inicial de Knowledge Base | Esta captura | `CONFIRMED` | `ACTIVE` |

## Secuencia de producto sin fecha individual confirmada

El roadmap preserva esta secuencia:

| Orden | Entrega | Fuente | Estado |
|---:|---|---|---|
| 1 | Base: login, logout, roles y dashboard | SRC-005 | `CONFIRMED` |
| 2 | Usuarios y auditoria inicial | SRC-005 | `CONFIRMED` |
| 3 | Servicios hospitalarios | SRC-005 | `CONFIRMED` |
| 4 | Personal de salud | SRC-005 | `CONFIRMED` |
| 5 | Plantillas de turno | SRC-005 | `CONFIRMED` |
| 6 | Asignaciones, conflictos y auditoria | SRC-005 | `CONFIRMED` |
| 7 | Calendario mensual | SRC-005 | `CONFIRMED` |
| 8 | Reportes basicos | SRC-005 | `CONFIRMED` |
| 9 | Solicitudes de cambio y notificaciones internas | SRC-005 | `CONFIRMED` |
| 10 | Cierre, pruebas y despliegue | SRC-005 | `CONFIRMED` |
| 11 | Vistas por rol y reportes por servicio | SRC-002, DEC-013; SRC-024 | `CONFIRMED` |
| 12 | Gestion operativa por jefatura | SRC-002, DEC-014; SRC-024 | `CONFIRMED` |

> Fecha exacta de inicio y finalizacion de cada sprint:
> `PENDING CONFIRMATION`.

