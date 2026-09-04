# Estado Actual del Proyecto MediTurno

Fecha de corte: **2026-07-02**.

## Identificación

| Campo | Estado |
|---|---|
| Proyecto | MediTurno |
| Tipo | Sistema web de gestión de turnos hospitalarios y proyecto de grado |
| Objetivo | Sustituir la gestión manual en hojas de cálculo por una aplicación con roles, asignaciones, validación temporal, calendario, reportes, trazabilidad y flujos operativos básicos |
| Versión funcional documentada | MVP cerrado + Versión 2 + Versión 3, hasta Sprint 12 |
| Versión semántica o release etiquetado | `PENDING CONFIRMATION` |
| Estado general | Funcionalidades declaradas como implementadas; documentación BDS, análisis, diagramas y seguridad desarrollados |
| Operatividad actual | `PENDING CONFIRMATION`: la Knowledge Base no contiene una ejecución actual de QA fechada después de su captura |

Fuentes: `README.md`; `.ai/PROJECT_CONTEXT.md`;
`.ai/knowledge-base/features.md`; DEC-013 y DEC-014.

## Arquitectura resumida

| Capa | Tecnología o patrón confirmado |
|---|---|
| Backend | PHP 8.2 y Laravel 10 |
| Presentación | Blade, Bootstrap 5, Vite y FullCalendar |
| Persistencia | MySQL 8, Eloquent y migraciones |
| Autenticación | Sesión web nativa de Laravel |
| Autorización | `users.role`, middleware, Policies y alcance desde backend |
| Dominio | Servicios para horarios, conflictos, calendario, reportes, alcance, solicitudes, notificaciones y auditoría |
| Infraestructura local | Docker Compose con PHP-FPM, Nginx y MySQL |
| Reportes | HTML, CSV y PDF básico |

## Módulos existentes

| N.º | Módulo | Estado documentado |
|---:|---|---|
| 1 | Autenticación y dashboard | Implementado y analizado |
| 2 | Usuarios y control de estado | Implementado y analizado |
| 3 | Servicios hospitalarios | Implementado y analizado |
| 4 | Personal de salud | Implementado y analizado |
| 5 | Jefaturas por servicio | Implementado y analizado |
| 6 | Plantillas globales y turnos por servicio | Implementado y analizado |
| 7 | Asignaciones y disponibilidad | Implementado y analizado |
| 8 | Calendario global, por servicio y personal | Implementado y analizado |
| 9 | Reportes y exportaciones | Implementado y analizado |
| 10 | Solicitudes de cambio | Implementado y analizado |
| 11 | Notificaciones internas | Implementado y analizado |
| 12 | Auditoría | Implementado y analizado |

Ausencias, vacaciones, notificaciones externas y estadísticas avanzadas
permanecen Post-MVP.

## Actores

| Actor | Alcance confirmado |
|---|---|
| Invitado | Acceso al inicio de sesión |
| Administrador | Administración global, calendario y reportes globales, y auditoría |
| Jefe de Servicio | Operación y lectura únicamente sobre servicios asociados mediante `service_managers` |
| Personal de Salud | Turnos, solicitudes y notificaciones propias mediante `staff.user_id` |

## Reglas operativas esenciales

- Los roles oficiales son `admin`, `jefe_servicio` y `personal`.
- Los roles se almacenan en `users.role`; no se usa un paquete externo de
  permisos.
- No se permiten turnos traslapados.
- Los turnos consecutivos son válidos cuando un intervalo termina exactamente
  donde comienza el otro.
- Los turnos nocturnos guardan el fin en el día siguiente.
- El nombre oficial de la relación a servicios es `hospital_service_id`.
- Un jefe puede administrar múltiples servicios.
- La jefatura no puede forzar servicios, personal o turnos configurados fuera de
  su alcance.
- Las operaciones críticas usan transacciones y auditoría.
- Al cancelar una asignación se establece `cancelled`, se aplica SoftDelete y se
  registra auditoría.
- Aprobar o rechazar una solicitud se documenta como decisión administrativa y
  no modifica automáticamente la asignación; existe una contradicción heredada
  sobre este punto.

## Estado de la Knowledge Base

| Aspecto | Estado |
|---|---|
| Estructura | Completa y operativa |
| Fuentes | 28 fuentes registradas en la captura inicial |
| Decisiones | DEC-001 a DEC-015 preservadas |
| Funcionalidades | 21 funcionalidades activas declaradas y 4 Post-MVP |
| Contradicciones | 15 preservadas sin resolución implícita |
| Vacíos de conocimiento | 15 registrados |
| Evidencia | Registro con checksums y fuentes estructurales |
| Fuente de verdad | `.ai/` según DEC-015 |
| Legado `.ia/` | Preservado; todavía no debe eliminarse |

Fuentes: `.ai/knowledge-base/INDEX.md`;
`.ai/reports/04-migration-verification-report.md`.

## Estado del análisis

- Doce módulos disponen de resumen, actores, casos de uso, reglas, permisos,
  rutas, controladores, modelos, base de datos, flujo y pendientes.
