# Important Prompts Registry

## PROMPT-001 - Puerta de planificacion

**Proposito:** impedir implementacion sin analisis y aprobacion previa.

**Contenido preservado:**

- analizar requerimientos;
- identificar reglas afectadas;
- crear plan;
- esperar aprobacion;
- no generar codigo inmediatamente.

**Fuente:** `.ai/rules/planning.md`, historial de sesion.

**Estado:** `CONFIRMED`

**Vigencia:** `ACTIVE`

---

## PROMPT-002 - Congelacion documental

**Proposito:** controlar cambios de alcance, datos y reglas.

**Contenido preservado:**

- la documentacion se congela;
- los cambios relevantes deben registrarse en decisiones;
- la fuente de verdad historica fue `.ia/*`;
- DEC-015 migro el ecosistema de analisis a `.ai/*`.

**Fuente:** SRC-002 DEC-002 y DEC-015.

**Estado:** `CONFIRMED`

**Vigencia:** `ACTIVE`, considerando que DEC-015 reemplaza parte de DEC-002.

---

## PROMPT-003 - Patron de trabajo por sprint

**Proposito:** mantener implementaciones revisables y verificadas.

**Contenido preservado:**

1. Analizar documentacion y modelo actual.
2. Enumerar migraciones, modelos, controladores, Requests, servicios, vistas,
   rutas y pruebas.
3. Esperar aprobacion antes de escribir codigo.
4. Implementar solo el alcance aprobado.
5. Ejecutar pruebas dentro de Docker.
6. Corregir errores y reportar desviaciones.

**Fuente:** SRC-024; `.ai/workflows/workflow.md`.

**Estado:** `CONFIRMED`

**Vigencia:** `ACTIVE`

---

## PROMPT-004 - Migracion documental segura

**Proposito:** reorganizar conocimiento sin perder originales.

**Contenido preservado:**

- no borrar, mover ni renombrar fuentes;
- copiar hacia `.ai/`;
- registrar origen y destino;
- documentar conflictos sin resolverlos;
- verificar copias;
- no retirar `.ia/` sin aprobacion humana.

**Fuente:** SRC-024, SRC-002 DEC-015, SRC-011, SRC-028.

**Estado:** `CONFIRMED`

**Vigencia:** `ACTIVE`

---

## PROMPT-005 - Knowledge Base Core

**Proposito:** definir Knowledge Base antes de crear roles.

**Contenido preservado:**

- Knowledge Base es el modelo de conocimiento compartido;
- todo conocimiento requiere evidencia;
- usar `CONFIRMED`, `INFERRED` y `PENDING CONFIRMATION`;
- no eliminar conocimiento, sino usar `ACTIVE`, `OBSOLETE` o `ARCHIVED`;
- registrar contradicciones;
- preservar antes de analizar;
- separar Core de instancia operativa.

**Fuente:** SRC-012 a SRC-016; SRC-024.

**Estado:** `CONFIRMED`

**Vigencia:** `ACTIVE`

---

## PROMPT-006 - Rol Knowledge Archivist

**Proposito:** poblar o actualizar la Knowledge Base sin realizar desarrollo,
analisis funcional ni decisiones de arquitectura.

**Mision preservada:**

> Preservar el conocimiento del proyecto sin perder contexto.

**Responsabilidad unica:**

Transformar conocimiento disperso en una Base de Conocimiento estructurada.

**Principios preservados:**

- preservar antes de resumir;
- conservar contexto;
- no inventar;
- rastrear afirmaciones a fuentes;
- indicar incertidumbre;
- registrar dudas en vez de asumir;
- tratar la Knowledge Base como activo.

**Fuentes permitidas:**

- conversaciones disponibles;
- historial de sesion;
- README;
- Project Context y Project Charter;
- documentacion existente;
- codigo solo como evidencia;
- decisiones;
- reportes;
- Markdown, PDF y otros documentos disponibles.

**Prohibiciones:**

- no modificar codigo;
- no modificar arquitectura;
- no generar diagramas;
- no analizar modulos funcionalmente;
- no crear reglas de negocio;
- no cambiar documentacion existente;
- no eliminar informacion.

**Directorio autorizado:** `.ai/knowledge-base/`

**Salida requerida:**

- conocimiento preservado;
- archivos creados o modificados;
- informacion pendiente;
- contradicciones;
- recomendaciones para el siguiente rol.

**Fuente:** prompt actual en SRC-024.

**Estado:** `CONFIRMED`

**Vigencia:** `ACTIVE`

