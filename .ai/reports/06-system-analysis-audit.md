# System Analysis Audit

## 1. Resumen ejecutivo

La documentación funcional de MediTurno está bien estructurada en `.ai/knowledge-base/` y `.ai/analysis/modules/`. Los 12 módulos funcionales están documentados con resumen, actores, casos de uso, reglas, permisos, rutas, modelos, controladores y pendientes.

La cobertura de diagramas es parcial en la capa exportada a `.ai/diagrams/`: existen el diagrama general de casos de uso, el diagrama general de clases y los casos de uso por módulo, pero no se materializaron en esa carpeta los diagramas de actividades, secuencias ni estados. Esa ausencia impide considerar la representación gráfica completamente cerrada para defensa si se toma `.ai/diagrams/` como entrega final.

Persisten contradicciones documentales conocidas en la KB, especialmente `CONFLICT-004` sobre si la aprobación de solicitudes actualiza o no la asignación, y la diferencia entre el alcance de `jefe_servicio` en README frente a DEC-013/DEC-014. No se detectaron contradicciones nuevas durante esta auditoría.

## 2. Cobertura del análisis

### Verificación 1 - Módulos

| Módulo | Completo | Observaciones |
|---|---|---|
| authentication-dashboard | Sí | Tiene resumen, actores, reglas, permisos, rutas, modelos, controladores y pendientes. |
| users | Sí | Cobertura completa; conserva DEC-009 como restricción operativa. |
| hospital-services | Sí | Cobertura completa; referencias coherentes con servicio hospitalario. |
| staff | Sí | Cobertura completa; el alcance de jefe_servicio queda como lectura restringida. |
| service-managers | Sí | Cobertura completa; jefatura consume el alcance, no lo autogestiona. |
| shift-templates | Sí | Cobertura completa; incluye personalización y turnos nocturnos. |
| shift-assignments | Sí | Cobertura completa; conserva reglas de traslape, nocturnos, cancelación y auditoría. |
| calendar | Sí | Cobertura completa; solo lectura y filtrado por rol. |
| reports | Sí | Cobertura completa; reportes solo lectura con exportación declarada. |
| shift-change-requests | Sí | Cobertura completa; mantiene la contradicción abierta sobre la aprobación. |
| notifications | Sí | Cobertura completa; notificaciones internas y estado de lectura. |
| audit | Sí | Cobertura completa; lectura administrativa y generación indirecta. |

### Verificación 2 - Módulos: calidad estructural

- Existe un resumen por módulo.
- Existen actores por módulo.
- Existen reglas de negocio por módulo.
- Existen permisos por módulo.
- Existen rutas por módulo.
- Existen modelos por módulo.
- Existen controladores por módulo.
- Existen pendientes por módulo.

## 3. Cobertura de diagramas

### Estado por categoría

| Categoría | Estado | Observaciones |
|---|---|---|
| Diagrama general de casos de uso | Existe | Está en `.ai/diagrams/mermaid/general-use-cases.mmd` y `.ai/diagrams/plantuml/general-use-cases.puml`. |
| Diagrama general de clases | Existe | Está en `.ai/diagrams/mermaid/general-class.mmd` y `.ai/diagrams/plantuml/general-class.puml`. |
| Casos de uso por módulo | Existe | Existen 12 pares Mermaid/PlantUML en `.ai/diagrams/mermaid/modules/` y `.ai/diagrams/plantuml/modules/`. |
| Actividades por módulo | Falta | No se exportaron a `.ai/diagrams/`; solo existen en `.ai/analysis/modules/`. |
| Secuencias por módulo | Falta | No se exportaron a `.ai/diagrams/`; solo existen en `.ai/analysis/modules/`. |
| Estados cuando aplica | Incompleto | Hay estados en `.ai/analysis/modules/` para 9 módulos, pero no se exportaron a `.ai/diagrams/`. |

### Observación técnica

En `.ai/analysis/modules/` sí existen actividades, secuencias y estados para los módulos que los requieren. La brecha está en la capa gráfica consolidada `.ai/diagrams/`, que hoy solo materializa casos de uso y el diagrama de clases.

