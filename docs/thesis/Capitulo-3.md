# CAPÍTULO III

# 3. [PENDIENTE: TÍTULO INSTITUCIONAL DEL CAPÍTULO III]

Este capítulo presenta los requerimientos, modelos, arquitectura, pruebas y
evidencia del prototipo MediTurno. La estructura 3.1 a 3.10 corresponde a la
solicitud de reconstrucción. Las figuras se mantienen como marcadores hasta
renderizar los archivos Mermaid o PlantUML existentes.

## 3.1 Requerimientos

### Actores del sistema

| Actor | Responsabilidad validada |
|---|---|
| Invitado | Acceder al formulario de login y autenticarse |
| Administrador | Gestionar globalmente usuarios, servicios, personal, jefaturas, plantillas y asignaciones; consultar calendario, reportes y auditoría |
| Jefe de Servicio | Gestionar asignaciones y consultar personal, calendario, reportes y solicitudes únicamente en servicios asociados |
| Personal de Salud | Consultar turnos propios, crear solicitudes y gestionar notificaciones propias |

### Requerimientos funcionales

| ID | Requerimiento funcional | Actor principal | Estado documentado | Evidencia |
|---|---|---|---|---|
| RF-01 | El sistema debe permitir login y logout mediante sesión web. | Todos | Implementado | FEAT-001 |
| RF-02 | El sistema debe mostrar un dashboard y opciones acordes con el rol y el estado activo. | Todos | Implementado | FEAT-001; análisis de autenticación |
| RF-03 | El Administrador debe gestionar usuarios, roles, estado activo y eliminación lógica. | Administrador | Implementado | FEAT-002; DEC-009 |
| RF-04 | El Administrador debe gestionar servicios hospitalarios. | Administrador | Implementado | FEAT-003 |
| RF-05 | El Administrador debe gestionar personal y filtrar por nombre, CI y servicio. | Administrador | Implementado | FEAT-005 |
| RF-06 | El sistema debe asociar opcionalmente personal con un usuario de rol `personal`. | Administrador | Implementado | DEC-010 |
| RF-07 | El Administrador debe asociar jefaturas con uno o varios servicios. | Administrador | Implementado | FEAT-004; DEC-006 |
| RF-08 | El Administrador debe gestionar plantillas globales de turno. | Administrador | Implementado | FEAT-006 |
| RF-09 | El Administrador debe configurar turnos específicos por servicio con valores heredados o personalizados. | Administrador | Implementado | FEAT-007; DEC-011 |
| RF-10 | El sistema debe crear, editar y cancelar asignaciones de turno. | Administrador, Jefe de Servicio | Implementado | FEAT-008; FEAT-019 |
| RF-11 | El sistema debe calcular `start_at` y `end_at`, incluyendo turnos nocturnos. | Sistema | Implementado | DEC-004 |
| RF-12 | El sistema debe impedir turnos traslapados y permitir turnos consecutivos. | Sistema | Implementado | FEAT-009; DEC-003 |
| RF-13 | La jefatura debe operar solo servicios, personal y plantillas dentro de su alcance. | Jefe de Servicio | Implementado | DEC-013; DEC-014 |
| RF-14 | La jefatura debe consultar disponibilidad antes de asignar. | Jefe de Servicio | Implementado | FEAT-020 |
| RF-15 | El sistema debe mostrar un calendario mensual global, por servicio o personal. | Administrador, Jefe de Servicio, Personal | Implementado | FEAT-010; FEAT-017; FEAT-018 |
| RF-16 | El calendario debe mostrar horario real, turno, servicio y color efectivo. | Todos | Implementado | Análisis del calendario |
| RF-17 | El sistema debe generar reportes por servicio y empleado, con rango de fechas, turnos y horas. | Administrador, Jefe de Servicio | Implementado | FEAT-011; FEAT-017 |
| RF-18 | Los reportes deben exportarse en CSV y PDF básico usando los mismos filtros. | Administrador, Jefe de Servicio | Implementado | FEAT-012; FEAT-013 |
| RF-19 | El Personal debe crear, consultar y cancelar solicitudes propias. | Personal de Salud | Implementado | FEAT-015 |
| RF-20 | El Administrador y la jefatura autorizada deben aprobar o rechazar solicitudes. | Administrador, Jefe de Servicio | Implementado | FEAT-015; DEC-013 |
| RF-21 | El sistema debe generar y mostrar notificaciones internas y su estado de lectura. | Todos | Implementado | FEAT-016 |
| RF-22 | El sistema debe auditar operaciones críticas con actor, acción, entidad y cambios. | Administrador como lector | Implementado | FEAT-014 |
| RF-23 | El sistema debe conservar cancelaciones y eliminaciones mediante estados y SoftDeletes. | Sistema | Implementado | DEC-012 |

