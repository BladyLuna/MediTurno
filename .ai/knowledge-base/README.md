# MediTurno Knowledge Base

## Mision

Preservar el conocimiento verificable del proyecto sin perder contexto,
procedencia, contradicciones ni preguntas abiertas.

Esta instancia implementa el contrato definido en
[`../core/knowledge-base/`](../core/knowledge-base/README.md).

## Alcance

La Knowledge Base conserva:

- fuentes y evidencia;
- evolucion y linea temporal;
- decisiones;
- funcionalidades declaradas;
- problemas y soluciones documentadas;
- contradicciones;
- lecciones;
- vacios de conocimiento;
- prompts importantes.

No sustituye el codigo, las decisiones formales ni la documentacion final.

## Estados epistemicos

| Estado | Uso |
|---|---|
| `CONFIRMED` | Existe evidencia directa y verificable |
| `INFERRED` | Conclusion derivada de evidencia, no confirmada directamente |
| `PENDING CONFIRMATION` | Evidencia insuficiente, contradictoria o no revisada |

## Estados de vigencia

| Estado | Uso |
|---|---|
| `ACTIVE` | Conocimiento vigente |
| `OBSOLETE` | Conocimiento reemplazado o desactualizado |
| `ARCHIVED` | Conocimiento conservado solo por historia o auditoria |

## Reglas de uso

1. Toda entrada debe indicar fuente y estado.
2. Una contradiccion se registra; no se resuelve implicitamente.
3. El conocimiento no se elimina por quedar obsoleto.
4. Las fuentes originales no se modifican desde esta Knowledge Base.
5. La memoria de conversacion se preserva cuando contiene conocimiento que no
   existe en archivos permanentes.
6. Una entrada `PENDING CONFIRMATION` no debe consumirse como hecho.

## Fecha de captura inicial

2026-07-01.

## Responsable de esta captura

Rol BDS: Knowledge Archivist.

La responsabilidad se limita a preservar y estructurar conocimiento dentro de
`.ai/knowledge-base/`.

