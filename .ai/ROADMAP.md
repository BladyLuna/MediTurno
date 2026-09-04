# Roadmap de Documentacion y Analisis

> Este roadmap organiza el trabajo documental dentro de `.ai`. El roadmap
> funcional migrado se consulta en [`project/roadmap.md`](project/roadmap.md). Su
> original permanece temporalmente en `.ia/roadmap.md` durante la validacion.

## Fase 0 - Inventario seguro

Estado: completada en esta preparacion.

- Crear estructura `.ai`.
- Inventariar documentacion y componentes tecnicos.
- Identificar duplicaciones y documentos potencialmente desactualizados.
- Proponer reorganizacion sin aplicarla.

## Fase 1 - Validacion de fuentes

- Confirmar con responsables la autoridad del PDF y la entrevista.
- Revisar `CLAUDE.md` contra codigo e infraestructura real.
- Revisar README, QA y demo frente a DEC-013 y DEC-014.
- Determinar si roadmap y backlog oficiales deben incorporar Sprints 11 y 12.

## Fase 2 - Vista integral del sistema

- Documentar actores y roles.
- Crear mapa de modulos.
- Crear arquitectura de alto nivel.
- Crear modelo conceptual de datos.
- Iniciar matriz de trazabilidad.

Destino previsto: `.ai/analysis/system-overview/`.

## Fase 3 - Reconstruccion por sprint

- Separar objetivo solicitado, decisiones e implementacion observada.
- Documentar Sprints 1 a 12 con evidencia.
- Marcar desviaciones y pendientes.

Destino previsto: `.ai/analysis/sprints/`.

## Fase 4 - Documentacion por modulo

- Analizar cada modulo usando rutas, controladores, Requests, modelos, tablas,
  vistas, permisos y pruebas.
- Generar explicacion para defensa academica.

Destino previsto: `.ai/analysis/modules/`.

## Fase 5 - Diagramas y trazabilidad

- Diagramas Mermaid de arquitectura, flujo, secuencia, estados y datos.
- Diagramas PlantUML de casos de uso.
- Matriz actor-modulo-ruta-controlador-modelo-vista-permiso.

Destino previsto: `.ai/diagrams/` y `.ai/analysis/system-overview/`.

## Fase 6 - Consolidacion revisada

- Resolver hallazgos con revision humana.
- Definir que material debe permanecer como analisis y que material puede
  convertirse en documentacion final.
- Aplicar cualquier reorganizacion solo mediante una aprobacion posterior.
