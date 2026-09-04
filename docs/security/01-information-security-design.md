# Diseño de Seguridad de la Información para el Proyecto MediTurno

## Alcance y criterio de evidencia

Este documento describe la seguridad observada en MediTurno. Se basa en la
Knowledge Base validada, el análisis funcional, los diagramas, los modelos
Eloquent, las migraciones, `README.md` y `docs/decisions.md`.

La valoración de riesgo es cualitativa. No existe evidencia de una metodología
cuantitativa, apetito de riesgo institucional o evaluación en producción. Cuando
una medida no puede comprobarse con las fuentes autorizadas se indica
**PENDIENTE DE CONFIRMAR**.

## 1. Descripción del proyecto

### Objetivo

MediTurno es un sistema web de gestión de turnos hospitalarios desarrollado como
proyecto de grado. Su objetivo es sustituir la administración manual mediante
hojas de cálculo por una aplicación con roles, asignaciones, validación de
traslapes, calendario, reportes, solicitudes de cambio, notificaciones internas
y auditoría.

Fuentes: `README.md`; `.ai/knowledge-base/features.md`; PROB-001 en
`.ai/knowledge-base/problems.md`.

### Problema

El proyecto atiende la dispersión y fragilidad de la gestión manual de turnos.
En particular, controla asignaciones incompatibles, turnos nocturnos, alcance
operativo por servicio y trazabilidad de operaciones críticas.

Fuentes: DEC-003, DEC-004, DEC-012, DEC-013 y DEC-014 en
`docs/decisions.md`.

### Actores

| Actor | Alcance confirmado |
|---|---|
| Invitado | Accede al formulario de autenticación. |
| Administrador | Gestiona globalmente usuarios, servicios, personal, jefaturas, plantillas y asignaciones; consulta calendario, reportes y auditoría. |
| Jefe de Servicio | Consulta y opera únicamente servicios asociados mediante `service_managers`; revisa solicitudes dentro de ese alcance. |
| Personal de Salud | Consulta sus turnos, solicitudes y notificaciones, vinculados mediante `staff.user_id`. |

Fuentes: `.ai/analysis/00-project-inventory.md`;
`.ai/diagrams/general/use-cases.md`; DEC-013 y DEC-014.

### Tecnologías

| Capa | Tecnología confirmada |
|---|---|
| Backend | PHP 8.2 y Laravel 10 |
| Interfaz | Blade, Bootstrap 5 y Vite |
| Calendario | FullCalendar |
| Datos | MySQL 8 |
| Reportes | HTML, CSV y PDF básico |
| Entorno local | Docker Compose, PHP-FPM, Nginx y MySQL |
| Autenticación | Sesión web nativa de Laravel |

Fuentes: `README.md`; `.ai/analysis/00-project-inventory.md`.

### Información procesada

El sistema procesa cuentas y roles, datos identificativos y de contacto del
personal, servicios hospitalarios, configuraciones horarias, asignaciones,
observaciones operativas, solicitudes y motivos de cambio, notificaciones,
reportes y registros de auditoría. Los registros de auditoría incluyen usuario,
acción, entidad, valores anteriores y nuevos, dirección IP y agente de usuario
cuando están disponibles.

Fuentes: modelos en `app/Models/`; migraciones en `database/migrations/`;
`app/Services/AuditLogService.php`.

### Alcance

El alcance confirmado comprende el MVP y las ampliaciones por rol de DEC-013 y
DEC-014. Ausencias, vacaciones, notificaciones externas y estadísticas
avanzadas permanecen Post-MVP. El calendario se actualiza mediante recarga o
nueva consulta, sin WebSockets.

Fuentes: `README.md`; `.ai/knowledge-base/features.md`; DEC-007.

## 2. Activos de información

La criticidad expresa el efecto potencial sobre la operación y la trazabilidad,
no una clasificación institucional formal.

