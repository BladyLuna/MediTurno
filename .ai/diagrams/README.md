# Paquete Académico de Diagramas de MediTurno

## Propósito

Organizar la representación gráfica validada de MediTurno para su consulta,
referencia y uso en el documento de proyecto de grado.

La estructura numerada contiene copias de las fuentes existentes y documentación
académica. Los originales permanecen en `general/`, `modules/`, `mermaid/` y
`plantuml/`.

## Índice general

| Carpeta | Área | Figuras | Casos de uso | Actividad | Secuencia | Estados |
|---|---|---:|---|---|---|---|
| [`01-general/`](01-general/README.md) | Sistema completo | 1-4 | General | No aplica | No aplica | No aplica |
| [`02-authentication-dashboard/`](02-authentication-dashboard/README.md) | Autenticación y Dashboard | 4-7 | Sí | Sí | Sí | Sí |
| [`03-users/`](03-users/README.md) | Usuarios | 8-11 | Sí | Sí | Sí | Sí |
| [`04-hospital-services/`](04-hospital-services/README.md) | Servicios Hospitalarios | 12-15 | Sí | Sí | Sí | Sí |
| [`05-staff/`](05-staff/README.md) | Personal de Salud | 16-19 | Sí | Sí | Sí | Sí |
| [`06-service-managers/`](06-service-managers/README.md) | Jefaturas por Servicio | 20-23 | Sí | Sí | Sí | Sí |
| [`07-shift-templates/`](07-shift-templates/README.md) | Plantillas de Turno | 24-27 | Sí | Sí | Sí | Sí |
| [`08-shift-assignments/`](08-shift-assignments/README.md) | Asignaciones de Turno | 28-31 | Sí | Sí | Sí | Sí |
| [`09-calendar/`](09-calendar/README.md) | Calendario | 32-34 | Sí | Sí | Sí | No aplica |
| [`10-reports/`](10-reports/README.md) | Reportes | 35-37 | Sí | Sí | Sí | No aplica |
| [`11-shift-change-requests/`](11-shift-change-requests/README.md) | Solicitudes de Cambio | 38-41 | Sí | Sí | Sí | Sí |
| [`12-notifications/`](12-notifications/README.md) | Notificaciones | 42-45 | Sí | Sí | Sí | Sí |
| [`13-audit/`](13-audit/README.md) | Auditoría | 46-48 | Sí | Sí | Sí | No aplica |
| [`componentes/`](componentes/README.md) | Anexo Figura 4 (formatos de presentación del diagrama de componentes) | 4 | No aplica | No aplica | No aplica | No aplica |

## Cantidad de diagramas

| Tipo | Figuras lógicas | Formatos por figura | Archivos fuente |
|---|---:|---|---:|
| Casos de uso generales | 1 | Mermaid y PlantUML | 2 |
| Clases del dominio | 1 | Mermaid y PlantUML | 2 |
| Entidad-relación | 1 | Mermaid y PlantUML | 2 |
| Componentes | 1 | Mermaid, PlantUML (+render PNG/SVG), HTML, SVG, PNG, PDF | 8 |
| Casos de uso por módulo | 12 | Mermaid y PlantUML | 24 |
| Actividad por módulo | 12 | Mermaid y PlantUML | 24 |
| Secuencia por módulo | 12 | Mermaid y PlantUML | 24 |
| Estados cuando aplica | 9 | Mermaid y PlantUML | 18 |
| **Total** | **49** |  | **98** |

## Documentación por módulo

Cada carpeta de módulo contiene:

- `README.md`: objetivo, actores, reglas, figuras y observaciones.
- `01-use-case-mermaid.mmd` y `01-use-case-plantuml.puml`.
- `02-activity-mermaid.mmd` y `02-activity-plantuml.puml`.
- `03-sequence-mermaid.mmd` y `03-sequence-plantuml.puml`.
- `04-state-mermaid.mmd` y `04-state-plantuml.puml` cuando existe ciclo de
  estados confirmado.
- `05-use-cases.md`: especificación académica de cada caso de uso.

Calendario, Reportes y Auditoría explican en sus respectivos README por qué no
requieren diagrama de estados.

## Convenciones

- La numeración de figuras es consecutiva de la Figura 1 a la Figura 49.
- Cada figura posee una fuente Mermaid y una fuente PlantUML.
- Los nombres de actores académicos son Invitado, Administrador, Jefe de
  Servicio y Personal de Salud.
- Los identificadores técnicos de roles se conservan como `admin`,
  `jefe_servicio` y `personal` cuando son relevantes.
- Las explicaciones académicas usan la referencia
  **Fuente: Elaboración propia (2026)**.
- Una ausencia de diagrama de estados significa que no existe ciclo de vida
  propio confirmado; no representa documentación incompleta.
- Las contradicciones se señalan, pero no se resuelven desde los diagramas.

## Relación con la Knowledge Base

Los diagramas derivan de conocimiento previamente validado en:

- `.ai/knowledge-base/features.md`
- `.ai/knowledge-base/decisions.md`
- `.ai/knowledge-base/problems.md`
- `.ai/analysis/modules/`
- `.ai/analysis/system-overview/class-traceability.md`

La Knowledge Base conserva evidencia y estados epistemológicos. Este paquete
solo presenta gráficamente ese conocimiento; no crea reglas, actores ni
relaciones nuevas.

## Limitación del ERD

El ERD Mermaid/PlantUML es apoyo técnico derivado de migraciones. La consigna
académica que exige un diagrama obtenido desde el gestor requiere adicionalmente
una exportación por ingeniería inversa desde MySQL. Véase
`.ai/reports/09-database-diagram-verification.md`.
