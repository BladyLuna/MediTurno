# Knowledge Base Schema

## Objetivo

Definir la estructura minima de la futura instancia operativa de Knowledge Base.
Este documento es un esquema; no crea todavia `.ai/knowledge-base/`.

## Estructura minima

```text
.ai/knowledge-base/
├── README.md
├── INDEX.md
├── sources.md
├── timeline.md
├── decisions.md
├── features.md
├── problems.md
├── lessons.md
├── knowledge-gaps.md
├── important-prompts.md
└── evidence.md
```

## Responsabilidades, no roles implementados

Las columnas de actualizacion y consumo describen responsabilidades futuras. No
crean el rol Knowledge Archivist ni otros roles BDS.

| Archivo | Proposito | Pregunta que responde | Informacion que contiene | Quien lo actualiza | Quien lo consume |
|---|---|---|---|---|---|
| `README.md` | Explicar alcance y uso de la instancia | ¿Que es esta KB y como debe utilizarse? | Objetivo, limites, convenciones, estados y navegacion inicial | Responsabilidad futura de gobierno de KB autorizada | Todos los roles BDS y responsables del proyecto |
| `INDEX.md` | Dar acceso navegable al conocimiento | ¿Donde esta cada categoria de conocimiento? | Enlaces, categorias, resumen de cobertura y estado | Responsabilidad futura de mantenimiento de KB | Todos los consumidores autorizados |
| `sources.md` | Registrar procedencia | ¿De donde proviene el conocimiento? | Fuentes, ubicacion, tipo, autor si se conoce, fecha, confiabilidad y alcance | Responsabilidad futura de captura y validacion | Roles que analizan, validan o auditan |
| `timeline.md` | Conservar secuencia temporal | ¿Que ocurrio, cuando y en que orden? | Hitos, cambios, entregas, eventos y referencias a evidencia | Responsabilidad futura de captura cronologica | Roles de analisis, planificacion y revision |
| `decisions.md` | Consolidar decisiones relevantes | ¿Que se decidio, por que y con que consecuencias? | Decision, contexto, alternativas, estado, fecha y fuente formal | Autoridad decisora o responsabilidad autorizada de registro | Todos los roles afectados por decisiones |
| `features.md` | Describir capacidades conocidas | ¿Que capacidades existen, se planifican o cambiaron? | Features, alcance, estado, dependencias, reglas y evidencia | Responsabilidad futura de analisis funcional | Roles de producto, analisis, arquitectura, desarrollo y QA |
| `problems.md` | Registrar problemas y contradicciones | ¿Que esta mal, bloqueado o en conflicto? | Problemas, impacto, evidencia, contradicciones, estado y seguimiento | Cualquier responsabilidad autorizada que detecte el problema; validacion posterior obligatoria | Roles de analisis, planificacion, solucion y revision |
| `lessons.md` | Preservar aprendizaje reutilizable | ¿Que se aprendio y cuando aplica? | Lecciones, contexto, resultados, limites y evidencia | Responsabilidad futura que valide el aprendizaje | Todos los roles que afronten situaciones equivalentes |
| `knowledge-gaps.md` | Hacer visibles los vacios | ¿Que no se sabe o no esta confirmado? | Preguntas abiertas, informacion faltante, impacto y plan de confirmacion | Responsabilidades de captura, analisis o validacion | Roles que investigan, planifican o toman decisiones |
| `important-prompts.md` | Preservar instrucciones reutilizables | ¿Que prompts son importantes y bajo que condiciones? | Prompt, proposito, entradas, restricciones, version, resultados esperados y procedencia | Responsabilidad futura autorizada para gobierno de prompts | Roles o agentes que ejecutan workflows asistidos |
| `evidence.md` | Catalogar soporte verificable | ¿Que evidencia respalda cada afirmacion? | Identificadores, fuentes, citas, archivos, checksums, fechas y enlaces a conocimiento relacionado | Responsabilidad futura de validacion y trazabilidad | Todos los roles que necesiten confirmar conocimiento |

## Metadatos minimos de una entrada

Cada registro relevante debe poder expresar:

- identificador estable;
- titulo o afirmacion;
- categoria;
- estado epistemico;
- estado de vigencia;
- fuente o evidencia;
- fecha de captura y ultima revision;
- responsable de la actualizacion;
- relaciones con otras entradas;
- contradicciones conocidas;
- observaciones o limites.

## Regla de extensibilidad

La estructura puede ampliarse cuando exista una necesidad demostrada. Cualquier
nuevo archivo debe declarar proposito, propietario de la responsabilidad,
consumidores, relacion con el esquema y reglas de trazabilidad.