| Activo | Descripción | Módulo | Nivel de criticidad |
|---|---|---|---|
| Cuentas, credenciales y roles | Identidad de acceso, contraseña cifrada por hash, rol y estado activo | Autenticación y usuarios | Crítico |
| Alcance de jefaturas | Asociación entre usuarios jefes y servicios administrados | Jefaturas por servicio | Alto |
| Datos del personal | CI, nombre, cargo, contacto, servicio y vínculo opcional con usuario | Personal de salud | Alto |
| Servicios hospitalarios | Catálogo que delimita personal, turnos y operación de jefatura | Servicios hospitalarios | Alto |
| Plantillas y turnos por servicio | Códigos, nombres, horarios, colores y configuraciones específicas | Plantillas de turno | Alto |
| Asignaciones de turno | Personal, servicio, turno, fechas reales, estado y observaciones | Asignaciones | Crítico |
| Solicitudes de cambio | Asignación, solicitante, revisor, motivo, estado y observaciones | Solicitudes de cambio | Alto |
| Calendario operativo | Representación temporal de asignaciones autorizadas | Calendario | Alto |
| Reportes y exportaciones | Resúmenes y detalle por servicio o empleado en HTML, CSV y PDF | Reportes | Alto |
| Notificaciones internas | Mensajes dirigidos a usuarios y estado de lectura | Notificaciones | Medio |
| Registros de auditoría | Actor, acción, entidad, cambios, IP, agente y fecha | Auditoría | Crítico |
| Base de datos MySQL | Persistencia física de todos los activos anteriores | Transversal | Crítico |
| Configuración y secretos de entorno | `APP_KEY`, conexión de base de datos y parámetros de producción | Infraestructura | Crítico |

Detalle y criterio: [02-risk-matrix.md](02-risk-matrix.md).

## 3. Análisis de riesgos

| Activo | Amenaza | Impacto | Probabilidad | Nivel de riesgo |
|---|---|---|---|---|
| Cuentas y roles | Acceso con credenciales comprometidas o abuso de privilegios | Crítico | Media | Alto |
| Cuentas y roles | Intentos repetidos de autenticación sin limitación confirmada | Alto | Media | Alto |
| Alcance de jefaturas | Manipulación de IDs para operar otro servicio | Crítico | Media | Alto |
| Datos del personal | Exposición no autorizada de identidad y contacto | Alto | Media | Alto |
| Asignaciones | Alteración indebida, traslape o pérdida de historial | Crítico | Media | Alto |
| Solicitudes | Revisión por actor fuera de alcance o transición indebida | Alto | Media | Alto |
| Reportes y exportaciones | Divulgación de datos mediante archivos exportados | Alto | Media | Alto |
| Auditoría | Modificación, eliminación o crecimiento sin política de retención | Crítico | Media | Alto |
| Base de datos | Pérdida de datos por fallo o error operativo | Crítico | Media | Alto |
| Aplicación | Explotación de dependencias con advisories documentados | Alto | Media | Alto |
| Configuración | Exposición de `APP_KEY`, credenciales o modo debug | Crítico | Baja/Media | Alto |
| Disponibilidad | Caída de aplicación, Nginx, PHP-FPM o MySQL | Alto | Media | Alto |
| Notificaciones | Borrado por eliminación del usuario debido a `cascadeOnDelete` | Medio | Baja | Medio |

La justificación completa y los controles asociados están en
[02-risk-matrix.md](02-risk-matrix.md).

## 4. Aplicación de la Tríada CIA

### Confidencialidad

MediTurno aplica autenticación por sesión, contraseñas con cast `hashed`,
cookies cifradas, middleware `auth`, comprobación de cuenta activa, roles,
Policies y alcance desde backend. El administrador mantiene acceso global; la
jefatura se limita por `service_managers`; el personal se limita por
`staff.user_id`. Las contraseñas y tokens de recuerdo se ocultan en la
serialización del modelo.

También existe protección CSRF sin exclusiones registradas en el middleware web.
El despliegue documentado prescribe `APP_DEBUG=false` y una URL HTTPS.

No hay evidencia confirmada de MFA, política institucional de contraseñas,
limitación de intentos de login, cabeceras de seguridad, gestión centralizada de
secretos o cifrado de datos sensibles en reposo. Esos puntos quedan
**PENDIENTE DE CONFIRMAR**.

### Integridad

La integridad se apoya en Form Requests, Policies, transacciones en operaciones
críticas, validación de traslapes mediante intervalos reales, estados
controlados en el dominio, restricciones de alcance, claves foráneas,
restricciones `restrictOnDelete`, índices, SoftDeletes y auditoría de cambios.

La cancelación de una asignación cambia primero su estado a `cancelled`, luego
aplica SoftDelete y registra auditoría. Además, la protección del último
administrador activo reduce el riesgo de bloqueo administrativo.

Las columnas `status` se almacenan como cadenas y sus conjuntos permitidos se
aplican en lógica de aplicación, no mediante restricciones `CHECK` o `ENUM`
observadas en las migraciones. La inmutabilidad técnica de `audit_logs` y su
retención están **PENDIENTE DE CONFIRMAR**.

### Disponibilidad

El proyecto dispone de Docker Compose para el entorno local, modo de
mantenimiento de Laravel, instrucciones de despliegue, cachés de producción,
migraciones, datos demo y pruebas automatizadas. Las claves foráneas y
SoftDeletes reducen eliminaciones accidentales.

