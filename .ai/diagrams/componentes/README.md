# Diagrama de Componentes — MediTurno

## Objetivo

Representar la arquitectura modular de MediTurno mediante componentes de
software, sus interfaces (provistas/requeridas) y sus dependencias, siguiendo
la notación UML de componentes.

## Consigna académica

La actividad del docente (ver `Diagramas_de_Componentes.pptx` en esta carpeta)
pide **agrupar las clases del dominio en 3 a 5 componentes lógicos**. MediTurno
se representa con **5 componentes**:

| Componente | Responsabilidad | Clases del dominio que agrupa |
|---|---|---|
| **InterfazWeb** | Presentación, navegación | Vistas Blade, Bootstrap 5, FullCalendar.js |
| **GestorAcceso** | Login, usuarios, permisos | User, sesión, roles, middleware |
| **GestorTurnos** | Core del negocio de turnos | Staff, HospitalService, ShiftTemplate, ServiceShiftTemplate, ShiftAssignment, calendario |
| **GestorReportes** | Reportes y auditoría | Reportes (PDF/Excel), AuditLog |
| **BaseDatos** | Persistencia | MySQL 8 (7 tablas) |

## Archivos de la Figura 4 (Diagrama de Componentes)

### Fuentes editables (fuente de verdad, filosofía BDS)
- `../01-general/04-component-plantuml.puml` — fuente PlantUML.
- `../01-general/04-component-mermaid.mmd` — fuente Mermaid.
- `../01-general/04-component-plantuml.png` — render PNG generado con
  `plantuml.jar`.

### Formatos de presentación (versión gráfica detallada)
- `04-component-MediTurno.html` — versión interactiva estilo dark (para ver en
  navegador, con animación y tarjetas resumen).
- `04-component-MediTurno.svg` — fuente vectorial editable.
- `04-component-MediTurno.png` — PNG 2400×1800 de alta resolución (para
  subir/entregar).
- `04-component-MediTurno.pdf` — PDF de una sola página (para imprimir/subir).

La versión gráfica detalla la arquitectura en funcionamiento: cliente/frontend
(Blade + Bootstrap 5 + FullCalendar), Nginx como reverse proxy
(FastCGI:9000), aplicación Laravel 10 con sus controladores, middleware
CheckRole/Throttle, Gates & Policies, Form Requests, modelos Eloquent y las
librerías DomPDF/Maatwebsite; base de datos MySQL 8 con las 7 tablas;
seguridad transversal; e infraestructura Docker (app/webserver/db). Incluye el
flujo del calendario (`GET /calendar/events`) y la regla de no traslapes.

## Elementos UML representados

- **Componente:** módulo reemplazable del sistema (recuadros con «component»).
- **Interfaz provista:** círculo en el lado del componente (el servicio que
  ofrece).
- **Interfaz requerida:** semicírculo que indica qué necesita el componente.
- **Dependencia:** línea punteada con flecha entre componente y puerto.
- **Conector de ensamblaje:** línea sólida cuando una interfaz provista se
  conecta con una requerida compatible.

## Notas

- Las fuentes académicas editables (`puml`/`mmd`) son la versión oficial de
  5 componentes para la rúbrica; los formatos gráficos de presentación
  complementan la documentación con la vista detallada de la implementación.
- La descripción académica corta para el documento de proyecto de grado se
  encuentra en `../01-general/README.md` (Figura 4).
- **Fuente:** Elaboración propia (2026).