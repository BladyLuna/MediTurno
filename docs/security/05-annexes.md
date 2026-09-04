# Anexos de Seguridad

## Anexo A. Relación con los módulos

| Módulo | Activos principales | Controles relevantes | Riesgo principal |
|---|---|---|---|
| Autenticación y dashboard | Credenciales, sesión, rol, estado activo | Hash, sesión, `auth`, `active`, `role`, CSRF | Compromiso de cuenta o fuerza bruta |
| Usuarios | Cuentas, roles y estado | Policies, validación, DEC-009, auditoría, SoftDeletes | Escalada de privilegios o pérdida del último admin |
| Servicios hospitalarios | Catálogo y delimitación operativa | Solo admin, Policy, FKs, auditoría | Alteración de estructura operativa |
| Personal de salud | Identidad, contacto, servicio y usuario asociado | Solo admin para CRUD; alcance de lectura por jefatura; DEC-010 | Exposición de datos personales |
| Jefaturas por servicio | Asociaciones usuario-servicio | Solo admin gestiona; `UserScopeService` consume alcance | Acceso a servicios no administrados |
| Plantillas de turno | Horarios y configuración por servicio | Solo admin, validaciones, DEC-011, auditoría | Configuración horaria incorrecta |
| Asignaciones | Intervalos, estado, notas y responsables | Policies, alcance, conflicto, tiempo, transacciones, auditoría | Traslape o modificación indebida |
| Calendario | Vista temporal de asignaciones | Filtros backend por rol y alcance; solo lectura para vistas específicas | Divulgación horizontal |
| Reportes | Resúmenes, detalle y exportaciones | Solo lectura; filtros por alcance | Filtración de datos exportados |
| Solicitudes de cambio | Motivos, estados, revisión | Propiedad, alcance por servicio, transacciones, auditoría | Revisión no autorizada |
| Notificaciones | Mensajes y lectura | Policy de destinatario | Lectura de mensajes ajenos |
| Auditoría | Historial de operaciones | Solo admin; registro estructurado | Alteración o retención indefinida |

## Anexo B. Relación con actores

| Actor | Acceso confirmado | Restricciones de seguridad |
|---|---|---|
| Invitado | Login | Middleware `guest`; no accede a áreas protegidas |
| Administrador | Gestión y consulta global | Cuenta activa, rol `admin`, Policies; no puede eliminarse/desactivarse a sí mismo ni eliminar/desactivar al último admin activo |
| Jefe de Servicio | Operación, calendario, personal, reportes y revisión dentro de servicios asociados | Rol `jefe_servicio`; IDs limitados por `service_managers`; no accede a CRUD global ni auditoría |
| Personal de Salud | Turnos, solicitudes y notificaciones propias | Rol `personal`; alcance por `staff.user_id`; Policies de propiedad |

Observación: `README.md` resume el rol jefe principalmente como revisor de
solicitudes, mientras DEC-013/014 y la implementación confirman un alcance mayor.
La contradicción está registrada como CONFLICT-003 y permanece
**PENDIENTE DE CONFIRMAR** en la documentación de presentación.

## Anexo C. Relación con permisos

| Recurso | Administrador | Jefe de Servicio | Personal de Salud |
|---|---|---|---|
| Usuarios | CRUD global | Sin acceso | Sin acceso |
| Servicios | CRUD global | Solo servicios asociados en vistas operativas | Sin acceso |
| Personal | CRUD global | Lectura de servicios asociados | Perfil asociado como base de alcance |
| Jefaturas | Gestiona asociaciones | Sin gestión | Sin acceso |
| Plantillas | CRUD global | Usa configuraciones de sus servicios al asignar | Sin gestión |
| Asignaciones | Operación global | Operación dentro de servicios asociados | Lectura propia |
| Calendario | Global | Servicios asociados, solo lectura | Asignaciones propias, solo lectura |
| Reportes | Global | Servicios asociados, solo lectura | Sin reporte confirmado |
| Solicitudes | Revisión global | Revisión dentro de servicios asociados | Crea, consulta y cancela propias |
| Notificaciones | Propias según Policy | Propias según Policy | Propias según Policy |
| Auditoría | Lectura global | Sin acceso | Sin acceso |

Fuentes: `.ai/analysis/modules/*/05-permissions.md`; DEC-013; DEC-014.

## Anexo D. Referencias a diagramas

| Diagrama | Ubicación | Uso en seguridad |
|---|---|---|
| Casos de uso general | `.ai/diagrams/general/use-cases.md` | Actores, fronteras funcionales y superficies de acceso |
| Clases del dominio | `.ai/diagrams/general/class-diagram.md` | Entidades, relaciones y activos |
| ERD | `.ai/diagrams/general/erd.md` | Persistencia, FKs y dependencias físicas |
| Diagramas por módulo | `.ai/diagrams/modules/` | Acciones y actores específicos |
| Actividades y secuencias | `.ai/diagrams/mermaid/modules/` y `.ai/diagrams/plantuml/modules/` | Puntos de validación y flujo |

## Anexo E. Referencias a decisiones

| Decisión | Relevancia de seguridad |
|---|---|
| DEC-001 | Modelo de autorización mediante `users.role` |
| DEC-003 | Integridad de asignaciones sin traslapes |
| DEC-004 | Integridad temporal de turnos nocturnos |
| DEC-008 | Estados permitidos del dominio |
| DEC-009 | Continuidad del acceso administrativo |
| DEC-010 | Separación entre cuentas administrativas y perfil de personal |
| DEC-011 | Integridad de horarios personalizados |
| DEC-012 | Trazabilidad de cancelación y eliminación lógica |
| DEC-013 | Aislamiento de vistas por rol |
| DEC-014 | Operación de jefatura limitada, transaccional y auditada |
| DEC-015 | Gobierno de evidencia y fuente de verdad documental |

## Anexo F. Información pendiente

- Clasificación institucional de los datos y propietario de cada activo.
- Metodología cuantitativa, apetito y responsables de riesgos.
- Vigencia actual de advisories Composer y npm.
- Rate limiting del login.
- MFA y política formal de contraseñas.
- Configuración real de cookies, TLS, cabeceras y secretos en producción.
- Backups, retención y restauración probada.
- Monitoreo, alertas, RTO/RPO y continuidad.
- Política de retención, exportación e inmutabilidad de auditoría.
- Política de manejo de CSV/PDF descargados.
- Procedimiento de respuesta a incidentes.
- Resolución de CONFLICT-003 y CONFLICT-004.

