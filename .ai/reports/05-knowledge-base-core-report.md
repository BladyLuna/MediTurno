# Reporte de Knowledge Base Core

Fecha: 2026-07-01.

## Alcance

Se definio la arquitectura base de la Knowledge Base dentro de BDS. No se creo la
instancia `.ai/knowledge-base/`, no se implementaron roles y no se documento
ningun proyecto concreto.

## Archivos creados

| Archivo | Proposito |
|---|---|
| `.ai/core/knowledge-base/KB_CHARTER.md` | Define que es la Knowledge Base, por que es central, sus limites y gobierno |
| `.ai/core/knowledge-base/KB_SCHEMA.md` | Define archivos, preguntas, contenido y responsabilidades de la futura instancia |
| `.ai/core/knowledge-base/KB_RULES.md` | Define evidencia, estados epistemicos, vigencia, contradicciones y trazabilidad |
| `.ai/core/knowledge-base/KB_LIFECYCLE.md` | Define el ciclo desde conocimiento crudo hasta archivo |
| `.ai/core/knowledge-base/README.md` | Explica el Core, navegacion y separacion entre contrato e instancia |

## Archivos actualizados

| Archivo | Cambio |
|---|---|
| `.ai/INDEX.md` | Agrega BDS Core y navegacion hacia Knowledge Base Core |
| `.ai/PROJECT_CHARTER.md` | Incorpora Knowledge Base como componente central y el conocimiento como activo |

## Decisiones tomadas

1. Separar el contrato BDS de la instancia operativa:
   `.ai/core/knowledge-base/` frente a `.ai/knowledge-base/`.
2. No crear la instancia operativa durante esta fase.
3. No crear Knowledge Archivist ni otros roles.
4. Tratar el conocimiento como activo persistente y trazable.
5. Exigir evidencia y estados epistemicos.
6. Conservar conocimiento obsoleto mediante estados, no mediante eliminacion.
7. Definir responsabilidades futuras sin convertirlas todavia en roles.
8. Exigir que los roles futuros consulten y actualicen la base compartida.

## Riesgos evitados

- Crear roles antes de definir la fuente que deben consumir.
- Depender de memoria temporal.
- Mezclar evidencia con inferencias.
- Eliminar conocimiento historico.
- Resolver contradicciones silenciosamente.
- Convertir la Knowledge Base en un deposito sin estructura.
- Acoplar el Core BDS a un proyecto especifico.
- Confundir el contrato con la instancia operativa.

## Estado de preparacion

El Core contiene charter, esquema, reglas y ciclo de vida suficientes para diseñar
el contrato de Knowledge Archivist en una fase posterior.

Esto no significa que el rol exista ni que la Knowledge Base operativa haya sido
instanciada.

## Siguiente paso recomendado

Definir el contrato del rol Knowledge Archivist contra este Core, especificando:

- responsabilidades;
- entradas y salidas;
- permisos de lectura y escritura;
- criterios de captura y validacion;
- interaccion con otros roles;
- limites y controles.

La creacion del rol debe realizarse en una tarea separada y aprobada.
