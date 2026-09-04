# 08 - Information Security Review

## Resumen ejecutivo

Se elaboró el diseño académico de seguridad de la información de MediTurno sin
modificar código ni Knowledge Base. La revisión utilizó únicamente evidencia
validada y evidencia técnica autorizada.

La implementación presenta controles sólidos de aplicación para un proyecto de
grado: autenticación por sesión, hash de contraseñas, cuenta activa, roles,
Policies, alcance horizontal por servicio y personal, CSRF, Form Requests,
transacciones, integridad referencial, SoftDeletes y auditoría.

La postura no equivale a seguridad productiva completa. Los principales vacíos
son operativos: rate limiting confirmado, MFA, backups y restauración, monitoreo,
RTO/RPO, respuesta a incidentes, endurecimiento productivo verificado y política
de retención/inmutabilidad de auditoría.

## Documentos generados

| Documento | Propósito | Estado |
|---|---|---|
| `docs/security/01-information-security-design.md` | Documento principal con la estructura académica solicitada | Completo |
| `docs/security/02-risk-matrix.md` | Activos, amenazas y valoración cualitativa | Completo |
| `docs/security/03-cia-analysis.md` | Evaluación de confidencialidad, integridad y disponibilidad | Completo |
| `docs/security/04-security-controls.md` | Controles existentes, recomendados y estado | Completo |
| `docs/security/05-annexes.md` | Trazabilidad con módulos, actores, permisos, diagramas y decisiones | Completo |

## Evidencia utilizada

- `.ai/knowledge-base/`: funcionalidades, decisiones, problemas, contradicciones,
  vacíos y evidencia.
- `.ai/analysis/`: inventario y análisis modular, especialmente permisos y
  pendientes.
- `.ai/diagrams/`: casos de uso, clases, ERD y diagramas modulares.
- `app/Models/`: roles, relaciones, casts, atributos ocultos y SoftDeletes.
- `database/migrations/`: tablas, claves foráneas, índices y políticas de borrado.
- Controladores y servicios únicamente para confirmar sesión, alcance,
  transacciones y auditoría.
- `README.md`, `docs/deploy.md` y `docs/decisions.md`.

## Criterios aplicados

- No se atribuyó un control sin evidencia.
- La ausencia de evidencia se marcó `PENDIENTE DE CONFIRMAR`.
- Se separaron controles de aplicación de controles operativos.
- La matriz es cualitativa porque no existe método cuantitativo validado.
- Los advisories se conservaron como riesgos pendientes de verificación; no se
  afirmó que su estado siga vigente.
- Las contradicciones documentales no fueron resueltas.

## Cumplimiento estimado de la guía

**96 %**

La estructura solicitada está cubierta: descripción, activos, riesgos, CIA,
controles, conclusiones y anexos. El 4 % pendiente corresponde a información que
el proyecto no contiene o no permite confirmar:

- clasificación institucional y propietarios de activos;
- metodología cuantitativa y apetito de riesgo;
- evidencia de infraestructura productiva;
- resultados actuales de auditorías de dependencias;
- políticas operativas de backup, retención, monitoreo e incidentes.

El porcentaje mide cobertura documental de la guía, no eficacia técnica ni
certificación de seguridad.

## Riesgos relevantes

1. Pérdida de datos sin backup y restauración confirmados.
2. Acceso privilegiado sin MFA ni limitación de intentos confirmada.
3. Auditoría sin retención e inmutabilidad documentadas.
4. Exportaciones que salen del control de acceso del sistema.
5. Advisories de Laravel y Vite/esbuild pendientes de nueva verificación.
6. Disponibilidad productiva sin monitoreo ni objetivos de recuperación.

## Información faltante

- Propietario y clasificación de cada activo.
- Responsable de aceptar y tratar riesgos.
- Configuración efectiva de producción.
- Evidencia de TLS, cookies seguras y gestión de secretos.
- Rate limiting del login.
- MFA.
- Backups, restauración, RTO y RPO.
- Monitoreo y respuesta a incidentes.
- Retención e inmutabilidad de auditoría.
- Manejo seguro de exportaciones.
- Resolución formal de CONFLICT-003 y CONFLICT-004.

## Recomendaciones antes de entregar

1. Validar con el tutor la escala cualitativa y el 96 % de cobertura documental.
2. Obtener una clasificación simple de datos y asignar propietario a cada activo.
3. Ejecutar `composer audit` y `npm audit`, registrar fecha y tratamiento.
4. Añadir evidencia de backup y restauración en un entorno de prueba.
5. Confirmar rate limiting, cookies seguras, TLS y `APP_DEBUG=false`.
6. Presentar los controles pendientes como plan de mejora, no como
   funcionalidades implementadas.
7. Alinear la descripción del rol `jefe_servicio` antes de la defensa.

## Resultado

El documento de seguridad está listo para revisión académica. Requiere validación
humana de los datos institucionales y de los controles operativos antes de
considerarse un diseño de producción.

