# CAPÍTULO I

# 1. INTRODUCCIÓN

El presente proyecto aborda el desarrollo de MediTurno, un sistema web para la
gestión de turnos del personal de salud. Su punto de partida es un proceso
administrado mediante hojas de cálculo, cuya sustitución por una aplicación web
busca centralizar la información y proporcionar control de acceso, asignaciones,
validación temporal, calendario, reportes y trazabilidad.

MediTurno fue desarrollado con PHP 8.2 y Laravel 10 en el backend, Blade,
Bootstrap 5, Vite y FullCalendar en la presentación, y MySQL 8 para la
persistencia. Su entorno local está compuesto por Docker Compose, PHP-FPM, Nginx
y MySQL.

El sistema reconoce cuatro actores: Invitado, Administrador, Jefe de Servicio y
Personal de Salud. El Administrador posee alcance global; el Jefe de Servicio
opera únicamente los servicios asociados mediante `service_managers`; y el
Personal de Salud consulta información propia mediante la relación
`staff.user_id`.

La versión documentada comprende el MVP y las ampliaciones funcionales de
vistas por rol y gestión operativa por jefatura. La operatividad actual debe
confirmarse mediante una ejecución de QA con evidencia fechada.

Fuentes: `README.md`, `.ai/PROJECT_CONTEXT.md`,
`.ai/knowledge-base/features.md`, DEC-013 y DEC-014.

## 1.1 PLANTEAMIENTO DEL PROBLEMA

### 1.1.1 TEMA

Sistema web para la gestión de turnos hospitalarios, denominado MediTurno.

Título de trabajo preservado en el material disponible:

**Sistema Web de Gestión de Turnos Hospitalarios: caso de estudio del Hospital
Materno Infantil.**

[PENDIENTE: confirmar el título definitivo con la plantilla institucional y el
registro académico vigente.]

### 1.1.2 Diagnóstico

La gestión manual mediante hojas de cálculo dificulta concentrar en un solo
flujo la configuración de turnos, la asignación diaria, la consulta por
personal, la identificación de conflictos, la elaboración de reportes y el
historial de cambios.

La documentación validada identifica problemas concretos que el sistema debe
controlar:

- asignaciones horarias traslapadas;
- turnos nocturnos que cruzan al día siguiente;
- riesgo de perder trazabilidad al modificar o eliminar información;
- necesidad de separar el acceso global del Administrador, el alcance por
  servicio de la jefatura y la información propia del personal;
- necesidad de configurar turnos de acuerdo con cada servicio hospitalario;
- necesidad de consultar calendarios y reportes sin depender de una hoja de
  cálculo.

La solución implementada utiliza intervalos reales `start_at` y `end_at`,
prohíbe traslapes, permite turnos consecutivos, conserva eliminaciones lógicas y
registra operaciones críticas mediante auditoría.

Existe una guía de entrevista dirigida a personal administrativo, jefaturas y
personal de salud. El instrumento contiene preguntas sobre gestión actual,
conflictos, reportes, seguridad y expectativas, pero no contiene respuestas.

[PENDIENTE: aplicar las entrevistas o incorporar actas con respuestas validadas.
No se presentan resultados estadísticos ni conclusiones de campo porque no
existe evidencia.]

Fuentes: `.ai/knowledge-base/problems.md`, DEC-003, DEC-004, DEC-012,
`docs/MediTurno_Entrevista_Bladimir_Luna.docx`.

### 1.1.3 Justificación

La construcción de MediTurno se justifica por la necesidad de disponer de un
mecanismo estructurado para administrar personal, servicios, plantillas y
asignaciones. Frente al uso de hojas de cálculo, la aplicación ofrece:

- autenticación y autorización por rol;
- validación de conflictos de horario;
- tratamiento correcto de turnos nocturnos;
- configuración de turnos por servicio;
- calendario mensual;
- reportes por servicio y empleado;
- trazabilidad mediante auditoría y SoftDeletes;
- solicitudes de cambio y notificaciones internas;
- vistas restringidas para jefaturas y personal.

Estas capacidades permiten demostrar una alternativa técnica organizada y
verificable para el proceso de gestión de turnos. No se afirma una reducción
medida de tiempo, errores o costos, porque no existe una evaluación comparativa
con resultados empíricos.

[PENDIENTE: validar la justificación institucional, social y económica con datos
de entrevistas o mediciones autorizadas.]

### 1.1.4 Planteamiento del problema técnico

¿Cómo desarrollar un sistema web que permita gestionar de manera estructurada
los turnos del personal hospitalario, reemplazando el manejo mediante hojas de
cálculo e incorporando control por roles, validación de conflictos, calendario,
reportes y trazabilidad?

La pregunta se mantiene en el nivel técnico respaldado por el alcance
documentado. Cualquier referencia a impacto clínico, calidad de atención o
indicadores institucionales requiere evidencia adicional.