## 4. Calidad de la documentación

### Verificación 3 - Actores

Actores confirmados:

- `Guest`
- `admin`
- `jefe_servicio`
- `personal`

La asociación de actores es consistente en la documentación base:

- `Guest` se asocia a login/autenticación.
- `admin` cubre administración global.
- `jefe_servicio` opera con alcance restringido por `service_managers`.
- `personal` accede a su propio calendario, solicitudes y notificaciones.

Inconsistencias detectadas:

- `CONFLICT-003`: README subestima el alcance de `jefe_servicio` frente a DEC-013/DEC-014.
- `CONFLICT-004`: la aprobación de solicitudes de cambio sigue ambigua respecto a si modifica asignaciones.

### Verificación 4 - Cobertura

El sistema puede explicarse en gran medida con la documentación existente, pero no de forma totalmente cerrada para defensa técnica si se exige la capa gráfica completa.

Falta para cerrar el relato documental:

- exportar actividades y secuencias a `.ai/diagrams/`;
- exportar estados a `.ai/diagrams/` en los módulos donde aplica;
- resolver `CONFLICT-004`;
- normalizar el alcance de `jefe_servicio` en README/CLAUDE frente a DEC-013 y DEC-014;
- decidir el estatus final de las referencias pendientes de `CHANGELOG`, Excel y `project-grade.md`.

## 5. Riesgos detectados

| Riesgo | Impacto | Estado |
|---|---|---|
| Conflicto de aprobación de solicitudes | Puede alterar la narrativa funcional de Sprint 9 y la defensa del flujo operativo. | Alto |
| Alcance de jefatura descrito de forma inconsistente | Puede inducir una defensa incorrecta del modelo de permisos. | Alto |
| Diagramas incompletos en `.ai/diagrams/` | Debilita la entrega gráfica final si se usa como material de exposición. | Medio |
| Contradicciones documentales persistentes | Aumentan la posibilidad de respuestas inconsistentes entre documentos. | Medio |
| Dependencias sin auditoría actual | Riesgo de seguridad no validado en la documentación actual. | Medio |

## 6. Pendientes antes de la entrega

### Verificación 5 - Proyecto de grado

| Apartado | Calificación | Observación |
|---|---|---|
| Diagrama General de Casos de Uso | Bueno | Cubre actores y módulos principales. |
| Diagrama de Clases | Bueno | Representa el dominio central, aunque puede ampliarse con relaciones secundarias si se decide hacerlo. |
| Diagramas por módulo | Aceptable | Los casos de uso existen; falta consolidar actividades, secuencias y estados en `.ai/diagrams/`. |
| Reglas de negocio | Excelente | Están bien registradas en KB y decisiones. |
| Actores | Excelente | Cuatro actores confirmados y consistentes. |
| Permisos | Bueno | Bien definidos por rol y alcance, pero con conflicto de jefatura que debe resolverse. |
| Flujos | Aceptable | Están documentados, pero la representación gráfica consolidada está incompleta. |
| Arquitectura funcional | Bueno | Suficiente para entender el sistema, aunque depende de documentos cruzados. |

### Verificación 6 - Recomendaciones

- Falta exportar a `.ai/diagrams/` los diagramas de actividad, secuencia y estados existentes en la capa de análisis.
- Debe corregirse la ambigüedad de `CONFLICT-004`.
- Debe unificarse el alcance de `jefe_servicio` entre README, decisiones y KB.
- La información repetida entre KB, análisis y diagramas puede simplificarse con un índice más estricto, sin perder trazabilidad.
- La referencia a Excel y `CHANGELOG` debe resolverse explícitamente o quedar marcada como deuda documental.

## 7. Recomendación final

El análisis funcional es sólido, pero la entrega gráfica todavía no está completa para una defensa cerrada si se exige un paquete de diagramas integral. La base documental sí permite explicar el sistema, pero la capa de diagramas necesita una segunda iteración para cerrar actividades, secuencias y estados en `.ai/diagrams/`.

Recomendación final: **B) El análisis requiere correcciones menores.**

