# Context Transfer de MediTurno

## Propósito

Esta carpeta contiene el paquete oficial de transferencia de contexto de
MediTurno. Su función es permitir que otra IA, otro chat o un desarrollador
continúe el trabajo sin leer el historial completo de conversaciones.

El Context Transfer no reemplaza la Knowledge Base, las decisiones formales ni
la documentación final. Es una vista consolidada y portable del conocimiento ya
validado.

## Objetivo

- Comunicar el estado actual del proyecto.
- Preservar las decisiones y restricciones necesarias para continuar.
- Identificar riesgos, contradicciones y pendientes sin resolverlos.
- Evitar que una nueva sesión repita análisis ya concluidos.
- Dirigir al siguiente responsable hacia las fuentes de verdad.

## Archivos

| Archivo | Uso |
|---|---|
| [`PROJECT_STATE.md`](PROJECT_STATE.md) | Estado consolidado del producto y del ecosistema BDS |
| [`NEXT_SESSION.md`](NEXT_SESSION.md) | Instrucción breve para la siguiente IA |
| [`CONTEXT_TRANSFER.md`](CONTEXT_TRANSFER.md) | Documento autocontenido para copiar a otro chat |

## Cuándo actualizar

El paquete debe actualizarse cuando ocurra al menos uno de estos eventos:

- se apruebe una nueva decisión en `docs/decisions.md`;
- cambie el alcance, el modelo de datos o una regla de negocio;
- se implemente o retire una funcionalidad;
- se valide o invalide un riesgo, conflicto o vacío de conocimiento;
- finalice una fase relevante de análisis, documentación, seguridad o QA;
- cambie el siguiente objetivo oficial del proyecto.

No debe actualizarse por cambios editoriales que no alteren el contexto de
continuidad.

## Responsable

Lo genera el rol BDS **Knowledge Archivist** en modo **Context Transfer**. Su
responsabilidad es consolidar información ya validada, no analizar, decidir,
modificar arquitectura ni cambiar código.

## Cómo utilizarlo

1. Leer primero [`CONTEXT_TRANSFER.md`](CONTEXT_TRANSFER.md).
2. Consultar [`NEXT_SESSION.md`](NEXT_SESSION.md) para identificar el trabajo
   inmediato.
3. Usar [`PROJECT_STATE.md`](PROJECT_STATE.md) cuando se requiera mayor detalle.
4. Verificar cualquier afirmación crítica en `.ai/knowledge-base/` y
   `docs/decisions.md`.
5. Registrar una nueva decisión antes de cambiar alcance, arquitectura, modelo
   de datos o reglas de negocio.

## Gobierno y límites

- `.ai/` es la fuente de verdad del análisis según DEC-015.
- `.ai/knowledge-base/` conserva conocimiento, evidencia y contradicciones.
- `docs/decisions.md` conserva las decisiones formales.
- `docs/` contiene documentación final entregable.
- `.ia/` permanece como legado temporal y no debe eliminarse todavía.
- Este paquete no convierte información pendiente en información confirmada.

Fecha del snapshot: **2026-07-02**.

