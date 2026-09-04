# Knowledge Base Charter

## Definicion

La Knowledge Base es el modelo de conocimiento compartido del proyecto.

Dentro de BDS, representa el repositorio estructurado donde el conocimiento
relevante deja de depender de conversaciones, memoria temporal o interpretaciones
aisladas y pasa a estar disponible con evidencia, estado y trazabilidad.

## Por que es el componente central

Los roles BDS pueden tener responsabilidades diferentes, pero necesitan operar
sobre una comprension comun. La Knowledge Base proporciona ese punto de encuentro:

- conserva contexto y procedencia;
- distingue hechos, inferencias y vacios;
- registra decisiones, problemas y aprendizaje;
- reduce contradicciones entre roles;
- permite continuidad entre sesiones y personas;
- ofrece evidencia para validar resultados.

Sin una Knowledge Base compartida, cada rol reconstruiria el proyecto desde su
propia memoria y podria producir conclusiones incompatibles.

## Problema que resuelve

La Knowledge Base resuelve la fragmentacion y perdida de conocimiento. Convierte
informacion dispersa en conocimiento:

- capturado;
- estructurado;
- verificable;
- consumible por multiples roles;
- actualizable sin borrar su historia;
- rastreable hasta una fuente.

## Que no es

La Knowledge Base no es:

- un deposito indiscriminado de archivos;
- una copia completa del repositorio;
- memoria interna o temporal de un agente;
- documentacion final para usuarios externos;
- un sustituto del codigo, datos o sistemas de registro oficiales;
- una lista de opiniones sin evidencia;
- una implementacion de roles;
- un mecanismo para resolver contradicciones de forma automatica.

## Consumidores

La consumen:

- roles BDS futuros autorizados;
- responsables del proyecto;
- procesos de analisis, planificacion, validacion y documentacion;
- agentes o herramientas que necesiten contexto persistente;
- revisores que deban comprobar la procedencia de una afirmacion.

Cada consumidor debe respetar los estados epistemicos y de vigencia definidos en
`KB_RULES.md`.

## Quien puede modificarla

Solo pueden modificarla responsabilidades expresamente autorizadas por el gobierno
BDS del proyecto. Hasta que existan roles formales:

- la autoridad del proyecto aprueba cambios estructurales;
- un responsable autorizado puede capturar o actualizar conocimiento;
- un revisor autorizado valida evidencia y contradicciones;
- ningun consumidor obtiene permiso de escritura de forma implicita.

Este documento no crea el rol Knowledge Archivist ni asigna esas responsabilidades
a una identidad concreta.

## Relacion con PROJECT_CHARTER

`PROJECT_CHARTER.md` define proposito, autoridad, limites y principios generales
del ecosistema del proyecto.

Este charter especializa ese gobierno para la Knowledge Base. No puede ampliar el
alcance del proyecto ni contradecir el Project Charter. Si aparece una
incompatibilidad, debe registrarse y elevarse a la autoridad del proyecto.

## Relacion con PROJECT_CONTEXT

`PROJECT_CONTEXT.md` describe el contexto vigente del proyecto. La Knowledge Base
preserva los elementos verificables que sustentan ese contexto, su evolucion y
sus fuentes.

El Project Context funciona como vista sintetica; la Knowledge Base contiene el
modelo trazable que permite reconstruir y validar esa vista.

## Relacion con roles futuros

Los roles futuros deben:

1. consultar la Knowledge Base antes de actuar;
2. respetar sus estados y evidencia;
3. registrar nuevo conocimiento preservable;
4. declarar contradicciones o vacios;
5. evitar depender de memoria temporal cuando exista una fuente persistente.

Los contratos de rol se definiran despues de aprobar este Core. Ningun rol futuro
podra redefinir unilateralmente el esquema, las reglas o el ciclo de vida de la
Knowledge Base.

## Limite entre Core e instancia

- `.ai/core/knowledge-base/` define el contrato BDS de la Knowledge Base.
- `.ai/knowledge-base/` sera la futura instancia operativa.

La instancia operativa no se crea ni se llena en esta fase.

