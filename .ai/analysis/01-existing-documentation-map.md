# Mapa de Documentacion Existente

Fecha de corte: 2026-06-19.

> Nota historica: este mapa fue elaborado antes de DEC-015. Las recomendaciones
> sobre autoridad documental deben interpretarse junto con esa decision.

## Criterio

El mapa cubre los Markdown propios del repositorio, excluyendo dependencias y
archivos generados. La vigencia indicada es preliminar: no autoriza cambios ni
reemplaza una revision humana.

`.ai/` no existia al inicio. `.agents/` y `.codex/` estaban vacios.

| Archivo | Ubicacion actual | Tema | Parece vigente | Duplicado con | Recomendacion |
|---|---|---|---|---|---|
| `README.md` | Raiz | Estado del MVP, instalacion, demo y rutas | Parcial | `CLAUDE.md`, `docs/demo-flow.md`, `.ia/*` | Mantener; revisar roles y rutas posteriores a Sprint 10 |
| `CLAUDE.md` | Raiz | Contexto amplio, stack, despliegue, modulos y reglas | Parcial/Inconsistente | `README.md`, `.ia/architecture.md`, `.ia/database-design.md`, `.ia/workflow.md` | Mantener; validar CI/CD, Render, Pages, rutas, CDN y Excel antes de reutilizar |
| `revisa.md` | Raiz | Nota/prompt para crear un PRD y diagramas | No es documentacion final | `.ia/skill/system-analyst/SKILL.md` | Requiere decision humana sobre conservacion o archivo futuro |
| `decisions.md` | `docs/` | Registro DEC-001 a DEC-014 | Si; complementa fuente de verdad | `.ia/business-rules.md`, `.ia/architecture.md` | Mantener donde esta; referencia obligatoria |
| `deploy.md` | `docs/` | Preparacion y checklist de despliegue | Parcial | `README.md`, `CLAUDE.md` | Mantener; validar proveedor y advisories actuales |
| `demo-flow.md` | `docs/` | Guion de defensa del MVP | Parcial | `README.md`, `docs/qa-checklist.md` | Mantener; ampliar despues con flujos de Sprints 11 y 12 |
| `qa-checklist.md` | `docs/` | QA manual por rol y seguridad | Parcial | `docs/demo-flow.md`, pruebas automatizadas | Mantener; revisar cobertura de gestion operativa por jefatura |
| `architecture.md` | `.ia/` | Arquitectura oficial, transacciones y auditoria | Si como fuente base | `CLAUDE.md`, skills de seguridad y base de datos | Mantener sin copiar; enlazar desde analisis |
| `backlog.md` | `.ia/` | Historias y clasificacion MVP/Post-MVP | Si hasta Sprint 10 | `.ia/roadmap.md`, `README.md` | Mantener; revisar incorporacion formal de ampliaciones DEC-013/014 |
| `business-rules.md` | `.ia/` | Reglas de negocio BR-001 a BR-017 | Si como fuente base | `docs/decisions.md`, `CLAUDE.md` | Mantener; decisiones posteriores prevalecen como complemento |
| `database-design.md` | `.ia/` | Modelo de datos oficial | Si como fuente base | `CLAUDE.md` | Mantener sin duplicar; usar como referencia en modulos |
| `project-grade.md` | `.ia/` | Esquema de capitulos academicos | Incompleto | Ninguno directo | Mantener; requiere desarrollo y validacion humana |
| `roadmap.md` | `.ia/` | Roadmap funcional Sprints 1 a 10 | Si, pero no cubre extensiones | `.ia/backlog.md`, `README.md` | Mantener; decidir si DEC-013/014 deben incorporarse formalmente |
| `workflow.md` | `.ia/` | Flujo de desarrollo y controles | Si | Skills `planning`, `crud`, `documentation` | Mantener como regla general; enlazar, no copiar |
| `crud.md` | `.ia/skill/` | Checklist para CRUD | Si como instruccion breve | `.ia/workflow.md`, `.ia/architecture.md` | Mantener; evaluar consolidacion futura de skills |
| `database.md` | `.ia/skill/` | Reglas de integridad y transacciones | Si | `.ia/architecture.md`, `.ia/database-design.md` | Mantener; evitar replicar reglas en `.ai` |
| `documentation.md` | `.ia/skill/` | Archivos a actualizar al documentar | Parcial | `.ia/workflow.md` | Mantener; revisar referencia a `CHANGELOG`, actualmente ausente |
| `git.md` | `.ia/skill/` | Convenciones de ramas y commits | Parece vigente | Ninguno directo | Mantener como regla de trabajo |
| `planning.md` | `.ia/skill/` | Analisis y aprobacion antes de programar | Si | `.ia/workflow.md` | Mantener; puede enlazarse desde prompts |
| `security.md` | `.ia/skill/` | CSRF, autorizacion y validacion backend | Si | `.ia/architecture.md`, `CLAUDE.md` | Mantener; contrastar implementacion al documentar modulos |
| `SKILL.md` | `.ia/skill/system-analyst/` | Metodo completo de analisis de sistemas | Si como guia local | Nueva estructura `.ai` y sus plantillas | Mantener como original; `.ai/prompts/analyst.md` solo lo referencia |
| `SKILL.md` | `.commandcode/skills/frontend-design/` | Proceso y criterios de diseno frontend | Parece vigente para herramienta | Reglas visuales de otros agentes | Mantener en su ecosistema; no mezclar con documentacion del producto |

## Otros artefactos documentales detectados

| Archivo | Ubicacion actual | Tema aparente | Estado | Recomendacion |
|---|---|---|---|---|
| `MediTurno_Entrevista_Bladimir_Luna.docx` | `docs/` | Entrevista o levantamiento de informacion | PENDIENTE DE CONFIRMACION | Mantener y revisar contenido/autoria antes de derivar requisitos |
| `Requerimientos para sistema web.pdf` | Raiz | Requerimientos externos o iniciales | PENDIENTE DE CONFIRMACION | Mantener y realizar revision separada con trazabilidad de requisitos |

## Hallazgos preliminares

1. La duplicacion principal ocurre entre `CLAUDE.md`, `README.md` y `.ia/*`.
2. `CLAUDE.md` mezcla estado real, planes de despliegue y estructura hipotetica.
3. Los documentos de cierre en `docs/` reflejan principalmente el MVP hasta
   Sprint 10 y requieren contraste con DEC-013/014.
4. Las skills breves de `.ia/skill/` repiten parcialmente reglas de arquitectura,
   workflow y seguridad, pero actualmente funcionan como instrucciones operativas.
5. No se recomienda copiar documentos completos a `.ai`; conviene producir
   analisis derivados con enlaces y evidencia puntual.
