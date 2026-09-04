# Project Charter del Ecosistema de Analisis

## Proposito

Establecer un espacio organizado para inventariar, analizar y documentar MediTurno
sin alterar el codigo ni reorganizar prematuramente la documentacion existente.

## Autoridad documental

- `.ai/*` es la fuente de verdad para analisis, prompts, reglas copiadas,
  plantillas, reportes, diagramas y documentacion tecnica en proceso, segun
  DEC-015.
- `docs/decisions.md` conserva el registro formal de decisiones y debe consultarse
  junto con `.ai/*`.
- `.ia/*` es una fuente heredada temporal y no debe eliminarse hasta completar la
  validacion de la migracion.
- `docs/*` conserva la documentacion final entregable.

## Objetivos

1. Mantener un inventario verificable del proyecto y su documentacion.
2. Separar evidencia confirmada, inferencias y asuntos pendientes.
3. Preparar documentacion por sprint, modulo y actor.
4. Facilitar diagramas editables y matrices de trazabilidad.
5. Detectar duplicaciones e inconsistencias antes de cualquier limpieza final.

## BDS Core

El BDS Core define contratos de gobierno reutilizables para los componentes que
deben existir antes de crear roles especializados.

Su primer componente formal es Knowledge Base Core:
[`core/knowledge-base/`](core/knowledge-base/README.md).

La Knowledge Base es el componente central porque proporciona a los roles un
modelo compartido, persistente, trazable y verificable del conocimiento del
proyecto.

Principios:

- El conocimiento es un activo del proyecto.
- Primero se preserva conocimiento; luego se analiza tecnicamente.
- El conocimiento relevante no debe depender solo de memoria temporal.
- Los roles futuros deben consumir una base compartida antes de producir nuevas
  conclusiones.
- El Core define contratos; la instancia operativa y los roles se crean en fases
  posteriores.

## Entregables de esta fase

- Indice y contexto del ecosistema `.ai`.
- Inventario inicial del proyecto.
- Mapa de documentacion existente.
- Plantillas de analisis.
- Plan de reorganizacion sin ejecucion de movimientos o eliminaciones.

## Restricciones

- No borrar, mover ni renombrar archivos existentes.
- No modificar codigo fuente ni archivos de produccion.
- No convertir una inferencia en requisito oficial.
- Referenciar siempre el documento original antes de resumirlo.
- Registrar cualquier futura decision de alcance, arquitectura, datos o reglas en
  `docs/decisions.md` antes de reflejarla como oficial.

## Fuera de alcance

- Refactorizacion de codigo.
- Limpieza real de documentacion.
- Migracion de archivos existentes a `.ai`.
- Cambios al producto, despliegue o base de datos.
- Elaboracion completa de todos los modulos y diagramas.

## Criterios de exito

- La estructura nueva puede recorrerse desde `.ai/INDEX.md`.
- Todo hallazgo indica su evidencia o queda marcado como pendiente.
- El mapa documental incluye los Markdown existentes del proyecto.
- El plan de reorganizacion no ejecuta cambios destructivos.

## Referencias principales

- Fuente de verdad del analisis: [`.ai/`](./)
- Decisiones: [`docs/decisions.md`](../docs/decisions.md)
- Estado operativo: [`README.md`](../README.md)
- Fuente heredada temporal: [`.ia/`](../.ia/)
- Referencia activa de analisis:
  [`skills-index/system-analyst.md`](skills-index/system-analyst.md)
- Original heredado:
  [`.ia/skill/system-analyst/SKILL.md`](../.ia/skill/system-analyst/SKILL.md)
