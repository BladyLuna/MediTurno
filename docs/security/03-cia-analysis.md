# Análisis de la Tríada CIA

## 1. Confidencialidad

| Medida observada | Aplicación en MediTurno | Evidencia | Estado |
|---|---|---|---|
| Autenticación por sesión | Credenciales validadas mediante autenticación nativa; la sesión se regenera al ingresar y se invalida al salir | `LoginController`; README | Implementado |
| Hash de contraseñas | `User.password` usa cast `hashed` y se oculta de la serialización | `app/Models/User.php` | Implementado |
| Cookies cifradas | El grupo web incluye `EncryptCookies` sin excepciones observadas | `app/Http/Kernel.php`; `EncryptCookies.php` | Implementado |
| Cuenta activa | Login rechaza usuarios inactivos y `active` cierra sesiones de usuarios desactivados | `LoginController`; `EnsureUserIsActive.php` | Implementado |
| Autorización por rol | Roles oficiales en `users.role`; middleware `role` y Policies | DEC-001; `CheckRole.php`; análisis de permisos | Implementado |
| Autorización horizontal | Jefatura limitada por `service_managers`; personal por `staff.user_id` | DEC-013/014; `UserScopeService` | Implementado |
| Propiedad de notificaciones | Policy restringe lectura y actualización al destinatario | `.ai/analysis/modules/notifications/05-permissions.md` | Implementado |
| Protección CSRF | Middleware CSRF habilitado sin rutas exceptuadas observadas | `app/Http/Kernel.php`; `VerifyCsrfToken.php` | Implementado |
| HTTPS en producción | La guía de despliegue usa URL HTTPS | `docs/deploy.md` | Parcial: configuración real pendiente |
| MFA | No existe evidencia en fuentes autorizadas | PENDIENTE DE CONFIRMAR | No implementado según evidencia |
| Rate limiting del login | El análisis lo conserva como pendiente | `.ai/analysis/modules/authentication-dashboard/11-pending.md` | PENDIENTE DE CONFIRMAR |
| Clasificación y cifrado de datos en reposo | No existe evidencia suficiente | PENDIENTE DE CONFIRMAR | PENDIENTE DE CONFIRMAR |

### Evaluación

La confidencialidad de aplicación es adecuada para el alcance académico porque
combina autenticación, autorización vertical y horizontal. El riesgo residual
principal se concentra en credenciales privilegiadas, exportaciones descargadas,
datos personales sin clasificación formal y endurecimiento de producción no
verificado.

## 2. Integridad

| Medida observada | Aplicación en MediTurno | Evidencia | Estado |
|---|---|---|---|
| Validación de entrada | Form Requests validan creación, edición, filtros y operaciones por rol | Inventario; controladores y Requests referenciados por análisis | Implementado |
| Policies | Nueve Policies protegen entidades y propiedad | `.ai/analysis/00-project-inventory.md`; análisis de permisos | Implementado |
| Transacciones | Crear, editar y cancelar operaciones críticas se ejecuta transaccionalmente | DEC-012/014; controladores; `ShiftChangeRequestService` | Implementado |
| Integridad temporal | Se prohíben traslapes y se permiten intervalos consecutivos | DEC-003; `ShiftConflictService` | Implementado |
| Turnos nocturnos | `start_at` y `end_at` representan el intervalo real entre días | DEC-004; `ShiftTimeService` | Implementado |
| Estados de dominio | Asignaciones y solicitudes usan constantes y flujos definidos | DEC-008; modelos | Implementado en aplicación |
| Integridad referencial | Claves foráneas con `restrictOnDelete`, `nullOnDelete` y `cascadeOnDelete` según relación | Migraciones | Implementado |
| Conservación lógica | Entidades administrables principales usan SoftDeletes | Modelos y migraciones | Implementado |
| Auditoría | Guarda actor, acción, entidad, cambios, IP, agente y fecha | `AuditLogService`; migración `audit_logs` | Implementado |
| Protección administrativa | Se conserva al menos un admin activo y se impide autodesactivación/eliminación | DEC-009 | Implementado |
| Restricción física de estados | Las migraciones usan columnas string sin `CHECK`/`ENUM` observado | Migraciones | Parcial |
| Inmutabilidad de auditoría | No existe evidencia de controles contra alteración directa en base de datos | PENDIENTE DE CONFIRMAR | PENDIENTE DE CONFIRMAR |

### Evaluación

La integridad es el componente más desarrollado. Las reglas temporales,
transacciones, relaciones y auditoría están alineadas con el dominio. Persisten
riesgos de concurrencia, controles físicos de estados y protección independiente
de logs que no están documentados.

## 3. Disponibilidad

| Medida observada | Aplicación en MediTurno | Evidencia | Estado |
|---|---|---|---|
| Entorno reproducible | Docker Compose integra aplicación, Nginx y MySQL | README; inventario | Implementado para local/demo |
| Modo mantenimiento | Middleware estándar de mantenimiento habilitado | `app/Http/Kernel.php` | Implementado |
| Preparación de despliegue | Guía incluye dependencias, variables, cachés, permisos y verificación | `docs/deploy.md` | Parcial |
| Pruebas y datos demo | Comandos de migración, seed y pruebas documentados | README | Implementado para verificación |
| Eliminación lógica | SoftDeletes reduce pérdida accidental en entidades principales | Modelos y migraciones | Implementado |
| Índices | Campos de consulta y relaciones principales están indexados | Migraciones; ERD | Implementado |
| Backups | No hay procedimiento confirmado | PENDIENTE DE CONFIRMAR | No implementado según evidencia |
| Restauración probada | No hay evidencia de simulacro o validación | PENDIENTE DE CONFIRMAR | No implementado según evidencia |
| Monitoreo y alertas | No hay evidencia confirmada | PENDIENTE DE CONFIRMAR | No implementado según evidencia |
| RTO/RPO | No están definidos | PENDIENTE DE CONFIRMAR | No implementado según evidencia |
| Redundancia y alta disponibilidad | No hay evidencia confirmada | PENDIENTE DE CONFIRMAR | Fuera del alcance observado |

### Evaluación

La disponibilidad cubre reproducibilidad y operación básica de demostración, no
continuidad de negocio. Para producción se requiere definir respaldo,
restauración, monitoreo, responsables y objetivos de recuperación.

## Balance CIA

| Dimensión | Madurez estimada | Justificación |
|---|---|---|
| Confidencialidad | Media | Buen aislamiento por rol y alcance; faltan controles de credenciales y endurecimiento confirmado. |
| Integridad | Media-Alta | Reglas, transacciones, FKs, SoftDeletes y auditoría; faltan controles físicos e inmutabilidad. |
| Disponibilidad | Baja-Media | Entorno reproducible y guía básica; faltan continuidad, backups y monitoreo. |

La escala es una estimación documental, no una certificación.

