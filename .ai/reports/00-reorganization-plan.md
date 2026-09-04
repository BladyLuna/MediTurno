# Plan de Reorganizacion Documental

Estado: propuesta solamente. No se aplicaron movimientos, eliminaciones,
renombres ni modificaciones a archivos existentes.

> Actualizacion de gobernanza: DEC-015 establecio posteriormente `.ai/` como
> fuente de verdad del ecosistema de analisis. Este reporte se conserva como
> antecedente de la fase preparatoria.

## Principios

1. `.ia/*` conserva su funcion de fuente de verdad.
2. `docs/decisions.md` conserva el historial de decisiones posteriores.
3. `docs/` conserva documentacion final, operativa y de defensa.
4. `.ai/` se usa para inventario, analisis, plantillas, diagramas y reportes.
5. Los directorios de herramientas (`.commandcode`, `.agents`, `.codex`) no deben
   mezclarse con documentacion funcional del producto.
6. Toda copia futura debe conservar enlace, origen, fecha y motivo.

## Archivos que deberian quedarse donde estan

| Archivo o grupo | Motivo |
|---|---|
| `.ia/*` | Fuente de verdad declarada por DEC-002 |
| `docs/decisions.md` | Registro historico y normativo de decisiones |
| `README.md` | Punto de entrada del repositorio |
| `CLAUDE.md` | Contexto especifico para una herramienta; requiere correcciones futuras, no traslado |
| `docs/deploy.md` | Guia operativa final |
| `docs/demo-flow.md` | Material de defensa y demostracion |
| `docs/qa-checklist.md` | Checklist final de QA |
| `.commandcode/skills/frontend-design/` | Instruccion propia de esa herramienta |
| PDF y DOCX existentes | Fuentes originales que no deben alterarse ni perder procedencia |

## Material que podria derivarse despues hacia `.ai`

No se recomienda copiar archivos completos. Se proponen documentos derivados:

| Fuente original | Derivado futuro | Destino sugerido |
|---|---|---|
| `.ia/roadmap.md` y `docs/decisions.md` | Reconstruccion plan/resultado por sprint | `.ai/analysis/sprints/` |
| `.ia/business-rules.md` | Matriz regla-modulo-prueba | `.ai/analysis/system-overview/` |
| `.ia/database-design.md` y migraciones | Modelo de datos explicado y diagrama ER | `.ai/analysis/system-overview/`, `.ai/diagrams/mermaid/` |
| Rutas, controladores, Requests, modelos y vistas | Analisis por modulo | `.ai/analysis/modules/` |
| `docs/demo-flow.md` | Flujos completos por actor | `.ai/analysis/system-overview/` |
| `.ia/skill/system-analyst/SKILL.md` | Prompt operativo resumido con referencia | `.ai/prompts/analyst.md` |

## Grupos que parecen duplicados

### Vision, stack y estado

- `README.md`
- `CLAUDE.md`
- `.ia/architecture.md`

Recomendacion: mantener sus funciones distintas. README debe resumir el estado
real; `.ia` debe definir lo oficial; `CLAUDE.md` debe contener solo contexto de la
herramienta y enlazar las fuentes.

### Roadmap y backlog

- `.ia/roadmap.md`
- `.ia/backlog.md`
- secciones de modulos/incrementos en `CLAUDE.md`

Recomendacion: roadmap para secuencia, backlog para historias y CLAUDE solo como
enlace. No consolidar hasta resolver Sprints 11 y 12.

### Reglas, seguridad e integridad

- `.ia/business-rules.md`
- `.ia/architecture.md`
- `.ia/skill/security.md`
- `.ia/skill/database.md`
- reglas resumidas en `CLAUDE.md` y `README.md`

Recomendacion: reglas oficiales en `.ia`; skills como checklists; otros documentos
solo resumen y referencia.

### Demo, QA y estado final

- `README.md`
- `docs/demo-flow.md`
- `docs/qa-checklist.md`

Recomendacion: README resume; demo-flow guia la exposicion; QA conserva criterios
verificables. Evitar repetir listas completas.

## Archivos que parecen reglas del proyecto

- `.ia/architecture.md`
- `.ia/business-rules.md`
- `.ia/database-design.md`
- `.ia/workflow.md`
- `.ia/skill/*.md`
- `docs/decisions.md`

Tratamiento recomendado: no mover ni copiar. Referenciar siempre el original.

## Archivos que parecen documentacion final

- `README.md`
- `docs/deploy.md`
- `docs/demo-flow.md`
- `docs/qa-checklist.md`
- entrevista DOCX, sujeto a confirmacion de su funcion academica.

Tratamiento recomendado: mantener en ubicacion actual y actualizar solo mediante
una tarea futura aprobada.

## Archivos que parecen prompts o workflows

- `CLAUDE.md`
- `revisa.md`
- `.ia/workflow.md`
- `.ia/skill/*.md`
- `.commandcode/skills/frontend-design/SKILL.md`

Tratamiento recomendado: conservar segun la herramienta o funcion. Evaluar despues
si `revisa.md` sigue siendo necesario.

## Archivos que necesitan revision humana

1. `CLAUDE.md`: afirma CI/CD, Render, GitHub Pages, rutas y componentes que no se
   confirmaron en la estructura actual; tambien menciona FullCalendar por CDN y
   Excel con Maatwebsite, mientras las dependencias observadas usan Vite y no
   incluyen ese paquete de Excel.
2. `README.md`: resume el cierre del MVP, pero no refleja todo el alcance operativo
   agregado por DEC-013 y DEC-014.
3. `docs/demo-flow.md` y `docs/qa-checklist.md`: requieren cobertura de las vistas
   por rol y gestion operativa de jefatura.
4. `.ia/roadmap.md` y `.ia/backlog.md`: terminan en Sprint 10; debe decidirse si se
   actualizan para incorporar Sprints 11 y 12 o si las decisiones son suficientes.
5. `.ia/project-grade.md`: es un esquema sin contenido desarrollado.
6. `revisa.md`: parece una solicitud temporal, no una fuente normativa.
7. PDF y DOCX: necesitan lectura y clasificacion de autoridad, version y fecha.
8. `docs/deploy.md`: requiere confirmar plataforma objetivo y estado actual de
   dependencias antes de usarlo como guia productiva.

## Secuencia propuesta para una reorganizacion futura

1. Aprobar este inventario y corregir clasificaciones erradas.
2. Definir una matriz de autoridad por tipo de documento.
3. Revisar documentos marcados como parciales o inconsistentes.
4. Crear analisis por sprint y modulo sin tocar originales.
5. Construir trazabilidad y diagramas desde codigo confirmado.
6. Proponer cambios concretos, archivo por archivo.
7. Aplicar cambios solo despues de aprobacion y registrarlos en decisiones cuando
   afecten alcance, arquitectura, datos o reglas.

## Resultado de esta fase

- No se realizo limpieza real.
- No se copiaron fuentes completas.
- No se modifico documentacion existente.
- Quedo preparado un espacio seguro para el analisis incremental.
