# Knowledge Base Rules

## 1. Evidencia obligatoria

Todo conocimiento debe tener evidencia. Si la evidencia aun no existe, la entrada
debe quedar como `PENDING CONFIRMATION` y señalar que falta para validarla.

## 2. Estados epistemicos

Cada afirmacion debe usar uno de estos estados:

| Estado | Significado |
|---|---|
| `CONFIRMED` | Existe evidencia suficiente y verificable |
| `INFERRED` | Es una conclusion razonable derivada de evidencia, pero no esta confirmada directamente |
| `PENDING CONFIRMATION` | No existe evidencia suficiente o falta validacion |

Un estado epistemico no debe elevarse sin agregar la evidencia correspondiente.

## 3. Prohibicion de inventar

No se deben inventar hechos, actores, requisitos, decisiones, fechas, relaciones,
reglas ni fuentes. Una ausencia de informacion se registra como vacio de
conocimiento.

## 4. Conservacion del conocimiento

El conocimiento no se elimina para ocultar que dejo de ser vigente. Debe conservar
su historia usando uno de estos estados:

| Estado | Significado |
|---|---|
| `ACTIVE` | Conocimiento vigente y utilizable |
| `OBSOLETE` | Conocimiento reemplazado o que ya no representa el estado actual |
| `ARCHIVED` | Conocimiento conservado por historia, auditoria o referencia |

Una entrada obsoleta debe enlazar, cuando exista, a la entrada que la reemplaza.

## 5. Contradicciones

Toda contradiccion debe registrarse. No puede resolverse silenciosamente ni
eliminarse una de sus versiones sin:

- identificar las afirmaciones en conflicto;
- enlazar sus fuentes;
- describir el impacto;
- indicar su estado;
- registrar la decision que la resuelve, si existe.

## 6. Trazabilidad

Todo conocimiento importante debe poder rastrearse a una fuente. Las referencias
deben ser suficientemente precisas para permitir que otro consumidor compruebe la
afirmacion.

## 7. Persistencia frente a memoria temporal

Ningun rol debe depender directamente de memoria temporal si el conocimiento
puede preservarse. Cuando un hallazgo afecte decisiones, alcance, riesgos,
operacion o continuidad, debe capturarse en la Knowledge Base.

## 8. Separacion entre evidencia e interpretacion

Las fuentes se registran como evidencia. Las conclusiones derivadas se registran
por separado y se marcan como `INFERRED` hasta su validacion.

## 9. Cambios controlados

Toda actualizacion debe:

- conservar procedencia;
- registrar fecha;
- identificar la responsabilidad que la realizo;
- mantener relaciones con versiones anteriores;
- evitar sobrescribir contradicciones no resueltas.

## 10. Consumo responsable

Los roles consumidores deben comprobar:

- estado epistemico;
- estado de vigencia;
- fecha de revision;
- evidencia;
- contradicciones relacionadas.

Una entrada `OBSOLETE`, `ARCHIVED` o `PENDING CONFIRMATION` no debe tratarse como
hecho vigente.

## 11. Alcance de autorizacion

El permiso de lectura no implica permiso de escritura. Las responsabilidades de
modificacion y validacion se asignaran en futuros contratos de rol.

## 12. Sin Knowledge Archivist en esta fase

Estas reglas definen el gobierno necesario para un rol futuro, pero no crean ni
implementan Knowledge Archivist.