Observación: la aprobación de una solicitud se documenta actualmente como una
decisión administrativa que no modifica automáticamente la asignación. Una
regla heredada contradice este comportamiento; CONFLICT-004 permanece
`PENDING CONFIRMATION`.

### Requerimientos no funcionales

| ID | Requerimiento no funcional | Estado | Evidencia |
|---|---|---|---|
| RNF-01 | La solución debe operar como aplicación web accesible desde navegador. | Implementado | README; Blade y rutas web |
| RNF-02 | La autenticación debe usar sesiones y contraseñas almacenadas mediante hash. | Implementado | Análisis de autenticación; modelo `User` |
| RNF-03 | La autorización debe aplicar rol, cuenta activa, Policies y alcance backend. | Implementado | DEC-001; DEC-013; DEC-014 |
| RNF-04 | Las entradas deben validarse mediante Form Requests y reglas backend. | Implementado | Arquitectura validada |
| RNF-05 | Las operaciones críticas deben usar transacciones. | Implementado | Arquitectura; DEC-012; DEC-014 |
| RNF-06 | Las entidades administrables deben conservar historial mediante SoftDeletes. | Implementado | Modelos y migraciones; reglas del proyecto |
| RNF-07 | Las relaciones deben mantener integridad mediante claves foráneas e índices. | Implementado | Migraciones y ERD |
| RNF-08 | Las operaciones críticas deben registrar auditoría. | Implementado | FEAT-014 |
| RNF-09 | La interfaz debe utilizar Blade y Bootstrap 5 y mantener navegación adaptable. | Implementado documentalmente | README; QA |
| RNF-10 | El calendario debe actualizarse por recarga o consulta, sin WebSockets. | Implementado | DEC-007 |
| RNF-11 | El entorno local debe ser reproducible con Docker Compose, Nginx, PHP-FPM y MySQL. | Implementado documentalmente | README |
| RNF-12 | El sistema debe disponer de pruebas automatizadas y checklist manual para defensa. | Disponible; ejecución actual pendiente | Inventario; `docs/qa-checklist.md` |
| RNF-13 | La configuración de producción debe usar `APP_DEBUG=false`, `APP_KEY` y HTTPS. | Parcial; despliegue real pendiente | `docs/deploy.md` |
| RNF-14 | Deben revisarse vulnerabilidades de dependencias antes del despliegue. | Pendiente de verificación actual | README; GAP-006 |

No se atribuyen métricas de rendimiento, disponibilidad, tiempo de respuesta o
concurrencia porque no existen resultados validados.

## 3.2 Casos de Uso

### Diagrama general

[Insertar Figura 1: Diagrama General de Casos de Uso]

**Descripción.** La figura presenta los actores Invitado, Administrador, Jefe de
Servicio y Personal de Salud, y relaciona cada actor con las funciones
principales permitidas.

**Fuente:** Elaboración propia (2026).  
**Archivos:** `.ai/diagrams/01-general/01-general-use-case-mermaid.mmd` y
`.ai/diagrams/01-general/01-general-use-case-plantuml.puml`.

### Autenticación y Dashboard

[Insertar Figura 4: Casos de Uso de Autenticación y Dashboard]

| ID | Actor | Objetivo | Precondición | Flujo y alternativa | Postcondición |
|---|---|---|---|---|---|
| AUTH-01 | Invitado | Abrir login | Sin sesión autenticada | Solicita formulario; si ya tiene sesión, se redirige | Formulario visible |
| AUTH-02 | Invitado | Autenticarse | Cuenta existente | Valida credenciales y estado; rechaza datos inválidos o cuenta inactiva | Sesión iniciada |
| AUTH-03 | Usuario activo | Ver dashboard | Sesión y rol válidos | Comprueba acceso y carga vista del rol; acceso inválido se deniega | Dashboard visible |
| AUTH-04 | Usuario autenticado | Cerrar sesión | Sesión vigente | Cierra e invalida sesión | Usuario vuelve al login |

Reglas relacionadas: DEC-001, autenticación obligatoria y cuenta activa.  
Evidencia: `.ai/diagrams/02-authentication-dashboard/05-use-cases.md`.

### Usuarios

[Insertar Figura 8: Casos de Uso de Usuarios]

