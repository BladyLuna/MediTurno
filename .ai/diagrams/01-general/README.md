# Diagramas Generales de MediTurno

## Objetivo

Presentar una vista integral de los actores, funcionalidades, clases del dominio
y estructura física de datos de MediTurno.

## Actores

- Invitado.
- Administrador.
- Jefe de Servicio.
- Personal de Salud.

## Descripción general

Esta sección reúne las representaciones transversales del sistema. Los diagramas
se copiaron desde las fuentes Mermaid y PlantUML previamente validadas; no
reemplazan los diagramas específicos de cada módulo.

## Diagramas incluidos

### Figura 1. Diagrama General de Casos de Uso

- **Archivos:** `01-general-use-case-mermaid.mmd` y
  `01-general-use-case-plantuml.puml`.
- **Descripción:** representa los actores y los principales servicios
  funcionales de MediTurno.
- **Actores involucrados:** Invitado, Administrador, Jefe de Servicio y Personal
  de Salud.
- **Propósito:** delimitar el alcance funcional completo y la participación de
  cada actor.
- **Fuente:** Elaboración propia (2026).

### Figura 2. Diagrama General de Clases del Dominio

- **Archivos:** `02-domain-class-mermaid.mmd` y
  `02-domain-class-plantuml.puml`.
- **Descripción:** representa entidades, relaciones y dependencias de servicios
  del dominio.
- **Actores involucrados:** no aplica directamente; las clases soportan las
  operaciones de Administrador, Jefe de Servicio y Personal de Salud.
- **Propósito:** explicar la estructura conceptual del sistema sin reducirla al
  modelo físico.
- **Fuente:** Elaboración propia (2026).

### Figura 3. Diagrama Entidad-Relación

- **Archivos:** `03-erd-mermaid.mmd` y `03-erd-plantuml.puml`.
- **Descripción:** representa las tablas principales, claves y relaciones
  derivadas de migraciones y relaciones confirmadas.
- **Actores involucrados:** no aplica.
- **Propósito:** documentar el modelo físico utilizado como apoyo técnico.
- **Fuente:** Elaboración propia (2026).

### Figura 4. Diagrama de Componentes

- **Archivos:** `04-component-mermaid.mmd` y `04-component-plantuml.puml`
  (renders: `04-component-plantuml.png` y `04-component-plantuml.svg`).
  Formatos de presentación gráfica (HTML interactivo, SVG, PNG 2400×1800 y
  PDF) en [`../componentes/`](../componentes/README.md).
- **Descripción:** representa la arquitectura modular de MediTurno con
  notación UML de componentes (estereotipo «component», interfaces provistas y
  requeridas, y dependencias), siguiendo el modelo de la consigna
  `Diagramas_de_Componentes.pptx` (slides 6-8). La figura muestra la vista
  detallada de implementación: frontend (Blade + Bootstrap 5 + FullCalendar),
  Nginx como reverse proxy (FastCGI :9000), la aplicación Laravel 10 con sus
  8 controladores, middlewares CheckRole y Throttle, Gates & Policies, Form
  Requests, modelos Eloquent y las librerías DomPDF/Maatwebsite; la base de
  datos MySQL 8 con las 7 tablas (softDeletes); la seguridad transversal y el
  entorno Docker que agrupa Nginx, Laravel y MySQL. Incluye el flujo del
  calendario (`GET /calendar/events`) y la regla de no traslapes.
- **Componentes lógicos (consigna 3-5):** InterfazWeb, GestorAcceso,
  GestorTurnos, GestorReportes y BaseDatos. Agrupados a partir del diagrama de
  clases del dominio (`class-traceability.md`); la vista detallada desglosa
  los elementos de implementación que los componen.
- **Propósito:** mostrar cómo se agrupan las clases en módulos reemplazables
  con interfaces bien definidas y sus dependencias, como puente entre el
  diseño lógico (clases) y el despliegue físico.
- **Actores involucrados:** no aplica directamente; los componentes soportan
  las operaciones de Administrador, Jefe de Servicio y Personal de Salud.
- **Fuente:** Elaboración propia (2026).

## Observaciones

- El ERD actual fue elaborado desde migraciones y análisis; no sustituye la
  exportación exigida desde MySQL Workbench. Véase
  `.ai/reports/09-database-diagram-verification.md`.
- Los archivos originales permanecen en `.ai/diagrams/mermaid/` y
  `.ai/diagrams/plantuml/`.

