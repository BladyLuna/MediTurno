# Mapa de Migracion por Copia

Fecha inicial: 2026-06-19.
Ultima verificacion: 2026-07-01.

## Estado global

`MIGRACION DOCUMENTAL COMPLETADA PARA KNOWLEDGE BASE - RETIRO NO VALIDADO`

DEC-015 establece `.ai/` como nueva fuente de verdad del ecosistema de analisis y
mantiene `.ia/` como carpeta heredada temporal.

Validaciones completadas:

- Las 13 copias realizadas fueron comparadas con sus fuentes mediante `cmp`.
- Las 13 copias coincidieron exactamente al momento de la verificacion.
- Los originales permanecen en `.ia/`.
- Las rutas alternativas usadas desde `.ia/skill/` quedaron registradas.
- `.ia/skill/system-analyst/SKILL.md` fue preservada como referencia estructurada,
  con ubicacion y checksum.
- No se encontro `.codex/skills/system-analyst/SKILL.md`.

Validaciones pendientes:

- Decidir si la skill `system-analyst` requiere una copia textual completa antes
  de archivar `.ia/`.
- Normalizar referencias internas que aun nombran `.ia/` como fuente de verdad.
- Resolver los conflictos de `.ai/reports/02-document-conflicts.md`.
- Verificar todos los enlaces y referencias a `.ia/` antes de archivarla.
- Obtener aprobacion humana para la limpieza final.

## Alcance

Este registro documenta la copia de archivos heredados hacia `.ai/`. Los
originales permanecen en su ubicacion y no fueron modificados, movidos ni
eliminados.

## Mapa

| Origen | Destino | Accion | Estado | Observaciones |
|---|---|---|---|---|
| `.ia/architecture.md` | `.ai/rules/architecture.md` | Copia exacta | COPIADO | Snapshot del archivo actual; incluye cualquier artefacto preexistente |
| `.ia/business-rules.md` | `.ai/rules/business-rules.md` | Copia exacta | COPIADO | Sin resolucion de conflictos |
| `.ia/database-design.md` | `.ai/rules/database-design.md` | Copia exacta | COPIADO | Sin resolucion de conflictos |
| `.ia/skill/database.md` | `.ai/rules/database.md` | Copia exacta | COPIADO Y VERIFICADO | Regla operativa; SHA-256 registrado en el reporte de verificacion |
| `.ia/security.md` | `.ai/rules/security.md` | Verificacion de ruta solicitada | FALTANTE | No existe en `.ia/` raiz |
| `.ia/skill/security.md` | `.ai/rules/security.md` | Copia desde fuente equivalente encontrada | COPIADO CON AJUSTE | Sustituye solo la ruta faltante; requiere confirmacion humana |
| `.ia/crud.md` | `.ai/rules/crud.md` | Verificacion de ruta solicitada | FALTANTE | No existe en `.ia/` raiz |
| `.ia/skill/crud.md` | `.ai/rules/crud.md` | Copia desde fuente equivalente encontrada | COPIADO CON AJUSTE | Sustituye solo la ruta faltante; requiere confirmacion humana |
| `.ia/git.md` | `.ai/rules/git.md` | Verificacion de ruta solicitada | FALTANTE | No existe en `.ia/` raiz |
| `.ia/skill/git.md` | `.ai/rules/git.md` | Copia desde fuente equivalente encontrada | COPIADO CON AJUSTE | Sustituye solo la ruta faltante; requiere confirmacion humana |
| `.ia/planning.md` | `.ai/rules/planning.md` | Verificacion de ruta solicitada | FALTANTE | No existe en `.ia/` raiz |
| `.ia/skill/planning.md` | `.ai/rules/planning.md` | Copia desde fuente equivalente encontrada | COPIADO CON AJUSTE | Sustituye solo la ruta faltante; requiere confirmacion humana |
| `.ia/documentation.md` | `.ai/rules/documentation.md` | Verificacion de ruta solicitada | FALTANTE | No existe en `.ia/` raiz |
| `.ia/skill/documentation.md` | `.ai/rules/documentation.md` | Copia desde fuente equivalente encontrada | COPIADO CON AJUSTE | Sustituye solo la ruta faltante; requiere confirmacion humana |
| `.ia/workflow.md` | `.ai/workflows/workflow.md` | Copia exacta | COPIADO | Original conservado |
| `.ia/project-grade.md` | `.ai/project/project-grade.md` | Copia exacta | COPIADO | Documento original es un esquema breve |
| `.ia/roadmap.md` | `.ai/project/roadmap.md` | Copia exacta | COPIADO | Llega hasta Sprint 10 |
| `.ia/backlog.md` | `.ai/project/backlog.md` | Copia exacta | COPIADO | Llega hasta el cierre del MVP/Sprint 10 |
| `.commandcode/skills/frontend-design/SKILL.md` | `.ai/skills-index/frontend-design.md` | Resumen referencial | RESUMIDO | No se copio la skill completa |
| `.ia/skill/system-analyst/SKILL.md` | `.ai/skills-index/system-analyst.md` | Preservacion como referencia estructurada | REFERENCIADO Y VERIFICADO | Original completo permanece en `.ia/`; no existe copia en `.codex/` |

## Preservacion por referencia

La skill `system-analyst` no se duplico textualmente. `.ai/` conserva nombre,
proposito, uso, principios, artefactos, origen y checksum. Esto permite iniciar
Knowledge Base, pero no autoriza eliminar el original mientras no se decida su
preservacion integra.

## Regla de convivencia temporal

- `.ai/*` es la fuente de verdad para nuevos analisis y documentacion tecnica en
  proceso, de acuerdo con DEC-015.
- `.ia/*` conserva los originales heredados como respaldo temporal.
- Una actualizacion del original no actualiza automaticamente la copia.
- Antes de archivar `.ia/` deben compararse contenidos y resolverse conflictos.
- No esta autorizada la eliminacion ni limpieza definitiva de `.ia/` en esta fase.

## Siguiente control

Aplicar el plan de
[`03-legacy-ia-retirement-plan.md`](03-legacy-ia-retirement-plan.md) y documentar
la aprobacion final en una decision posterior antes de archivar o eliminar `.ia/`.