| ID | Actor | Objetivo | Precondición | Flujo y alternativa | Postcondición |
|---|---|---|---|---|---|
| USR-01 | Administrador | Listar usuarios | Rol `admin` | Autoriza y pagina; otros roles se rechazan | Listado visible |
| USR-02 | Administrador | Crear usuario | Autorización | Valida email y rol, crea y audita; duplicados se rechazan | Cuenta creada |
| USR-03 | Administrador | Editar usuario | Usuario existente | Valida, actualiza y audita; errores conservan datos | Cuenta actualizada |
| USR-04 | Administrador | Cambiar estado | Usuario existente | Protege al último admin y la autodesactivación | Estado actualizado o rechazo |
| USR-05 | Administrador | Eliminar lógicamente | Usuario no eliminado | Aplica DEC-009, SoftDelete y auditoría | `deleted_at` definido o rechazo |

Reglas relacionadas: DEC-001 y DEC-009.  
Evidencia: `.ai/diagrams/03-users/05-use-cases.md`.

### Servicios Hospitalarios

[Insertar Figura 12: Casos de Uso de Servicios Hospitalarios]

| ID | Actor | Objetivo | Precondición | Flujo y alternativa | Postcondición |
|---|---|---|---|---|---|
| HOS-01 | Administrador | Listar servicios | Rol `admin` | Consulta no eliminados; otros roles no acceden al CRUD | Catálogo visible |
| HOS-02 | Administrador | Crear servicio | Autorización | Valida nombre único, crea y audita | Servicio creado |
| HOS-03 | Administrador | Editar servicio | Servicio existente | Valida unicidad y actualiza; duplicados se rechazan | Servicio actualizado |
| HOS-04 | Administrador | Activar/desactivar | Servicio existente | Actualiza en transacción y audita | Estado actualizado |
| HOS-05 | Administrador | Eliminar lógicamente | Servicio existente | Aplica SoftDelete; dependencias pueden impedir operaciones relacionadas | Servicio retirado lógicamente |

Reglas relacionadas: DEC-005, unicidad entre no eliminados y SoftDeletes.  
Evidencia: `.ai/diagrams/04-hospital-services/05-use-cases.md`.

### Personal de Salud

[Insertar Figura 16: Casos de Uso de Personal de Salud]

| ID | Actor | Objetivo | Precondición | Flujo y alternativa | Postcondición |
|---|---|---|---|---|---|
| STF-01 | Administrador | Listar y filtrar | Rol `admin` | Filtra por nombre, CI o servicio; sin coincidencias devuelve vacío | Resultados visibles |
| STF-02 | Administrador | Crear personal | Servicio válido | Valida CI, servicio y usuario `personal`; duplicados se rechazan | Personal creado |
| STF-03 | Administrador | Editar personal | Registro existente | Valida y actualiza; fallos conservan datos | Personal actualizado |
| STF-04 | Administrador | Cambiar estado | Registro existente | Actualiza y audita | Estado actualizado |
| STF-05 | Administrador | Eliminar lógicamente | Registro existente | Aplica SoftDelete y auditoría | Registro retirado |
| STF-06 | Jefe de Servicio | Consultar personal administrado | Servicios asociados | Limita consulta; servicios ajenos no pueden forzarse | Lista restringida |

Reglas relacionadas: DEC-005, DEC-010, DEC-013 y DEC-014.  
Evidencia: `.ai/diagrams/05-staff/05-use-cases.md`.

### Jefaturas por Servicio

[Insertar Figura 20: Casos de Uso de Jefaturas por Servicio]

| ID | Actor | Objetivo | Precondición | Flujo y alternativa | Postcondición |
|---|---|---|---|---|---|
| MGR-01 | Administrador | Listar asociaciones | Rol `admin` | Consulta asociaciones activas | Alcances visibles |
| MGR-02 | Administrador | Crear asociación | Usuario y servicio válidos | Evita par duplicado, crea y audita | Alcance creado |
| MGR-03 | Administrador | Eliminar asociación | Asociación activa | Aplica SoftDelete y audita | Alcance retirado |
| MGR-04 | Jefe de Servicio | Consumir alcance | Asociación activa | Limita consultas y operaciones; IDs ajenos se rechazan | Acceso restringido |

Reglas relacionadas: DEC-006, DEC-013 y DEC-014.  
Evidencia: `.ai/diagrams/06-service-managers/05-use-cases.md`.

### Plantillas de Turno

[Insertar Figura 24: Casos de Uso de Plantillas de Turno]

