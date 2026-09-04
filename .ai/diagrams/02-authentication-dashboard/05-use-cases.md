# Casos de Uso - Autenticación y Dashboard

## AUTH-01. Abrir inicio de sesión

- **Actor:** Invitado.
- **Objetivo:** acceder al formulario de autenticación.
- **Escenario:** el visitante ingresa a la ruta pública de login.
- **Precondiciones:** no mantener una sesión autenticada.
- **Flujo principal:** solicitar login; verificar condición de invitado; mostrar
  formulario.
- **Flujos alternativos:** si ya existe sesión, redirigir al punto de entrada
  autenticado.
- **Postcondiciones:** formulario disponible, sin crear sesión.
- **Reglas de negocio relacionadas:** las rutas de login usan acceso de invitado.
- **Módulo:** Autenticación y Dashboard.
- **Evidencia utilizada:** `03-use-cases.md`, `05-permissions.md` y
  `10-flow.md` del análisis del módulo.

## AUTH-02. Autenticarse

- **Actor:** Invitado.
- **Objetivo:** iniciar una sesión válida.
- **Escenario:** el usuario envía correo y contraseña.
- **Precondiciones:** cuenta existente y formulario disponible.
- **Flujo principal:** validar datos; comprobar credenciales; comprobar cuenta
  activa; crear sesión; redirigir al dashboard.
- **Flujos alternativos:** credenciales inválidas o cuenta inactiva producen
  rechazo controlado.
- **Postcondiciones:** sesión autenticada para una cuenta activa.
- **Reglas de negocio relacionadas:** roles oficiales en `users.role`; rutas
  protegidas requieren autenticación y estado activo.
- **Módulo:** Autenticación y Dashboard.
- **Evidencia utilizada:** FEAT-001; DEC-001; análisis `01-summary.md`,
  `04-business-rules.md` y `10-flow.md`.

## AUTH-03. Ver dashboard

- **Actor:** Administrador, Jefe de Servicio o Personal de Salud.
- **Objetivo:** acceder a la vista inicial correspondiente al rol.
- **Escenario:** un usuario autenticado solicita el dashboard.
- **Precondiciones:** sesión válida, cuenta activa y rol oficial.
- **Flujo principal:** comprobar sesión; comprobar estado; comprobar rol; cargar
  vista y datos autorizados.
- **Flujos alternativos:** usuario no autenticado, inactivo o sin rol permitido
  no accede.
- **Postcondiciones:** dashboard autorizado visible.
- **Reglas de negocio relacionadas:** middleware `auth`, `active` y roles
  oficiales.
- **Módulo:** Autenticación y Dashboard.
- **Evidencia utilizada:** análisis `02-actors.md`, `05-permissions.md` y
  `07-controllers.md`.

## AUTH-04. Cerrar sesión

- **Actor:** Usuario autenticado.
- **Objetivo:** finalizar el acceso actual.
- **Escenario:** el usuario ejecuta logout.
- **Precondiciones:** sesión autenticada.
- **Flujo principal:** cerrar autenticación; invalidar sesión; renovar token;
  redirigir al login.
- **Flujos alternativos:** no se documentan alternativas funcionales.
- **Postcondiciones:** sesión invalidada.
- **Reglas de negocio relacionadas:** solo usuarios autenticados y activos
  acceden a la acción.
- **Módulo:** Autenticación y Dashboard.
- **Evidencia utilizada:** AUTH-04 y `10-flow.md` del análisis.

