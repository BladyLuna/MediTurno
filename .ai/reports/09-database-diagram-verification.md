# 09 - Verificación del Diagrama de Base de Datos

Fecha de verificación: **2026-07-02**.

Rol BDS: **System Analyst**  
Modo: **Database Diagram Verification**

## 1. Objetivo

Verificar si MediTurno dispone de un diagrama de base de datos que cumpla la
consigna académica de haber sido obtenido desde el sistema gestor y el esquema
real, por ejemplo mediante ingeniería inversa con MySQL Workbench.

Esta revisión no modifica código, Knowledge Base ni diagramas.

## 2. Resultado ejecutivo

**Resultado: CUMPLE PARCIALMENTE**

MediTurno sí tiene un diagrama entidad-relación físico. Sin embargo, la evidencia
disponible indica que fue elaborado a partir de migraciones, modelos Eloquent,
relaciones confirmadas y análisis previo. Sus formatos son Mermaid y PlantUML.

No se encontró evidencia de que el diagrama haya sido generado mediante
ingeniería inversa desde el esquema MySQL en ejecución. Tampoco se encontraron
archivos `.mwb`, `.drawio`, imágenes o archivos PDF identificables como
exportación del diagrama de base de datos.

Por tanto, el ERD actual es válido como apoyo técnico, pero no satisface por sí
solo la exigencia específica del docente.

## 3. Diagrama existente

### Documento descriptivo

| Elemento | Valor |
|---|---|
| Ubicación | `.ai/diagrams/general/erd.md` |
| Formato | Markdown |
| Función | Describe el propósito, evidencia y enlaces a las dos representaciones |

### Representación Mermaid

| Elemento | Valor |
|---|---|
| Ubicación | `.ai/diagrams/mermaid/general/erd.mmd` |
| Formato | Mermaid, texto ASCII |
| Tipo | `erDiagram` |
| Origen declarado | Migraciones y relaciones confirmadas |

La primera línea indica:

```text
Physical ERD based on migrations and confirmed relations.
```

### Representación PlantUML

| Elemento | Valor |
|---|---|
| Ubicación | `.ai/diagrams/plantuml/general/erd.puml` |
| Formato | PlantUML, texto ASCII |
| Tipo | Entidades y relaciones |
| Origen declarado | Migraciones y relaciones confirmadas |

La cabecera también indica:

```text
Physical ERD based on migrations and confirmed relations.
```

## 4. Procedencia verificada

| Posible origen | Resultado | Evidencia |
|---|---|---|
| MySQL Workbench o gestor conectado al esquema real | No verificable y sin artefactos encontrados | No existe archivo `.mwb` ni referencia a reverse engineering |
| Migraciones | Confirmado | `.ai/diagrams/general/erd.md` referencia `database/migrations/*.php` |
| PlantUML/Mermaid | Confirmado | Existen `erd.puml` y `erd.mmd` |
| Análisis manual o derivado | Confirmado | El reporte 07 declara que se construyó desde Knowledge Base, análisis, modelos y migraciones |
| Exportación gráfica desde gestor | No encontrada | No existen `.png`, `.svg` o `.pdf` identificables como ERD del esquema |

### Conclusión sobre el origen

El origen probable y documentado es:

**migraciones + modelos + análisis, representados manualmente en Mermaid y
PlantUML**.

No existe evidencia suficiente para atribuirlo a MySQL Workbench u otro sistema
gestor.

## 5. Cobertura técnica del ERD actual

El ERD representa diez tablas principales del dominio:

1. `users`
2. `audit_logs`
3. `hospital_services`
4. `staff`
5. `shift_templates`
6. `service_shift_templates`
7. `shift_assignments`
8. `service_managers`
9. `shift_change_requests`
10. `notifications`

También representa las relaciones principales entre usuarios, servicios,
personal, plantillas, asignaciones, solicitudes, notificaciones y auditoría.

Las migraciones contienen además tablas técnicas de Laravel que no aparecen en
el ERD actual:

- `password_reset_tokens`
- `failed_jobs`
- `personal_access_tokens`