| ID | Actor | Objetivo | Precondición | Flujo y alternativa | Postcondición |
|---|---|---|---|---|---|
| SHT-01 | Administrador | Listar plantillas | Rol `admin` | Consulta plantillas globales y por servicio | Configuración visible |
| SHT-02 | Administrador | Crear plantilla global | Autorización | Valida código/nombre y horario; duplicados se rechazan | Plantilla creada |
| SHT-03 | Administrador | Editar plantilla | Plantilla existente | Valida, actualiza y audita | Plantilla actualizada |
| SHT-04 | Administrador | Cambiar estado/eliminar | Plantilla existente | Actualiza o aplica SoftDelete; efecto histórico está pendiente | Plantilla retirada o inactiva |
| SST-01 | Administrador | Configurar por servicio | Servicio y plantilla existentes | Evita asociación duplicada y guarda | Turno habilitado |
| SST-02 | Administrador | Personalizar por servicio | Configuración existente | Exige ambas horas; vacíos heredan valores globales | Personalización guardada |

Reglas relacionadas: DEC-004, DEC-005 y DEC-011.  
Evidencia: `.ai/diagrams/07-shift-templates/05-use-cases.md`.

### Asignaciones

[Insertar Figura 28: Casos de Uso de Asignaciones]

| ID | Actor | Objetivo | Precondición | Flujo y alternativa | Postcondición |
|---|---|---|---|---|---|
| ASN-01 | Administrador/Jefe | Listar asignaciones | Rol permitido | Determina alcance y filtra; IDs ajenos se rechazan | Listado autorizado |
| ASN-02 | Administrador/Jefe | Crear asignación | Entidades activas y relacionadas | Calcula intervalo, comprueba conflicto, crea `assigned`; traslapes se rechazan | Asignación creada |
| ASN-03 | Administrador/Jefe | Editar asignación | No cancelada/eliminada | Recalcula, excluye registro actual y guarda `changed` | Asignación actualizada |
| ASN-04 | Administrador/Jefe | Cancelar asignación | Registro operable | Cambia a `cancelled`, aplica SoftDelete y audita | Asignación cancelada |
| ASN-05 | Jefe de Servicio | Consultar disponibilidad | Alcance válido | Calcula intervalo y consulta conflicto; IDs ajenos se rechazan | Resultado informativo |

Reglas relacionadas: DEC-003, DEC-004, DEC-012 y DEC-014.  
Evidencia: `.ai/diagrams/08-shift-assignments/05-use-cases.md`.

### Calendario

[Insertar Figura 32: Casos de Uso del Calendario]

| ID | Actor | Objetivo | Precondición | Flujo y alternativa | Postcondición |
|---|---|---|---|---|---|
| CAL-01 | Administrador/Jefe/Personal | Abrir calendario | Sesión y rol válidos | Determina alcance y carga mes; sin perfil/servicio muestra vacío | Calendario visible |
| CAL-02 | Administrador/Jefe/Personal | Navegar meses | Calendario abierto | Cambia rango y consulta eventos | Nuevo mes visible |
| CAL-03 | Administrador/Jefe | Filtrar | Opciones autorizadas | Valida servicio/personal; IDs ajenos no producen datos | Calendario filtrado |
| CAL-04 | Administrador/Jefe/Personal | Obtener eventos | Rango válido | Incluye `assigned/changed`, excluye cancelados/eliminados | Eventos autorizados |
| CAL-05 | Administrador/Jefe/Personal | Ver detalle | Evento visible | Abre modal de solo lectura; no permite edición rápida | Detalle visible |

Reglas relacionadas: DEC-007, DEC-013 y DEC-014.  
Evidencia: `.ai/diagrams/09-calendar/05-use-cases.md`.

### Reportes

[Insertar Figura 35: Casos de Uso de Reportes]

| ID | Actor | Objetivo | Precondición | Flujo y alternativa | Postcondición |
|---|---|---|---|---|---|
| REP-01 | Administrador/Jefe | Consultar reporte | Filtros y alcance válidos | Consulta intervalos, calcula horas y agrupa; sin datos devuelve resumen vacío | Reporte HTML visible |
| REP-02 | Administrador/Jefe | Exportar CSV | Filtros válidos | Reutiliza consulta y genera archivo | CSV descargable |
| REP-03 | Administrador/Jefe | Exportar PDF | Filtros válidos | Reutiliza resultados y renderiza documento | PDF descargable |

Reglas relacionadas: incluir `assigned/changed`, excluir
`cancelled`/SoftDeleted y calcular desde `start_at/end_at`.  
Evidencia: `.ai/diagrams/10-reports/05-use-cases.md`.

