# Plan de Retiro Seguro de `.ia/`

Fecha inicial: 2026-06-19.
Ultima actualizacion: 2026-07-01.

Estado: `PLANIFICADO - NO AUTORIZADO PARA EJECUCION`.

## Objetivo

Definir las condiciones y pasos necesarios para archivar o retirar `.ia/` en una
fase futura sin perder reglas, contexto, prompts, trazabilidad ni referencias.

DEC-015 establece `.ai/` como fuente de verdad del ecosistema de analisis, pero
mantiene `.ia/` como carpeta heredada hasta completar la validacion.

## Contenido actual de `.ia/`

### Documentos de proyecto

| Archivo | Tema | Estado de migracion |
|---|---|---|
| `.ia/architecture.md` | Arquitectura, transacciones y auditoria | Copiado a `.ai/rules/architecture.md` |
| `.ia/business-rules.md` | Reglas de negocio | Copiado a `.ai/rules/business-rules.md` |
| `.ia/database-design.md` | Diseno de base de datos | Copiado a `.ai/rules/database-design.md` |
| `.ia/workflow.md` | Workflow de desarrollo | Copiado a `.ai/workflows/workflow.md` |
| `.ia/project-grade.md` | Esquema academico | Copiado a `.ai/project/project-grade.md` |
| `.ia/roadmap.md` | Roadmap hasta Sprint 10 | Copiado a `.ai/project/roadmap.md` |
| `.ia/backlog.md` | Backlog MVP y Post-MVP | Copiado a `.ai/project/backlog.md` |

### Reglas y skills breves

| Archivo | Tema | Estado de migracion |
|---|---|---|
| `.ia/skill/security.md` | Seguridad y validacion backend | Copiado a `.ai/rules/security.md` |
| `.ia/skill/crud.md` | Convenciones para CRUD | Copiado a `.ai/rules/crud.md` |
| `.ia/skill/git.md` | Convenciones Git | Copiado a `.ai/rules/git.md` |
| `.ia/skill/planning.md` | Planificacion previa | Copiado a `.ai/rules/planning.md` |
| `.ia/skill/documentation.md` | Actualizacion documental | Copiado a `.ai/rules/documentation.md` |
| `.ia/skill/database.md` | Integridad, indices y transacciones | Copiado a `.ai/rules/database.md` y verificado |
| `.ia/skill/system-analyst/SKILL.md` | Guia completa de analisis de sistemas | Preservado como referencia en `.ai/skills-index/system-analyst.md`; original completo no copiado |

## Elementos ya validados

- Se copiaron 13 archivos hacia `.ai/`.
- Las 13 copias coincidieron exactamente con sus fuentes al verificarse.
- La skill `system-analyst` tiene referencia, resumen funcional y checksum.
- Se confirmo que `.codex/` no contiene una copia de `system-analyst`.
- Existe un mapa de origen y destino en
  `.ai/reports/01-copy-migration-map.md`.
- Existe un registro de conflictos en
  `.ai/reports/02-document-conflicts.md`.
- DEC-015 define la autoridad de `.ai/` y el caracter temporal de `.ia/`.

## Elementos que faltan revisar

1. Decidir si la skill `system-analyst` debe copiarse integramente a
   `.codex/skills/system-analyst/SKILL.md` antes de archivar `.ia/`.
2. Revisar las rutas alternativas usadas para `security`, `crud`, `git`,
   `planning` y `documentation`.
3. Normalizar encabezados de `.ai/rules/architecture.md` y
   `.ai/rules/business-rules.md`, que aun mencionan `.ia/` por ser copias exactas.
4. Resolver o aceptar formalmente los conflictos documentados, especialmente la
   regla sobre aprobacion de solicitudes de cambio.
5. Revisar el artefacto `++` heredado en `architecture.md`.
6. Confirmar si roadmap y backlog deben incorporar Sprints 11 y 12.
7. Verificar referencias a `.ia/` en todo el repositorio.
8. Confirmar que no existen archivos no inventariados, ocultos o dependencias de
   herramientas que lean directamente `.ia/`.

## Riesgos de eliminar `.ia/`

| Riesgo | Impacto | Mitigacion necesaria |
|---|---|---|
| Perdida de la skill completa `system-analyst` | La referencia `.ai` no conserva todo el texto original | Copiarla integramente antes del retiro si se necesita ejecucion como skill |
| Enlaces rotos | Varios documentos `.ai` aun enlazan `.ia/` | Ejecutar busqueda global y validar enlaces |
| Perdida de procedencia | Las copias dejarian de tener original accesible | Registrar checksums, fecha, origen y version |
| Divergencia no detectada | Un original pudo cambiar despues de la copia | Comparar nuevamente antes del archivo |
| Conflictos sin resolver | Se podria conservar una regla incorrecta como definitiva | Resolver mediante decision formal |
| Afectacion a herramientas | Scripts o agentes podrian leer `.ia/` directamente | Auditar configuraciones y prompts |
| Eliminacion irreversible | Se pierde contexto historico local | Crear respaldo versionado antes de cualquier retiro |

## Pasos seguros para una fase futura

1. Congelar temporalmente cambios nuevos en `.ia/`.
2. Generar inventario final y checksums de todos sus archivos.
3. Decidir y ejecutar, si corresponde, la copia integra de `system-analyst` a su
   ubicacion definitiva.
4. Actualizar referencias internas para que apunten a `.ai/`.
5. Resolver los conflictos documentales de prioridad alta.
6. Comparar nuevamente cada origen con su destino o derivado aprobado.
7. Buscar referencias residuales con una revision global de `.ia/` en el
   repositorio.
8. Validar manualmente enlaces, prompts, workflows, plantillas y reglas.
9. Obtener aprobacion humana y registrar una nueva decision para el retiro final.
10. Crear un respaldo versionado, etiqueta o archivo de preservacion.
11. Archivar `.ia/` en una tarea separada y reversible antes de considerar su
    eliminacion.
12. Verificar que el ecosistema `.ai/` funciona sin referencias heredadas.

## Criterios de salida

`.ia/` solo puede archivarse cuando:

- Todos sus archivos tengan destino o descarte aprobado.
- No existan referencias activas necesarias hacia `.ia/`.
- Los conflictos criticos hayan sido resueltos o aceptados formalmente.
- Las copias hayan sido verificadas despues del ultimo cambio del original.
- Exista respaldo recuperable.
- Una decision posterior autorice expresamente el archivo o retiro.

## Recomendacion final

La migracion documental ya permite iniciar Knowledge Base desde `.ai/`, pero no
se recomienda eliminar `.ia/`. Debe conservarse como legado de solo referencia
hasta decidir la preservacion integra de `system-analyst`, normalizar referencias
y resolver conflictos. La opcion preferida debe ser un retiro reversible y
versionado, no una eliminacion directa.