La tabla técnica `migrations`, creada y administrada por Laravel durante la
ejecución, tampoco está representada.

Esta omisión puede ser aceptable en un diagrama conceptual centrado en el
dominio, pero un diagrama obtenido automáticamente desde el esquema real
normalmente mostrará todas las tablas existentes, salvo que se oculten
deliberadamente.

## 6. Evaluación frente a la consigna

| Criterio | Estado | Observación |
|---|---|---|
| Existe un diagrama de base de datos | Cumple | Hay ERD en Mermaid y PlantUML |
| Representa tablas y relaciones principales | Cumple | Cubre diez tablas del dominio |
| Se basa en estructura persistente | Cumple | Usa migraciones, modelos y relaciones |
| Fue obtenido desde el gestor real | No cumple | No existe evidencia de ingeniería inversa |
| Tiene archivo editable del gestor | No cumple | No se encontró `.mwb` |
| Tiene exportación visual académica | No cumple | No se encontró PNG, SVG o PDF del ERD |
| Permite demostrar correspondencia con el esquema ejecutado | No cumple | Solo demuestra correspondencia documental con migraciones |

### Dictamen

**CUMPLE PARCIALMENTE**

El diagrama actual debe conservarse como apoyo del análisis y comparación, pero
la entrega académica necesita un segundo artefacto generado desde el esquema
MySQL real.

## 7. Qué falta

Para cumplir completamente la consigna se necesita:

1. Levantar la base de datos MySQL de MediTurno con todas las migraciones
   ejecutadas.
2. Conectar MySQL Workbench u otra herramienta de modelado al esquema real.
3. Ejecutar ingeniería inversa del esquema.
4. Generar el diagrama EER mostrando tablas, claves primarias, claves foráneas y
   relaciones reales.
5. Ordenar visualmente las tablas sin modificar el esquema.
6. Guardar el modelo editable, preferentemente como archivo `.mwb`.
7. Exportar el diagrama a PNG o PDF con resolución legible.
8. Identificar en la entrega el nombre del esquema y la fecha de generación.
9. Comparar la exportación con el ERD actual y documentar cualquier diferencia,
   sin corregirla silenciosamente.

## 8. Acción recomendada antes del viernes

Antes del **viernes 2026-07-03**:

1. Ejecutar el entorno y confirmar que las migraciones estén aplicadas.
2. Abrir MySQL Workbench.
3. Usar `Database > Reverse Engineer`.
4. Conectarse al MySQL del proyecto y seleccionar el esquema de MediTurno.
5. Importar todas las tablas reales.
6. Guardar el archivo como, por ejemplo,
   `docs/database/mediturno-schema.mwb`.
7. Exportar una copia legible como
   `docs/database/mediturno-schema.png` o
   `docs/database/mediturno-schema.pdf`.
8. Revisar que las relaciones y claves foráneas sean visibles.
9. Entregar la exportación del gestor como diagrama oficial y presentar el ERD
   Mermaid/PlantUML actual únicamente como apoyo técnico.

Los nombres de destino anteriores son recomendaciones; no se crearon archivos ni
carpetas durante esta verificación.

## 9. Evidencia consultada

- `.ai/diagrams/general/erd.md`
- `.ai/diagrams/mermaid/general/erd.mmd`
- `.ai/diagrams/plantuml/general/erd.puml`
- `.ai/diagrams/README.md`
- `.ai/reports/07-diagram-delivery-report.md`
- `.ai/analysis/modules/*/09-database.md`
- `database/migrations/*.php`
- Referencias a ERD y modelo físico en `.ai/`, `docs/` y `README.md`
- Inventario de archivos `.mwb`, `.png`, `.pdf`, `.svg`, `.drawio`, `.puml` y
  `.mmd`

## 10. Limitaciones

- No se abrió MySQL Workbench.
- No se realizó conexión al servidor MySQL.
- No se inspeccionó el esquema mediante comandos del gestor.
- No se creó ni modificó ningún diagrama.
- El archivo `Requerimientos para sistema web.pdf` no está identificado por su
  nombre ni por las referencias documentales como exportación del ERD.