### Solicitudes de Cambio

[Insertar Figura 38: Casos de Uso de Solicitudes de Cambio]

| ID | Actor | Objetivo | Precondición | Flujo y alternativa | Postcondición |
|---|---|---|---|---|---|
| SCR-01 | Personal | Listar propias | Usuario asociado | Consulta por solicitante | Historial propio visible |
| SCR-02 | Personal | Crear solicitud | Asignación propia permitida | Crea `pending`, audita y notifica; asignaciones ajenas/canceladas se rechazan | Solicitud pendiente |
| SCR-03 | Personal | Consultar propia | Propiedad | Autoriza y muestra detalle; ajenas se deniegan | Detalle visible |
| SCR-04 | Personal | Cancelar propia | Estado `pending` | Cambia a `cancelled` y audita; otros estados se rechazan | Solicitud cancelada |
| SCR-05 | Administrador/Jefe | Listar para revisión | Rol y alcance | Consulta global o por servicios | Bandeja autorizada |
| SCR-06 | Administrador/Jefe | Aprobar/rechazar | Solicitud `pending` autorizada | Actualiza estado y revisor, audita y notifica | Solicitud resuelta |
| SCR-07 | Administrador | Consultar auditoría | Rol `admin` | Localiza eventos de la solicitud | Historial visible |

Reglas relacionadas: DEC-008 y CONFLICT-004.  
Evidencia: `.ai/diagrams/11-shift-change-requests/05-use-cases.md`.

### Notificaciones

[Insertar Figura 42: Casos de Uso de Notificaciones]

| ID | Actor | Objetivo | Precondición | Flujo y alternativa | Postcondición |
|---|---|---|---|---|---|
| NTF-01 | Usuario activo | Listar propias | Sesión válida | Filtra por usuario; sin mensajes devuelve vacío | Lista visible |
| NTF-02 | Usuario activo | Marcar una leída | Propiedad | Establece `read_at`; notificación ajena se rechaza | Mensaje leído |
| NTF-03 | Usuario activo | Marcar todas leídas | Sesión válida | Actualiza no leídas propias | Bandeja leída |
| NTF-04 | Usuario destinatario | Recibir aviso | Evento de solicitud | Determina destinatarios y crea mensaje; canales externos no aplican | Notificación pendiente |

Reglas relacionadas: propiedad por usuario y notificaciones externas Post-MVP.  
Evidencia: `.ai/diagrams/12-notifications/05-use-cases.md`.

### Auditoría

[Insertar Figura 46: Casos de Uso de Auditoría]

| ID | Actor | Objetivo | Precondición | Flujo y alternativa | Postcondición |
|---|---|---|---|---|---|
| AUD-01 | Administrador | Listar eventos | Rol `admin` | Consulta registros; otros roles no acceden globalmente | Listado visible |
| AUD-02 | Administrador | Ver detalle | Evento existente | Muestra actor, acción, entidad, cambios y metadatos | Detalle visible |
| AUD-03 | Actor autorizado, indirecto | Registrar operación | Operación crítica | Captura y guarda evidencia en la transacción; reportes no se auditan | Evento persistido |

Reglas relacionadas: auditoría temprana, centralizada y transaccional.  
Evidencia: `.ai/diagrams/13-audit/05-use-cases.md`.

### Diagramas de actividad y estados asociados

Los siguientes diagramas complementan los casos de uso mediante flujos de
actividad y ciclos de estado. Se conservan dentro de 3.2 porque la estructura
institucional proporcionada no define una sección independiente para ellos.

[Insertar Figura 5: Actividad de Autenticación]

Representa la validación de credenciales, estado activo y creación de sesión.

[Insertar Figura 7: Estados de Sesión]

Representa las transiciones entre sesión no autenticada, autenticada e
invalidada.

[Insertar Figura 9: Actividad de Gestión de Usuarios]

Representa validación, persistencia y auditoría de una operación administrativa.

[Insertar Figura 11: Estados del Usuario]

Representa usuario activo, inactivo y eliminado lógicamente.

[Insertar Figura 13: Actividad de Gestión de Servicios]

Representa validación, escritura transaccional y auditoría.

[Insertar Figura 15: Estados del Servicio]

Representa servicio activo, inactivo y eliminado lógicamente.

[Insertar Figura 17: Actividad de Gestión de Personal]

Representa validación del servicio, CI y asociación opcional de usuario.

[Insertar Figura 19: Estados del Personal]

Representa personal activo, inactivo y eliminado lógicamente.

