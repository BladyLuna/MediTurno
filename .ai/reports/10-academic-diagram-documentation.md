# 10 - Documentación Académica de Diagramas

Fecha: **2026-07-02**.

Rol BDS: **System Analyst**  
Modo: **Academic Diagram Documentation**

## Resumen ejecutivo

La colección validada de diagramas de MediTurno fue organizada como paquete
académico numerado. Los archivos originales no fueron borrados, movidos ni
modificados. Las fuentes Mermaid y PlantUML se copiaron con protección contra
sobrescritura y se complementaron con documentación por módulo.

El paquete contiene 48 figuras lógicas, 96 archivos fuente de diagramas y 25
documentos académicos dentro de la estructura numerada.

## Estructura generada

```text
.ai/diagrams/
├── 01-general/
├── 02-authentication-dashboard/
├── 03-users/
├── 04-hospital-services/
├── 05-staff/
├── 06-service-managers/
├── 07-shift-templates/
├── 08-shift-assignments/
├── 09-calendar/
├── 10-reports/
├── 11-shift-change-requests/
├── 12-notifications/
└── 13-audit/
```

Las carpetas históricas `general/`, `modules/`, `mermaid/` y `plantuml/`
permanecen intactas.

## Módulos documentados

| N.º | Módulo | Casos de uso | Actividad | Secuencia | Estados |
|---:|---|---|---|---|---|
| 1 | Autenticación y Dashboard | Sí | Sí | Sí | Sí |
| 2 | Usuarios | Sí | Sí | Sí | Sí |
| 3 | Servicios Hospitalarios | Sí | Sí | Sí | Sí |
| 4 | Personal de Salud | Sí | Sí | Sí | Sí |
| 5 | Jefaturas por Servicio | Sí | Sí | Sí | Sí |
| 6 | Plantillas de Turno | Sí | Sí | Sí | Sí |
| 7 | Asignaciones de Turno | Sí | Sí | Sí | Sí |
| 8 | Calendario | Sí | Sí | Sí | No aplica |
| 9 | Reportes | Sí | Sí | Sí | No aplica |
| 10 | Solicitudes de Cambio | Sí | Sí | Sí | Sí |
| 11 | Notificaciones | Sí | Sí | Sí | Sí |
| 12 | Auditoría | Sí | Sí | Sí | No aplica |

## Diagramas reorganizados

| Tipo | Figuras | Copias Mermaid | Copias PlantUML |
|---|---:|---:|---:|
| Generales: casos de uso, clases y ERD | 3 | 3 | 3 |
| Casos de uso por módulo | 12 | 12 | 12 |
| Actividad | 12 | 12 | 12 |
| Secuencia | 12 | 12 | 12 |
| Estados | 9 | 9 | 9 |
| **Total** | **48** | **48** | **48** |

## Documentación creada

- 13 archivos `README.md`: uno general y uno por módulo.
- 12 archivos `05-use-cases.md`.
- 57 casos de uso documentados con actor, objetivo, escenario, precondiciones,
  flujo principal, alternativas, postcondiciones, reglas, módulo y evidencia.
- Explicaciones académicas para las Figuras 1 a 48.
- Índice general ampliado en `.ai/diagrams/README.md`.

## Archivos copiados

Se copiaron 96 archivos fuente:

- 48 archivos Mermaid.
- 48 archivos PlantUML.

Las copias se realizaron desde:

- `.ai/diagrams/mermaid/`
- `.ai/diagrams/plantuml/`

Se utilizó copia sin sobrescritura (`cp -n`). No se reemplazó ningún archivo
preexistente en las carpetas numeradas.

## Archivo existente actualizado

`.ai/diagrams/README.md` ya existía como índice breve. Se actualizó porque la
tarea exige que funcione como índice académico general con módulos, cantidades,
convenciones y relación con la Knowledge Base.

Justificación:

- el contenido previo no se eliminó conceptualmente;
- su organización histórica y cobertura fueron preservadas y ampliadas;
- no era un diagrama fuente;
- la modificación era necesaria para enlazar la nueva estructura;
- ningún archivo Mermaid o PlantUML fue sobrescrito.

## Archivos no encontrados

No existían diagramas de estados para:

- Calendario.
- Reportes.
- Auditoría.

No se generaron estados artificiales. Cada README explica su ausencia:

- Calendario representa asignaciones de solo lectura.
- Reportes son resultados calculados sin ciclo de persistencia.
- Auditoría contiene eventos históricos de solo creación.

No faltaron fuentes de casos de uso, actividad o secuencia para los doce módulos.

## Trazabilidad

La documentación se apoyó en:

- `.ai/knowledge-base/`
- `.ai/analysis/modules/`
- `.ai/analysis/system-overview/class-traceability.md`
- `.ai/diagrams/` existente
- `.ai/reports/06-system-analysis-audit.md`
- `.ai/reports/07-diagram-delivery-report.md`
- `.ai/reports/09-database-diagram-verification.md`

No se modificó la Knowledge Base ni se volvió a analizar funcionalmente el
sistema.

## Posibles mejoras antes de la entrega

1. Renderizar las fuentes Mermaid y PlantUML a imágenes de alta resolución.
2. Insertar cada figura en el documento académico conservando número, título y
   fuente.
3. Verificar legibilidad en formato A4 y dividir diagramas muy densos si fuera
   necesario.
4. Generar el diagrama oficial de base de datos desde MySQL Workbench y
   presentarlo junto al ERD de apoyo.
5. Resolver CONFLICT-003 y CONFLICT-004 antes de cerrar la narrativa de defensa.
6. Revisar con el tutor si los flujos alternativos deben adoptar una plantilla
   institucional específica.
7. Añadir referencias cruzadas desde los capítulos del documento final hacia
   estas figuras.

## Resultado

**Paquete académico organizado y completo con observaciones menores.**

La estructura está lista para producir imágenes e incorporarlas al documento de
proyecto de grado. El único diagrama que todavía requiere un artefacto externo
para cumplir una consigna específica es el ERD obtenido desde el gestor MySQL.

