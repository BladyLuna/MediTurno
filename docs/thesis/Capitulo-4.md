# CAPÍTULO IV

# 4. CONCLUSIONES Y RECOMENDACIONES

## 4.1. Conclusiones

El desarrollo de MediTurno permitió cumplir el objetivo general planteado en
el Capítulo II: **desarrollar un sistema web para la gestión de turnos del
personal hospitalario** que administra servicios, personal, configuraciones de
turno, asignaciones, calendarios y reportes con control de acceso y
trazabilidad. Las conclusiones se organizan a continuación por cada objetivo
específico.

1. **Modelo de datos relacional (OE1).** Se estructuró la información de
   usuarios, servicios hospitalarios, personal, plantillas de turno y
   asignaciones mediante un modelo relacional materializado en 14 migraciones,
   7 tablas principales (`users`, `hospital_services`, `staff`,
   `shift_templates`, `service_shift_templates`, `shift_assignments`,
   `audit_logs`) y 10 modelos Eloquent, con eliminación lógica (`SoftDeletes`)
   en todas las entidades y una bitácora de auditoría independiente. El modelo
   queda documentado en el diagrama entidad-relación
   (`.ai/diagrams/01-general/03-erd-*`); la exportación oficial desde MySQL
   Workbench permanece [PENDIENTE].

2. **Autenticación y permisos (OE2).** Se implementó autenticación con
   separación de permisos para Administrador, Jefe de Servicio y Personal de
   Salud mediante el campo `users.role`, el middleware `CheckRole`, límite de
   intentos (`Throttle`, 5/min) y 9 políticas de autorización (Gates &
   Policies). Las rutas protegidas impiden el acceso cruzado entre roles.

3. **Gestión de usuarios, servicios, personal y jefaturas (OE3).** Se
   implementaron los CRUD completos de usuarios, servicios hospitalarios,
   personal y jefaturas por servicio (28 controladores en total), con
   validación de formularios centralizada en 29 Form Requests y vistas Blade
   (49) con Bootstrap 5. Un jefe de servicio puede administrar uno o varios
   servicios.

4. **Plantillas de turno (OE4).** Se implementó un catálogo global de tipos de
   turno (`shift_templates`: Mañana 07:00-14:00, Tarde 14:00-21:00, Noche
   21:00-07:00, con colores) y plantillas específicas por servicio
   (`service_shift_templates`) que permiten personalizar nombre, horario y
   color de cada turno en cada área del hospital.

5. **Asignaciones con validación de traslapes (OE5).** Se implementó la
   asignación de turnos con cálculo de intervalos, soporte de turnos nocturnos
   (que inician un día y terminan al día siguiente) y la regla crítica de
   negocio de **no permitir turnos traslapados**, validada a nivel de backend
   antes de guardar, con estados `assigned`, `changed` y `cancelled`.

6. **Calendario (OE6).** Se proporcionaron calendarios mensuales de solo
   lectura con FullCalendar.js, con alcance global, por servicio y por
   personal, consumiendo el endpoint `GET /calendar/events` y coloreando cada
   turno según su plantilla.

7. **Reportes (OE7).** Se implementó la generación de reportes por servicio y
   por empleado con filtros, resumen de turnos, horas y exportación CSV y PDF
   (dompdf y Maatwebsite), como base para reemplazar los reportes manuales.

8. **Auditoría y eliminación lógica (OE8).** Toda operación crítica
   (asignar, modificar, cancelar) se registra en `audit_logs` con usuario,
   acción, valores anteriores/nuevos e IP, y ningún registro se elimina
   físicamente, cumpliendo la regla de trazabilidad del proyecto.

9. **Solicitudes de cambio y notificaciones (OE9).** Se implementó el flujo de
   solicitudes de cambio de turno con aprobación o rechazo administrativo y
   notificaciones internas con estado de lectura, ampliando el alcance
   original hacia la gestión colaborativa del personal.