[Insertar Figura 21: Actividad de Asociación de Jefatura]

Representa la validación y creación de una relación usuario-servicio.

[Insertar Figura 23: Estados de la Asociación de Jefatura]

Representa asociación activa y eliminada lógicamente.

[Insertar Figura 25: Actividad de Configuración de Turnos]

Representa validación de horarios y configuración global o por servicio.

[Insertar Figura 27: Estados de Plantilla]

Representa plantilla activa, inactiva y eliminada lógicamente.

[Insertar Figura 29: Actividad de Asignación]

Representa alcance, cálculo de intervalo, conflicto, persistencia y auditoría.

[Insertar Figura 31: Estados de Asignación]

Representa `assigned`, `changed` y `cancelled`.

[Insertar Figura 33: Actividad de Consulta del Calendario]

Representa filtros de alcance, consulta y presentación de eventos.

[Insertar Figura 36: Actividad de Generación de Reporte]

Representa validación de filtros, consulta, agrupación y formato de salida.

[Insertar Figura 39: Actividad de Solicitud y Revisión]

Representa creación, revisión administrativa y notificación.

[Insertar Figura 41: Estados de Solicitud]

Representa transiciones desde `pending` hacia `approved`, `rejected` o
`cancelled`.

[Insertar Figura 43: Actividad de Notificaciones]

Representa consulta y marcación de lectura con validación de propiedad.

[Insertar Figura 45: Estados de Notificación]

Representa notificación no leída y leída.

[Insertar Figura 47: Actividad de Auditoría]

Representa la captura y persistencia de evidencia durante una operación crítica.

Calendario, Reportes y Auditoría no tienen diagrama de estados porque no poseen
un ciclo de vida propio confirmado en el análisis. Las fuentes de estas figuras
se encuentran en las carpetas numeradas de `.ai/diagrams/`.

## 3.3 Diagrama de Clases

[Insertar Figura 2: Diagrama General de Clases del Dominio]

El diagrama de clases representa las entidades principales:

- `User`;
- `HospitalService`;
- `Staff`;
- `ServiceManager`;
- `ShiftTemplate`;
- `ServiceShiftTemplate`;
- `ShiftAssignment`;
- `ShiftChangeRequest`;
- `InternalNotification`;
- `AuditLog`.

Las relaciones principales vinculan usuarios con personal, jefaturas,
solicitudes, notificaciones y auditoría; servicios con personal, turnos por
servicio y asignaciones; plantillas globales con configuraciones por servicio; y
asignaciones con personal, servicios, configuraciones y solicitudes.

El modelo de dominio también incluye servicios que encapsulan reglas:
`ShiftTimeService`, `ShiftConflictService`, `UserScopeService`,
`ShiftCalendarService`, `ReportService`, `ShiftChangeRequestService`,
`NotificationService` y `AuditLogService`. Estos servicios no son tablas.

**Fuente:** Elaboración propia (2026).  
**Archivos:** `.ai/diagrams/01-general/02-domain-class-mermaid.mmd` y
`.ai/diagrams/01-general/02-domain-class-plantuml.puml`.

## 3.4 Diagrama Relacional

[Insertar Figura 3: Diagrama Entidad-Relación de apoyo]

El ERD documentado representa las diez tablas principales del dominio y sus
claves foráneas. Fue elaborado a partir de migraciones, modelos Eloquent y
relaciones confirmadas. Por esa procedencia sirve como apoyo técnico, pero no
cumple por sí solo la exigencia docente de obtener el diagrama desde el sistema
gestor.

**Fuente:** Elaboración propia (2026).  
**Archivos:** `.ai/diagrams/01-general/03-erd-mermaid.mmd` y
`.ai/diagrams/01-general/03-erd-plantuml.puml`.

[PENDIENTE: sustituir o acompañar la Figura 3 con el EER oficial generado
mediante ingeniería inversa desde el esquema real en MySQL Workbench. Guardar el
archivo `.mwb` y exportar una imagen o PDF legible.]

Las tablas técnicas `password_reset_tokens`, `failed_jobs`,
`personal_access_tokens` y `migrations` no aparecen en el ERD de apoyo. La
exportación desde el gestor permitirá confirmar el esquema físico completo.

## 3.5 Arquitectura

MediTurno utiliza una arquitectura Laravel MVC con separación de
responsabilidades.

