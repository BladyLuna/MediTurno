# BDS Knowledge Base Core

## Proposito

Este directorio define el contrato base de la Knowledge Base dentro de BDS. No
contiene conocimiento de un proyecto concreto y no implementa roles.

## Documentos

| Documento | Responsabilidad |
|---|---|
| [`KB_CHARTER.md`](KB_CHARTER.md) | Define naturaleza, autoridad, limites y consumidores |
| [`KB_SCHEMA.md`](KB_SCHEMA.md) | Define la estructura minima de la futura instancia |
| [`KB_RULES.md`](KB_RULES.md) | Define evidencia, estados, trazabilidad y conservacion |
| [`KB_LIFECYCLE.md`](KB_LIFECYCLE.md) | Define el ciclo de vida del conocimiento |

## Separacion de capas

```text
.ai/core/knowledge-base/   Contrato y arquitectura BDS
.ai/knowledge-base/        Futura instancia operativa
```

La segunda ruta no se crea en esta fase.

## Estado

El Core queda definido para permitir el diseno posterior de responsabilidades y
roles. Knowledge Archivist no ha sido creado.

## Orden de lectura

1. `KB_CHARTER.md`
2. `KB_SCHEMA.md`
3. `KB_RULES.md`
4. `KB_LIFECYCLE.md`