10. **Datos demo, pruebas y documentación (OE10).** El sistema cuenta con
    datos demo para demostración, 19 pruebas automatizadas, 49 vistas y un
    paquete documental completo: 57 casos de uso, 48 figuras (casos de uso,
    actividad, secuencia y estados por módulo), diagramas de clases, ERD,
    arquitectura de capas y diagrama de componentes en `.ai/`. La confirmación
    formal de calidad mediante QA fechado permanece [PENDIENTE].

En síntesis, MediTurno constituye una evolución concreta frente al control
manual de turnos: centraliza la información, automatiza la validación de
conflictos, garantiza trazabilidad y adapta la visibilidad de la información
según el rol del usuario. La implementación alcanza la totalidad de los
módulos planificados; la verificación final de campo y el despliegue
productivo certificado quedan como trabajo futuro.

Fuentes de las conclusiones: `docs/thesis/Capitulo-2.md`,
`docs/thesis/Capitulo-3.md`, `README.md`, `.ai/knowledge-base/features.md`,
`.ai/knowledge-base/decisions.md`, `.ai/analysis/modules/`,
`.ai/diagrams/`, inventario técnico verificado del repositorio
(14 migraciones, 28 controladores, 10 modelos, 10 servicios de dominio,
29 Form Requests, 9 policies, 14 middleware, 19 tests, 49 vistas).

## 4.2. Recomendaciones

### Para la continuidad técnica del sistema

1. **Ejecutar y documentar una prueba de aceptación (QA) fechada** utilizando
   el checklist existente (`docs/qa-checklist.md`), con capturas por módulo y
   registro de resultados, para convertir la documentación funcional en
   evidencia verificable.

2. **Obtener el diagrama entidad-relación por ingeniería inversa desde MySQL
   Workbench** y reemplazar o acompañar el ERD derivado de migraciones, según
   lo exigido académicamente (véase
   `.ai/reports/09-database-diagram-verification.md`).

3. **Completar el despliegue en Render** con `APP_ENV=production`,
   `APP_DEBUG=false`, HTTPS forzado y variables de entorno segregadas,
   incluyendo controles operativos de producción: backup, restauración,
   monitoreo y retención de la bitácora de auditoría.

4. **Ampliar la cobertura de pruebas automatizadas** (19 tests actuales) hacia
   los módulos de reportes, notificaciones y auditoría, e incorporar pruebas
   de integración de la validación de traslapes con casos límite (turnos
   nocturnos y cambios de fecha).

5. **Resolver las contradicciones documentales pendientes** (CONFLICT-003 y
   CONFLICT-004 en `docs/decisions.md`) antes de la entrega final, para que la
   documentación no presente ambigüedades frente al jurado.

6. **Certificar el despliegue productivo** y realizar una medición comparativa
   del proceso manual (Excel/papel) frente al sistema, para cuantificar el
   beneficio real sobre los tiempos de elaboración del rol de turnos.

### Para la presentación académica

7. **Obtener la plantilla institucional original** y alinear la numeración y
   los títulos de los capítulos (incluida la posición de las fuentes
   bibliográficas, que en este documento se ubican como Capítulo V).

8. **Completar las respuestas de la entrevista** del personal del hospital
   (`docs/MediTurno_Entrevista_Bladimir_Luna.docx`) e incorporar los datos de
   campo medibles al Capítulo I, para reforzar la justificación con evidencia
   real.

9. **Completar la bibliografía formal** en el Capítulo V aplicando el estilo
   de citación institucional, incorporando citas dentro del texto y
   referencias oficiales de Laravel 10, PHP 8.2, MySQL 8, Bootstrap 5,
   FullCalendar y la metodología de desarrollo adoptada.

10. **Preparar la demostración con datos demo** verificada de punta a punta
    (login por rol → asignaciones → calendario → reportes) y conservar las
    capturas como anexo del documento final.

11. **En el hospital**, capacitar a los jefes de servicio y al personal de
    salud en el uso del sistema, definir el responsable de la administración
    de usuarios y mantener una copia de respaldo periódica de la base de
    datos como primera medida de continuidad.

**Fuente: Elaboración propia (2026).**