| Capa | Componentes | Responsabilidad |
|---|---|---|
| Presentación | Blade, Bootstrap 5, FullCalendar y JavaScript | Formularios, navegación, calendarios y visualización |
| Aplicación | Controllers, Form Requests, Policies y middleware | Recibir peticiones, validar, autorizar y coordinar casos de uso |
| Dominio | Servicios de tiempo, conflictos, alcance, reportes, solicitudes, notificaciones y auditoría | Reglas críticas reutilizables |
| Persistencia | Modelos Eloquent, migraciones, MySQL 8, FKs, índices y SoftDeletes | Almacenar y relacionar datos |
| Infraestructura local | Docker Compose, Nginx, PHP-FPM y MySQL | Ejecución reproducible |

### Principios aplicados

- controladores orientados a petición y respuesta;
- validaciones mediante Form Requests;
- autorización mediante roles, Policies y alcance backend;
- modelos Eloquent para relaciones;
- servicios para reglas críticas;
- transacciones en operaciones compuestas;
- auditoría centralizada;
- eliminación lógica en entidades administrables.

### Flujo resumido

1. El actor envía una petición desde una vista Blade.
2. El middleware comprueba autenticación, cuenta activa y rol.
3. El Form Request valida datos y alcance.
4. El controlador coordina modelos y servicios de dominio.
5. La operación crítica se ejecuta en transacción.
6. Se registra auditoría cuando corresponde.
7. El sistema devuelve una vista, redirección, JSON o exportación.

Fuente: `.ai/rules/architecture.md`,
`.ai/analysis/00-project-inventory.md` y `.ai/diagrams/general/class-diagram.md`.

## 3.6 Diagramas de Secuencia

Los diagramas de secuencia representan la interacción temporal entre actores,
interfaz, controladores, servicios y persistencia.

### Autenticación

[Insertar Figura 6: Secuencia de Autenticación]

Representa validación de credenciales, comprobación de cuenta activa, creación
de sesión y respuesta.

### Usuarios

[Insertar Figura 10: Secuencia de Gestión de Usuarios]

Representa autorización, validación, transacción, persistencia y auditoría.

### Servicios Hospitalarios

[Insertar Figura 14: Secuencia de Gestión de Servicios]

Representa la interacción entre Administrador, controlador, modelo y auditoría.

### Personal de Salud

[Insertar Figura 18: Secuencia de Gestión de Personal]

Representa validación de CI, servicio, usuario opcional y escritura auditada.

### Jefaturas por Servicio

[Insertar Figura 22: Secuencia de Asociación de Jefatura]

Representa la creación o retiro de la relación usuario-servicio.

### Plantillas de Turno

[Insertar Figura 26: Secuencia de Configuración de Turnos]

Representa validación de horarios y configuración global o por servicio.

### Asignaciones

[Insertar Figura 30: Secuencia de Asignación de Turno]

Representa alcance, cálculo temporal, detección de conflicto, transacción y
auditoría.

### Calendario

[Insertar Figura 34: Secuencia de Consulta del Calendario]

Representa la solicitud del rango, aplicación de filtros y devolución de
eventos autorizados.

### Reportes

[Insertar Figura 37: Secuencia de Generación de Reporte]

Representa validación de filtros, consulta, agrupación y salida HTML, CSV o PDF.

### Solicitudes de Cambio

[Insertar Figura 40: Secuencia de Solicitud y Revisión]

Representa creación, revisión, auditoría y notificación.

### Notificaciones

[Insertar Figura 44: Secuencia de Notificaciones]

Representa validación de propiedad, consulta y actualización de `read_at`.

### Auditoría

[Insertar Figura 48: Secuencia de Auditoría]

Representa captura de actor, acción, entidad, valores y metadatos durante una
operación crítica.

Las fuentes Mermaid y PlantUML se encuentran en las carpetas numeradas de
`.ai/diagrams/`.

## 3.7 Diagramas de Componentes

[PENDIENTE]

No existe un diagrama de componentes validado en `.ai/diagrams/`. La
arquitectura documenta capas y componentes técnicos, pero convertir esa
información en un nuevo diagrama excede esta reconstrucción y requiere una fase
autorizada de representación gráfica.

## 3.8 Pruebas de Calidad

Existe un checklist manual para verificar el MVP y una suite automatizada
registrada en el inventario del proyecto. La Knowledge Base aclara que no se
ejecutaron pruebas durante su captura, por lo que el resultado actual permanece
pendiente.

### Preparación documentada

```bash
docker compose up -d
docker compose exec app php artisan migrate:fresh --seed
npm run build
docker compose exec app php artisan test
```

### Cobertura manual

