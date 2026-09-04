# Casos de Uso - Reportes

## REP-01. Consultar reporte

- **Actor:** Administrador o Jefe de Servicio.
- **Objetivo:** obtener resumen y detalle por servicio o empleado.
- **Escenario:** el actor define fechas, filtros y agrupación.
- **Precondiciones:** sesión activa y alcance autorizado.
- **Flujo principal:** validar filtros; limitar servicios para jefatura; consultar
  intervalos; calcular turnos y horas; agrupar; mostrar HTML.
- **Flujos alternativos:** rango sin datos produce resumen vacío; servicio ajeno
  no puede forzarse.
- **Postcondiciones:** reporte de solo lectura disponible.
- **Reglas de negocio relacionadas:** incluir `assigned/changed`, excluir
  cancelados/eliminados y calcular desde timestamps reales.
- **Módulo:** Reportes.
- **Evidencia utilizada:** FEAT-011/017; análisis `03-use-cases.md` y
  `04-business-rules.md`.

## REP-02. Exportar CSV

- **Actor:** Administrador o Jefe de Servicio.
- **Objetivo:** descargar el resultado en formato CSV.
- **Escenario:** el actor solicita exportación con los filtros actuales.
- **Precondiciones:** filtros válidos y alcance autorizado.
- **Flujo principal:** reutilizar consulta y filtros; generar CSV; entregar
  descarga.
- **Flujos alternativos:** filtros inválidos se rechazan; rango sin datos genera
  salida sin detalle.
- **Postcondiciones:** archivo CSV generado sin modificar datos.
- **Reglas de negocio relacionadas:** la exportación debe coincidir con la vista.
- **Módulo:** Reportes.
- **Evidencia utilizada:** FEAT-012; análisis `04-business-rules.md`.

## REP-03. Exportar PDF

- **Actor:** Administrador o Jefe de Servicio.
- **Objetivo:** obtener una versión imprimible del reporte.
- **Escenario:** el actor solicita PDF con los filtros actuales.
- **Precondiciones:** filtros válidos y alcance autorizado.
- **Flujo principal:** reutilizar resultados; construir resumen, agrupación y
  detalle; renderizar PDF.
- **Flujos alternativos:** el entorno de renderizado productivo permanece
  pendiente de confirmación.
- **Postcondiciones:** PDF generado sin modificar datos.
- **Reglas de negocio relacionadas:** mismas reglas y filtros que HTML/CSV;
  lecturas no auditadas.
- **Módulo:** Reportes.
- **Evidencia utilizada:** FEAT-013; análisis `03-use-cases.md` y
  `11-pending.md`.

