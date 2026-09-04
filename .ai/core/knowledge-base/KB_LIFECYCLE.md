# Knowledge Base Lifecycle

## Flujo

```text
Raw Knowledge
      ↓
Captured
      ↓
Structured
      ↓
Validated
      ↓
Consumed by Roles
      ↓
Updated
      ↓
Archived if obsolete
```

## 1. Raw Knowledge

Informacion sin procesar que puede provenir de documentos, conversaciones,
observaciones, herramientas, codigo, datos o resultados de trabajo.

Caracteristicas:

- aun no pertenece formalmente a la Knowledge Base;
- puede estar incompleta, duplicada o ser contradictoria;
- no debe consumirse como hecho validado;
- requiere identificar su posible fuente.

Criterio de salida: se determina que vale la pena preservarla.

## 2. Captured

El conocimiento se registra para evitar su perdida.

Requisitos:

- contenido comprensible;
- fuente inicial;
- fecha de captura;
- estado epistemico preliminar;
- responsable de la captura.

Criterio de salida: existe informacion suficiente para clasificarlo.

## 3. Structured

La entrada se organiza dentro del esquema de la Knowledge Base.

Requisitos:

- categoria y archivo correctos;
- identificador estable;
- metadatos minimos;
- relaciones conocidas;
- contradicciones o vacios visibles.

Criterio de salida: otro consumidor puede localizarla e interpretarla.

## 4. Validated

La evidencia y la interpretacion son revisadas.

Posibles resultados:

- `CONFIRMED`;
- `INFERRED`;
- `PENDING CONFIRMATION`.

Validar no significa forzar una confirmacion. Una entrada puede quedar pendiente
si la evidencia no es suficiente.

Criterio de salida: el estado representa honestamente la calidad del conocimiento.

## 5. Consumed by Roles

Los roles autorizados utilizan el conocimiento para analizar, planificar, decidir,
documentar o ejecutar otras responsabilidades.

Antes de consumirlo deben revisar:

- estado epistemico;
- vigencia;
- evidencia;
- fecha;
- contradicciones.

El consumo puede producir nuevo conocimiento o detectar necesidad de actualizacion.

## 6. Updated

La entrada cambia porque aparece nueva evidencia, una decision, una correccion o
una contradiccion.

La actualizacion debe:

- conservar la historia relevante;
- registrar fuente y fecha;
- cambiar estados cuando corresponda;
- enlazar versiones reemplazadas;
- volver a validacion si cambia el significado.

Una actualizacion significativa puede reiniciar el ciclo desde `Structured` o
`Validated`.

## 7. Archived if obsolete

El conocimiento deja de ser vigente, pero se conserva.

Antes de archivarlo:

- marcarlo como `OBSOLETE` o `ARCHIVED`;
- indicar por que dejo de estar activo;
- enlazar el reemplazo, si existe;
- conservar evidencia y relaciones historicas.

Archivar no equivale a eliminar.

## Estados de vigencia y etapas

Las etapas del ciclo describen el procesamiento del conocimiento. Los estados
`ACTIVE`, `OBSOLETE` y `ARCHIVED` describen su vigencia. Son dimensiones
distintas y deben registrarse por separado.

## Retroalimentacion

El ciclo no es estrictamente lineal. El consumo, la validacion o una contradiccion
pueden devolver una entrada a captura, estructuracion o validacion.