| Área | Verificaciones principales | Estado actual |
|---|---|---|
| Administrador | Login, CRUD, estados, asignaciones, conflictos, calendario, reportes y auditoría | [PENDIENTE: ejecución fechada] |
| Jefe de Servicio | Alcance, asignaciones, disponibilidad, calendario, reportes y solicitudes | [PENDIENTE: ampliar y ejecutar checklist] |
| Personal de Salud | Turnos propios, solicitudes propias y notificaciones | [PENDIENTE: ejecución fechada] |
| Seguridad | Rutas por rol, propiedad, CSRF, estados, auditoría y SoftDeletes | [PENDIENTE: ejecución fechada] |
| Dependencias | `composer audit` y `npm audit` | [PENDIENTE: resultado actual] |

### Casos críticos

- rechazar turnos traslapados;
- permitir turnos consecutivos;
- calcular turnos nocturnos;
- impedir que jefatura fuerce servicios ajenos;
- impedir que personal consulte información ajena;
- proteger al último Administrador activo;
- cancelar asignaciones con estado, SoftDelete y auditoría;
- generar reportes con horas basadas en timestamps reales;
- mantener la propiedad de notificaciones.

### Resultado

[PENDIENTE: adjuntar salida actual de pruebas automatizadas, fecha, entorno,
número de pruebas y resultado del recorrido manual.]

Fuente: `docs/qa-checklist.md`,
`.ai/knowledge-base/features.md` y `.ai/analysis/00-project-inventory.md`.

## 3.9 Documentación del Prototipo

El prototipo dispone de datos demo para servicios, turnos, personal,
asignaciones, solicitudes, notificaciones y auditoría.

| Módulo | Evidencia funcional disponible | Captura requerida |
|---|---|---|
| Autenticación y Dashboard | Login, logout y dashboard por rol | [PENDIENTE: captura] |
| Usuarios | Gestión administrativa | [PENDIENTE: captura] |
| Servicios Hospitalarios | Catálogo y estados | [PENDIENTE: captura] |
| Personal de Salud | CRUD, filtros y servicio | [PENDIENTE: captura] |
| Jefaturas por Servicio | Asociaciones usuario-servicio | [PENDIENTE: captura] |
| Plantillas de Turno | Plantillas y configuración por servicio | [PENDIENTE: captura] |
| Asignaciones | Gestión, conflictos y disponibilidad | [PENDIENTE: captura] |
| Calendario | Vista mensual y detalle | [PENDIENTE: captura] |
| Reportes | Vista HTML, CSV y PDF | [PENDIENTE: captura] |
| Solicitudes de Cambio | Flujo personal y revisión | [PENDIENTE: captura] |
| Notificaciones | Bandeja y estado de lectura | [PENDIENTE: captura] |
| Auditoría | Listado y detalle | [PENDIENTE: captura] |

No se encontraron capturas del prototipo identificadas como evidencia académica.
No se insertan imágenes no verificadas.

### Flujo demostrable documentado

1. El Administrador inicia sesión y muestra la configuración base.
2. Gestiona servicios, personal, jefaturas y turnos.
3. Muestra asignaciones y reglas de conflicto.
4. Consulta el calendario mensual.
5. Genera reportes HTML, CSV y PDF.
6. Consulta auditoría.
7. El Personal crea una solicitud.
8. El Jefe de Servicio revisa la solicitud de su servicio.
9. El Personal recibe una notificación.

La guía demo actual no cubre completamente las ampliaciones operativas de
jefatura descritas en DEC-014.

Fuente: `docs/demo-flow.md`, `README.md` y CONFLICT-011.

## 3.10 Resultados Esperados

Con base en las funcionalidades implementadas, se espera que MediTurno permita:

1. centralizar la información de usuarios, servicios, personal, turnos y
   asignaciones;
2. separar el acceso global, el alcance por servicio y la consulta personal;
3. detectar traslapes antes de guardar una asignación;
4. representar correctamente turnos diurnos, consecutivos y nocturnos;
5. consultar asignaciones mediante calendarios mensuales;
6. obtener resúmenes y detalles por servicio o empleado;
7. exportar reportes en CSV y PDF;
8. conservar trazabilidad mediante auditoría, estados y SoftDeletes;
9. gestionar solicitudes y notificaciones internas;
10. demostrar el flujo funcional con datos demo.

Estos resultados describen capacidades esperadas y documentadas del sistema. No
constituyen evidencia de impacto institucional, reducción porcentual de errores,
ahorro de tiempo o mejora clínica.

[PENDIENTE: ejecutar QA actual, aplicar entrevistas y medir resultados para
comparar el proceso previo con el prototipo.]
