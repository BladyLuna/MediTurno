# Matriz de Riesgos de Seguridad de la Información

## Método de valoración

La matriz usa escalas cualitativas:

- Impacto: `Bajo`, `Medio`, `Alto` o `Crítico`.
- Probabilidad: `Baja`, `Media` o `Alta`.
- Riesgo: `Bajo`, `Medio`, `Alto` o `Crítico`.

La valoración corresponde al diseño e implementación observados, no a una prueba
de penetración ni a un entorno productivo. La metodología cuantitativa,
propietarios de riesgo y apetito institucional están **PENDIENTE DE CONFIRMAR**.

## Matriz

| ID | Activo | Amenaza | Impacto | Probabilidad | Nivel de riesgo | Evidencia y consideración |
|---|---|---|---|---|---|---|
| R-01 | Cuentas y roles | Uso de credenciales comprometidas | Crítico | Media | Alto | Hay sesión, hash y roles; no hay evidencia de MFA ni política avanzada. |
| R-02 | Cuentas y roles | Fuerza bruta o enumeración de cuentas | Alto | Media | Alto | El mensaje distingue cuenta desactivada; el throttle del login está pendiente en `.ai/analysis/modules/authentication-dashboard/11-pending.md`. |
| R-03 | Sesiones | Robo o fijación de sesión | Alto | Baja/Media | Medio | Login regenera sesión y logout la invalida; configuración productiva de cookies está pendiente. |
| R-04 | Alcance de jefaturas | Manipulación de `hospital_service_id`, `staff_id` o plantilla | Crítico | Media | Alto | DEC-013/014 y `UserScopeService` aplican alcance en backend. El riesgo residual requiere pruebas continuas. |
| R-05 | Datos del personal | Consulta no autorizada de CI o contacto | Alto | Media | Alto | Admin gestiona; jefatura ve personal de servicios asociados. No existe clasificación institucional documentada. |
| R-06 | Asignaciones | Creación de turnos traslapados | Crítico | Media | Alto | DEC-003 y `ShiftConflictService` controlan solapamiento; concurrencia simultánea no está documentada. |
| R-07 | Asignaciones | Fechas erróneas en turnos nocturnos | Alto | Baja | Medio | DEC-004 y `ShiftTimeService` calculan `end_at` al día siguiente. |
| R-08 | Asignaciones | Alteración o cancelación sin trazabilidad | Crítico | Baja/Media | Alto | Transacción, estado `cancelled`, SoftDelete y auditoría según DEC-012. |
| R-09 | Solicitudes | Aprobación/rechazo por actor fuera de alcance | Alto | Media | Alto | Policies y alcance por servicio. CONFLICT-004 afecta semántica posterior, no la autorización confirmada. |
| R-10 | Reportes | Exposición de información mediante HTML, CSV o PDF | Alto | Media | Alto | Rutas por rol y alcance; manejo posterior de archivos exportados no está controlado por la aplicación. |
| R-11 | Notificaciones | Acceso a notificaciones de otro usuario | Alto | Baja/Media | Medio | `InternalNotificationPolicy` protege propiedad; la tabla depende del usuario con borrado en cascada. |
| R-12 | Auditoría | Modificación, eliminación o acceso indebido a logs | Crítico | Media | Alto | Consulta global solo para admin; no hay evidencia de inmutabilidad, retención o respaldo independiente. |
| R-13 | Auditoría | Crecimiento indefinido de registros | Medio | Media | Medio | La política de retención y exportación está pendiente en el análisis del módulo. |
| R-14 | Base de datos | Eliminación accidental o ruptura referencial | Crítico | Baja/Media | Alto | Hay claves foráneas, `restrictOnDelete` y SoftDeletes; no todas las tablas usan SoftDeletes. |
| R-15 | Base de datos | Pérdida total por fallo o error operativo | Crítico | Media | Alto | No hay evidencia confirmada de backup ni restauración probada. |
| R-16 | Configuración | Exposición de `APP_KEY`, credenciales o debug | Crítico | Baja/Media | Alto | `docs/deploy.md` prescribe `APP_DEBUG=false`, HTTPS y clave; cumplimiento real pendiente. |
| R-17 | Dependencias | Explotación de vulnerabilidades conocidas | Alto | Media | Alto | README registra CVE de Laravel y vulnerabilidad moderada de esbuild; vigencia actual pendiente según GAP-006. |
| R-18 | Aplicación web | Solicitudes CSRF | Alto | Baja | Medio | Middleware CSRF activo y sin exclusiones observadas en grupo web. |
| R-19 | Aplicación web | Inyección o datos inválidos | Alto | Baja/Media | Medio | Eloquent, Form Requests y reglas de validación reducen riesgo; no equivale a prueba especializada. |
| R-20 | Infraestructura | Caída de Nginx, PHP-FPM, aplicación o MySQL | Alto | Media | Alto | Docker y despliegue básico existen; monitoreo, redundancia y recuperación están pendientes. |
| R-21 | Disponibilidad administrativa | Eliminación/desactivación del último admin | Crítico | Baja | Medio | DEC-009 implementa protección del último admin y evita auto-desactivación/eliminación. |
| R-22 | Integridad documental | Decisiones o permisos divergentes entre documentos | Medio | Media | Medio | CONFLICT-003 y otros conflictos están preservados en la Knowledge Base. |

## Riesgos prioritarios

1. Pérdida de base de datos sin backup/restauración confirmados.
2. Acceso privilegiado sin MFA ni rate limiting confirmado.
3. Exposición de datos mediante exportaciones fuera del control del sistema.
4. Auditoría sin política confirmada de retención e inmutabilidad.
5. Advisories de dependencias pendientes de verificación y tratamiento.
6. Disponibilidad productiva sin monitoreo, RTO/RPO ni continuidad documentada.

## Limitaciones

- No se ejecutaron pruebas de penetración.
- No se inspeccionó infraestructura productiva.
- No existe evidencia de inventario institucional de datos personales.
- No se definieron propietarios de activos o riesgos.
- No se confirmó la vigencia actual de los advisories con nuevas auditorías.