- Existe matriz de trazabilidad de clases en
  `.ai/analysis/system-overview/class-traceability.md`.
- La auditoría inicial pidió correcciones menores, completadas posteriormente
  por el cierre gráfico documentado en el reporte 07.

Estado: **completo para documentación funcional**, sujeto a los conflictos y
vacíos preservados.

## Estado de los diagramas

| Entregable | Cobertura |
|---|---|
| Casos de uso general | Completo en Mermaid y PlantUML |
| Clases del dominio | Completo en Mermaid y PlantUML |
| ERD físico | Completo en Mermaid y PlantUML |
| Casos de uso por módulo | 12 de 12 |
| Actividad por módulo | 12 de 12 |
| Secuencia por módulo | 12 de 12 |
| Estados | 9; completos donde aplica |

Estado: **cerrado**, sin diagramas pendientes dentro del alcance del reporte 07.

## Estado de la documentación

| Área | Estado |
|---|---|
| README operativo | Disponible; presenta desfases conocidos sobre jefatura |
| Decisiones | DEC-001 a DEC-015 disponibles |
| QA, demo y despliegue | Disponibles en `docs/` |
| PRD final | `PENDING CONFIRMATION`; el mapa documental solo confirma una nota/prompt relacionado |
| Análisis funcional | Completo en `.ai/analysis/` |
| Diagramas | Completos en `.ai/diagrams/` |
| Seguridad de la información | Cinco documentos finales y reporte BDS disponibles |
| Roadmap y backlog | Llegan a Sprint 10; Sprints 11/12 están documentados por decisiones, no incorporados formalmente |

## Estado de seguridad

- Diseño académico de seguridad completado.
- Cobertura estimada de la guía: **96 %**.
- Controles confirmados: autenticación de sesión, hash de contraseñas, cuenta
  activa, roles, Policies, alcance horizontal, CSRF, validación, transacciones,
  integridad referencial, SoftDeletes y auditoría.
- Estado de producción: no certificado.
- Controles operativos pendientes: MFA, rate limiting confirmado, backups y
  restauración, monitoreo, RTO/RPO, respuesta a incidentes, endurecimiento
  productivo y retención/inmutabilidad de auditoría.

Fuente: `.ai/reports/08-information-security-review.md`.

## Riesgos abiertos

1. Advisories de Laravel y Vite/esbuild pendientes de verificación actual.
2. Pérdida de datos sin backup y restauración confirmados.
3. Acceso privilegiado sin MFA ni rate limiting confirmado.
4. Auditoría sin retención e inmutabilidad documentadas.
5. Exportaciones CSV/PDF fuera del control del sistema después de descargarse.
6. Disponibilidad productiva sin monitoreo ni objetivos de recuperación.
7. Divergencia documental entre copias heredadas y `.ai/`.
8. Operatividad actual de las 21 funcionalidades pendiente de una nueva evidencia
   de QA.

## Contradicciones pendientes

| ID | Resumen |
|---|---|
| CONFLICT-001 | `.ai/` es fuente de verdad, pero quedan referencias heredadas a `.ia/` |
| CONFLICT-002 | Roadmap/backlog terminan en Sprint 10, mientras DEC-013/014 describen Sprints 11/12 |
| CONFLICT-003 | README subrepresenta las capacidades actuales de jefatura |
| CONFLICT-004 | Una regla heredada plantea modificar asignaciones al aprobar solicitudes; README, demo y QA indican que no se modifican automáticamente |
| CONFLICT-005 | CLAUDE contiene rutas históricas distintas |
| CONFLICT-006 | CLAUDE prescribe FullCalendar por CDN; el proyecto documenta Vite |
| CONFLICT-007 | Excel aparece históricamente, pero solo CSV/PDF están confirmados |
| CONFLICT-008 | CI/CD, Render y GitHub Pages no están confirmados |
| CONFLICT-009 | Descripción histórica de `audit_logs` difiere del diseño vigente |
| CONFLICT-010 | Propósito histórico de `docs/` no coincide con su uso actual |
| CONFLICT-011 | QA/demo no cubren por completo las capacidades añadidas en DEC-014 |
| CONFLICT-012 | No existe sincronización automática entre copias documentales |
| CONFLICT-013 | `architecture.md` contiene un posible artefacto `++` |
| CONFLICT-014 | El workflow menciona un `CHANGELOG.md` no detectado |
| CONFLICT-015 | `project-grade.md` es insuficiente como estructura académica completa |

Todas permanecen en estado `PENDING CONFIRMATION`.

## Próximos hitos recomendados

1. Ejecutar QA actual y preservar el resultado como nueva evidencia.
2. Resolver formalmente CONFLICT-003 y CONFLICT-004.
3. Incorporar Sprints 11 y 12 al roadmap/backlog si se aprueba la actualización.
4. Alinear README, QA y flujo demo con el alcance vigente de jefatura.
5. Verificar advisories con `composer audit` y `npm audit`.
6. Completar controles operativos mínimos de seguridad antes de producción.
7. Validar requisitos académicos del PDF y la entrevista DOCX.
8. Revisar criterios para archivar `.ia/`, sin eliminarla hasta aprobación formal.
