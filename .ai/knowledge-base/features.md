# Features Registry

## Funcionalidades declaradas como implementadas

El estado `CONFIRMED` indica que una fuente documental declara la funcionalidad y,
cuando se especifica, que existe evidencia estructural adicional. No sustituye una
prueba funcional actual.

| ID | Funcionalidad preservada | Estado declarado | Fuente | Estado epistemico | Vigencia |
|---|---|---|---|---|---|
| FEAT-001 | Login, logout y roles | Implementado | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-002 | CRUD y control de usuarios | Implementado | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-003 | Servicios hospitalarios | Implementado | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-004 | Jefes de servicio | Implementado | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-005 | Personal de salud | Implementado | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-006 | Plantillas globales de turno | Implementado | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-007 | Turnos configurados por servicio | Implementado | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-008 | Asignacion de turnos | Implementado | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-009 | Validacion de traslapes | Implementado | SRC-001, DEC-003 | `CONFIRMED` | `ACTIVE` |
| FEAT-010 | Calendario mensual | Implementado | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-011 | Reportes por servicio y empleado | Implementado | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-012 | Exportacion CSV | Implementado | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-013 | Exportacion PDF basica | Implementado | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-014 | Auditoria de operaciones criticas | Implementado | SRC-001, SRC-009 | `CONFIRMED` | `ACTIVE` |
| FEAT-015 | Solicitudes de cambio de turno | Implementado como MVP opcional | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-016 | Notificaciones internas | Implementado como MVP opcional | SRC-001 | `CONFIRMED` | `ACTIVE` |
| FEAT-017 | Calendario, personal, solicitudes y reportes restringidos para jefatura | Version 2 documentada y observada | SRC-002 DEC-013, SRC-004 | `CONFIRMED` | `ACTIVE` |
| FEAT-018 | Calendario personal filtrado por `staff.user_id` | Version 2 documentada y observada | SRC-002 DEC-013, SRC-004 | `CONFIRMED` | `ACTIVE` |
| FEAT-019 | Crear, editar y cancelar asignaciones desde jefatura dentro de servicios asociados | Version 3 documentada y observada | SRC-002 DEC-014, SRC-004 | `CONFIRMED` | `ACTIVE` |
| FEAT-020 | Disponibilidad de personal y observaciones operativas para jefatura | Version 3 observada en contexto | SRC-004 | `CONFIRMED` | `ACTIVE` |
| FEAT-021 | Datos demo y flujo de defensa | Declarado disponible | SRC-001, SRC-018 | `CONFIRMED` | `ACTIVE` |

## Funcionalidades preservadas como Post-MVP

| ID | Funcionalidad | Clasificacion | Fuente | Estado epistemico | Vigencia |
|---|---|---|---|---|---|
| FEAT-PM-001 | Ausencias, permisos o bajas | Post-MVP | SRC-005, SRC-006 | `CONFIRMED` | `ACTIVE` como conocimiento planificado |
| FEAT-PM-002 | Vacaciones | Post-MVP | SRC-005, SRC-006 | `CONFIRMED` | `ACTIVE` como conocimiento planificado |
| FEAT-PM-003 | Notificaciones externas | Post-MVP | SRC-005, SRC-006 | `CONFIRMED` | `ACTIVE` como conocimiento planificado |
| FEAT-PM-004 | Estadisticas avanzadas de equidad, carga y cobertura | Post-MVP | SRC-005, SRC-006 | `CONFIRMED` | `ACTIVE` como conocimiento planificado |

## Funcionalidad con estado contradictorio

| ID | Funcionalidad | Informacion disponible | Fuente | Estado |
|---|---|---|---|---|
| FEAT-GAP-001 | Exportacion Excel | Roadmap/backlog la consideran opcional; README declara HTML, CSV y PDF y el manifiesto no incluye el paquete indicado en CLAUDE | SRC-001, SRC-005, SRC-006, SRC-010 DOC-007 | `PENDING CONFIRMATION` |

## Limite de esta captura

No se ejecuto el sistema ni sus pruebas. La operatividad actual debe confirmarse
en una actividad de QA y registrarse como evidencia nueva.