No existe evidencia confirmada de backups, restauración probada, redundancia,
monitoreo, alertas, objetivos RTO/RPO, balanceo o plan de continuidad. La
disponibilidad de producción está **PENDIENTE DE CONFIRMAR**.

Análisis detallado: [03-cia-analysis.md](03-cia-analysis.md).

## 5. Controles de seguridad

| Riesgo | Control existente | Control recomendado | Estado |
|---|---|---|---|
| Acceso no autenticado | Sesión Laravel, `auth`, regeneración e invalidación de sesión | Mantener pruebas de sesión y revisar configuración segura de cookies en producción | Implementado |
| Acceso de cuenta inactiva | Validación antes del login y middleware `active` | Registrar y alertar intentos de cuentas desactivadas | Implementado |
| Acceso por rol incorrecto | `users.role`, middleware `role` y Policies | Mantener matriz formal de permisos alineada con DEC-013/014 | Implementado |
| Jefe fuerza IDs ajenos | `UserScopeService`, Requests y Policies | Añadir pruebas negativas a cada nueva operación por servicio | Implementado |
| Personal consulta datos ajenos | Filtro por `staff.user_id` y Policy de propiedad | Mantener pruebas de aislamiento horizontal | Implementado |
| CSRF | Middleware CSRF web sin exclusiones | Verificar cobertura en formularios y endpoints futuros | Implementado |
| Traslapes o intervalos inválidos | `ShiftConflictService` y `ShiftTimeService` | Mantener pruebas de concurrencia; evaluar bloqueo/constraint adicional | Implementado |
| Pérdida de trazabilidad | `AuditLogService`, SoftDeletes y auditoría de operaciones críticas | Definir retención, acceso, exportación e inmutabilidad | Parcial |
| Inconsistencia por fallo intermedio | Transacciones en operaciones críticas | Revisar transacciones ante nuevas operaciones compuestas | Implementado |
| Fuerza bruta en login | No hay evidencia confirmada de throttle en login | Incorporar rate limiting y registro de intentos | No implementado |
| Compromiso de credenciales | Hash de contraseña y mínimo de 8 caracteres | Definir política, MFA para admin/jefatura y gestión de sesiones | Parcial |
| Pérdida de base de datos | No hay evidencia confirmada de backup/restauración | Definir backups cifrados, retención y prueba de restauración | No implementado |
| Vulnerabilidades de dependencias | Auditorías Composer/npm documentadas | Aplicar actualizaciones dirigidas y repetir pruebas | Parcial |
| Exposición en producción | Guía prescribe HTTPS y `APP_DEBUG=false` | Validar TLS, cookies seguras, secretos y cabeceras antes del despliegue | Parcial |
| Interrupción del servicio | Docker y guía básica de despliegue | Monitoreo, alertas, RTO/RPO y procedimiento de recuperación | Parcial |

Matriz ampliada: [04-security-controls.md](04-security-controls.md).

## 6. Conclusiones

MediTurno posee una base de seguridad coherente con un proyecto de grado:
autenticación de sesión, autorización por rol y entidad, aislamiento por
servicio y usuario, protección CSRF, validación estructurada, transacciones,
integridad referencial, SoftDeletes y auditoría.

El estado no debe calificarse como seguridad de producción completa. Los vacíos
principales son controles operativos: rate limiting confirmado, MFA, política
formal de contraseñas, backups y restauración, monitoreo, gestión de incidentes,
retención e inmutabilidad de auditoría y validación de endurecimiento de
producción. También deben revisarse los advisories de Laravel y Vite/esbuild
documentados en el cierre del MVP.

Antes de entregar, conviene validar la matriz de riesgos con el tutor o la
institución, porque no se dispone de una clasificación institucional de datos,
un propietario formal por activo ni criterios cuantitativos de probabilidad e
impacto.

## Anexos

- Relación con módulos, actores y permisos:
  [05-annexes.md](05-annexes.md).
- Matriz de riesgos: [02-risk-matrix.md](02-risk-matrix.md).
- Aplicación detallada de CIA: [03-cia-analysis.md](03-cia-analysis.md).
- Controles: [04-security-controls.md](04-security-controls.md).
- Diagramas generales: `.ai/diagrams/general/use-cases.md`,
  `.ai/diagrams/general/class-diagram.md` y `.ai/diagrams/general/erd.md`.
- Decisiones: DEC-001, DEC-003, DEC-004 y DEC-008 a DEC-014 en
  `docs/decisions.md`.

