# Controles de Seguridad

## Matriz de controles

| ID | Riesgo | Control existente | Control recomendado | Estado | Evidencia |
|---|---|---|---|---|---|
| C-01 | Acceso anónimo a funciones internas | Middleware `auth` en rutas protegidas | Mantener pruebas de acceso no autenticado | Implementado | Análisis de autenticación y permisos |
| C-02 | Sesión fijada o residual | Regeneración al login; invalidación y token nuevo al logout | Revisar expiración, `secure`, `http_only` y `same_site` en producción | Implementado | `LoginController` |
| C-03 | Uso de cuenta desactivada | Verificación en login y middleware `active` | Auditar intentos y revisar sesiones concurrentes | Implementado | `EnsureUserIsActive` |
| C-04 | Contraseñas expuestas | Cast `hashed`; atributos ocultos; mínimo de 8 caracteres en Requests | Política institucional, comprobación de contraseñas comprometidas y MFA | Parcial | `User`; Requests de usuario |
| C-05 | Privilegio vertical | `users.role`, middleware `role` y Policies | Matriz formal de permisos y revisión periódica | Implementado | DEC-001; permisos por módulo |
| C-06 | Privilegio horizontal de jefatura | Alcance por `service_managers` y validación de IDs | Pruebas negativas para todo nuevo endpoint | Implementado | DEC-013/014; `UserScopeService` |
| C-07 | Personal accede a datos ajenos | Asociación `staff.user_id` y Policies | Revisar unicidad e integridad del vínculo en cada cambio | Implementado | DEC-010/013 |
| C-08 | CSRF | Verificación CSRF en grupo web sin excepciones observadas | Mantener la protección en nuevas rutas mutables | Implementado | `Kernel`; `VerifyCsrfToken` |
| C-09 | Datos inválidos o asignación incoherente | Form Requests y validación de servicio/personal/plantilla activos | Centralizar pruebas de reglas compartidas | Implementado | Requests; análisis de asignaciones |
| C-10 | Traslapes | Consulta de conflicto con desigualdades estrictas | Evaluar condición de carrera y bloqueo transaccional | Implementado | DEC-003; `ShiftConflictService` |
| C-11 | Error en turnos nocturnos | Cálculo con `end_at` al día siguiente | Mantener pruebas de límites de fecha y zona horaria | Implementado | DEC-004; `ShiftTimeService` |
| C-12 | Operación parcialmente aplicada | Transacciones en operaciones críticas | Revisar cobertura al ampliar procesos | Implementado | DEC-012/014; controladores |
| C-13 | Pérdida de historial | SoftDeletes y estados de cancelación | Definir restauración autorizada y retención | Parcial | Modelos; DEC-012 |
| C-14 | Alteración sin trazabilidad | `AuditLogService` registra cambios e identificación técnica | Almacenamiento protegido, retención e inmutabilidad | Parcial | Migración `audit_logs`; servicio |
| C-15 | Eliminación referencial | FKs con políticas de borrado explícitas | Documentar efectos de `cascadeOnDelete` en notificaciones | Implementado | Migraciones; ERD |
| C-16 | Bloqueo administrativo | Protección del último admin y de autoeliminación/desactivación | Procedimiento de recuperación de cuenta privilegiada | Implementado | DEC-009 |
| C-17 | Fuerza bruta | No hay control confirmado en login | Rate limiting por identidad/IP y alertas | No implementado | Pendiente del módulo autenticación |
| C-18 | Exposición de exportaciones | Acceso a reportes restringido por rol y alcance | Política de descarga, almacenamiento y eliminación segura | Parcial | Análisis de reportes |
| C-19 | Vulnerabilidades conocidas | `composer audit` y `npm audit` documentados | Actualizaciones dirigidas, pruebas y registro de aceptación de riesgo | Parcial | README; `docs/deploy.md`; GAP-006 |
| C-20 | Configuración insegura | Guía indica `APP_DEBUG=false`, `APP_KEY` y HTTPS | Checklist verificable de producción y secretos fuera del repositorio | Parcial | `docs/deploy.md` |
| C-21 | Pérdida de datos | No hay backup confirmado | Backups cifrados, retención, acceso y restauración probada | No implementado | PENDIENTE DE CONFIRMAR |
| C-22 | Caída no detectada | No hay monitoreo confirmado | Health checks, logs centralizados, métricas y alertas | No implementado | PENDIENTE DE CONFIRMAR |
| C-23 | Recuperación tardía | No hay RTO/RPO o continuidad confirmados | Definir RTO/RPO, responsables y procedimiento de recuperación | No implementado | PENDIENTE DE CONFIRMAR |
| C-24 | Incidente sin respuesta coordinada | No hay plan confirmado | Procedimiento de detección, contención, recuperación y lecciones | No implementado | PENDIENTE DE CONFIRMAR |

## Priorización recomendada

### Prioridad 1: antes de un despliegue con datos reales

- Verificar y corregir advisories de dependencias mediante actualizaciones
  dirigidas y pruebas.
- Confirmar HTTPS, cookies seguras, `APP_DEBUG=false`, `APP_KEY` y secretos.
- Implementar y probar backups y restauración.
- Incorporar rate limiting del login.
- Definir quién puede consultar, conservar y eliminar auditoría.

### Prioridad 2: endurecimiento de acceso y operación

- MFA para administrador y jefatura.
- Política de contraseñas y sesiones.
- Monitoreo, alertas y centralización de logs.
- Procedimiento de respuesta a incidentes.
- Reglas para archivos CSV/PDF exportados.

### Prioridad 3: madurez

- RTO/RPO y continuidad.
- Revisión periódica de permisos y cuentas.
- Pruebas de concurrencia para asignaciones.
- Controles de integridad física para estados cuando sean compatibles con el
  diseño.
- Evaluación de seguridad especializada.

## Criterio de estados

- `Implementado`: existe evidencia directa en código, modelo, migración o
  decisión vigente.
- `Parcial`: existe una medida, pero faltan controles complementarios o
  verificación operativa.
- `No implementado`: no existe evidencia en las fuentes autorizadas; debe leerse
  como estado documental y validarse antes de una afirmación definitiva.

