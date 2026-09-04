# Casos de Uso - Calendario

## CAL-01. Abrir calendario mensual

- **Actor:** Administrador, Jefe de Servicio o Personal de Salud.
- **Objetivo:** visualizar asignaciones del mes autorizado.
- **Escenario:** el actor accede a su calendario.
- **Precondiciones:** sesión activa y rol permitido.
- **Flujo principal:** determinar alcance; cargar vista mensual; solicitar
  eventos.
- **Flujos alternativos:** personal sin perfil asociado obtiene vista vacía;
  jefatura sin servicios obtiene vista sin eventos.
- **Postcondiciones:** calendario de solo lectura visible.
- **Reglas de negocio relacionadas:** DEC-007 y DEC-013.
- **Módulo:** Calendario.
- **Evidencia utilizada:** FEAT-010/017/018; análisis
  `03-use-cases.md`.

## CAL-02. Navegar entre meses

- **Actor:** Administrador, Jefe de Servicio o Personal de Salud.
- **Objetivo:** consultar otro período mensual.
- **Escenario:** el actor selecciona mes anterior o siguiente.
- **Precondiciones:** calendario abierto.
- **Flujo principal:** cambiar rango; solicitar nuevamente eventos; renderizar
  mes.
- **Flujos alternativos:** rango sin asignaciones muestra calendario vacío.
- **Postcondiciones:** nuevo mes visible.
- **Reglas de negocio relacionadas:** actualización mediante recarga o consulta,
  sin WebSockets.
- **Módulo:** Calendario.
- **Evidencia utilizada:** DEC-007; análisis `03-use-cases.md`.

## CAL-03. Filtrar calendario

- **Actor:** Administrador o Jefe de Servicio.
- **Objetivo:** limitar eventos por servicio o personal autorizado.
- **Escenario:** se seleccionan filtros.
- **Precondiciones:** actor con opciones de filtro disponibles.
- **Flujo principal:** validar parámetros y alcance; aplicar consulta; mostrar
  eventos filtrados.
- **Flujos alternativos:** la jefatura no puede forzar servicios o personal
  ajenos.
- **Postcondiciones:** calendario filtrado.
- **Reglas de negocio relacionadas:** DEC-013 y DEC-014.
- **Módulo:** Calendario.
- **Evidencia utilizada:** análisis `04-business-rules.md` y
  `05-permissions.md`.

## CAL-04. Obtener eventos JSON

- **Actor:** Administrador, Jefe de Servicio o Personal de Salud, mediante la
  interfaz de calendario.
- **Objetivo:** recuperar asignaciones para el rango visible.
- **Escenario:** FullCalendar consulta el endpoint de eventos.
- **Precondiciones:** sesión activa y rango válido.
- **Flujo principal:** validar filtros; aplicar alcance; incluir `assigned` y
  `changed`; excluir cancelados/eliminados; devolver eventos.
- **Flujos alternativos:** parámetros no permitidos se rechazan o no producen
  datos ajenos.
- **Postcondiciones:** colección autorizada disponible para renderizado.
- **Reglas de negocio relacionadas:** usar `start_at/end_at` y color efectivo.
- **Módulo:** Calendario.
- **Evidencia utilizada:** análisis `03-use-cases.md`,
  `04-business-rules.md` y `10-flow.md`.

## CAL-05. Ver detalle de evento

- **Actor:** Administrador, Jefe de Servicio o Personal de Salud.
- **Objetivo:** consultar información de una asignación visible.
- **Escenario:** el actor selecciona un evento.
- **Precondiciones:** evento incluido en su calendario.
- **Flujo principal:** abrir modal; mostrar personal, turno, horario, servicio y
  color.
- **Flujos alternativos:** no existe edición rápida ni drag and drop.
- **Postcondiciones:** detalle visible sin modificaciones.
- **Reglas de negocio relacionadas:** calendario de solo lectura.
- **Módulo:** Calendario.
- **Evidencia utilizada:** FEAT-010; análisis `03-use-cases.md`.
