# Informe de Evaluación de Implementación de Seguridad

**Proyecto:** MediTurno — Sistema de Gestión de Turnos Hospitalarios  
**Rol:** Security Reviewer  
**Modo:** Implementation Assessment  
**Fecha:** 2026-07-24  
**Versión:** Línea Base "ANTES"  

---

## 1. Resumen Ejecutivo

Se realizó una auditoría técnica exhaustiva del código fuente del proyecto MediTurno para evaluar el estado actual de las medidas preventivas de seguridad correspondientes a cinco vulnerabilidades críticas: SQL Injection, Ataques de Fuerza Bruta, Cross-Site Scripting (XSS), Denegación de Servicio (DoS/DDoS) y Redirecciones/Reenvíos no validados.

El proyecto presenta una arquitectura Laravel 10 con uso consistente de Eloquent ORM, Blade con escape automático, middleware de autenticación y políticas de autorización. Sin embargo, se identificaron ausencias significativas en controles específicos como rate limiting en login, validación de Content Security Policy, límites de tamaño de petición y validación de URLs de redirección.

**Porcentaje estimado de implementación actual:** 35%  
**Porcentaje estimado de cumplimiento respecto a la guía del docente:** 30%  

---

## 2. Estado General de Seguridad

| Dimensión | Estado |
|-----------|--------|
| SQL Injection | Parcialmente mitigado (controles pasivos de Laravel) |
| Fuerza Bruta | No implementado |
| XSS | Parcialmente mitigado (escape Blade, sin CSP) |
| DoS/DDoS | No implementado |
| Redirecciones no validadas | Parcialmente mitigado (sin validación explícita) |

---

## 3. Análisis por Vulnerabilidad

---

### 3.1 SQL Injection

#### Nivel de exposición actual
Bajo. El proyecto utiliza Eloquent ORM de forma consistente, lo que proporciona consultas parametrizadas automáticas. No se encontraron usos de `DB::raw()`, `whereRaw()` con interpolación de usuario, ni concatenación de strings en queries.

#### Módulos afectados
- Ninguno con exposición directa. Potencialmente todos los controladores que usan `->when($request->filled(...))`.

#### Código relacionado
**ShiftAssignmentController.php** (líneas 33-35):
```php
->when($request->filled('staff_id'), fn ($query) => $query->where('staff_id', $request->integer('staff_id')))
->when($request->filled('hospital_service_id'), fn ($query) => $query->where('hospital_service_id', $request->integer('hospital_service_id')))
->when($request->filled('assignment_date'), fn ($query) => $query->whereDate('assignment_date', $request->input('assignment_date')))
```

**ShiftCalendarService.php** (línea 45):
```php
$query->whereRaw('0 = 1');
```

**LoginService.php** (línea 12):
```php
return User::query()->where('email', $email)->first();
```

#### Evidencia encontrada
- Todos los controllers usan `$request->validated()` con Form Requests.
- No se encontró ni una sola sentencia de concatenación SQL manual.
- El único `whereRaw` es `'0 = 1'` (constante, sin input de usuario).
- Los campos numéricos usan `$request->integer()` para forzar tipo.
- Los campos de fecha usan `whereDate()` con el validated input.

#### Controles existentes
- Eloquent ORM con consultas parametrizadas (protección nativa de Laravel).
- Form Requests con reglas de validación (`date`, `integer`, `exists`, `in`).
- Uso de `$request->integer()` en campos numéricos.
- Escape automático de Blade `{{ }}`.

#### Controles faltantes
- No hay un middleware global que prevenga el uso de `DB::raw()` o `whereRaw()` con input dinámico (esto es una convención más que un control técnico).
- No hay tests específicos de seguridad para SQL Injection.
- No se encontró configuración explícita de `PDO::ATTR_EMULATE_PREPARES` en `config/database.php`.

#### Riesgo actual: **Bajo**
#### Prioridad: **Baja**

#### Recomendación técnica
Mantener el uso exclusivo de Eloquent ORM. Agregar tests de integración que verifiquen que las consultas no son vulnerables a inyección. Considerar agregar `'options' => [PDO::ATTR_EMULATE_PREPARES => false]` en la conexión MySQL.

---

### 3.2 Ataques de Fuerza Bruta

#### Nivel de exposición actual
**Crítico.** No existe ningún mecanismo de rate limiting en la ruta de login. Un atacante puede realizar peticiones de autenticación ilimitadas.

#### Módulos afectados
- Autenticación (`/login`)

#### Código relacionado

**routes/web.php** (líneas 49-52):
```php
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});
```

**LoginController.php** (líneas 25-53):
```php
public function store(LoginRequest $request): RedirectResponse
{
    $credentials = $request->validated();
    $user = $this->loginService->findByEmail($credentials['email']);
    // ... autenticación sin rate limiting
}
```

**LoginRequest.php** (líneas 22-29):
```php
public function rules(): array
{
    return [
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
        'remember' => ['sometimes', 'boolean'],
    ];
}
```

**RouteServiceProvider.php** (líneas 27-29):
```php
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});
```

#### Evidencia encontrada
- `RouteServiceProvider.php` define rate limiting solo para la ruta `api`, no para `web`.
- La ruta `POST /login` no tiene middleware `throttle`.
- No hay contador de intentos fallidos por IP o por email.
- No hay bloqueo temporal después de intentos fallidos.
- La guía del docente especifica explícitamente: "bloquear después de 5 intentos fallidos usando middleware throttle".

#### Controles existentes
- Ninguno para fuerza bruta en login.

#### Controles faltantes
- Middleware `throttle:5,1` en la ruta `POST /login`.
- Registro de intentos fallidos en base de datos o cache.
- Bloqueo de cuenta después de N intentos fallidos.
- Mensaje genérico de error para no revelar si el email existe.

#### Riesgo actual: **Crítico**
#### Prioridad: **Crítica**

#### Recomendación técnica
Agregar `Route::middleware('throttle:5,1')` a la ruta `POST /login`. Implementar contador de intentos fallidos por email usando cache. Eliminar la consulta `findByEmail` separada que permite enumeración de usuarios.

---

### 3.3 Cross-Site Scripting (XSS)

#### Nivel de exposición actual
**Medio.** Blade escapa automáticamente con `{{ }}`, pero no se encontró CSP (Content Security Policy) ni validación de sanitización en campos de texto libre como `notes` y `reason`.

#### Módulos afectados
- Asignaciones de turno (campo `notes`)
- Solicitudes de cambio de turno (campo `reason`, `review_notes`)
- Calendario (renderizado de eventos via JavaScript)
- Reportes (PDF y CSV)

#### Código relacionado

**Blade — Todas las vistas usan `{{ }}`:**
```blade
{{ $user->name }}
{{ $shiftAssignment->staff?->full_name }}
{{ $shiftChangeRequest->reason }}
```

**Calendario — JavaScript (`calendar.js`, líneas 58-68):**
```javascript
eventClick: (info) => {
    const props = info.event.extendedProps;
    setModalField('staff_name', props.staff_name);
    setModalField('notes', props.notes);
    // ...
}
```

**ShiftCalendarService.php — Eventos JSON sin sanitizar (líneas 93-111):**
```php
'extendedProps' => [
    'staff_name' => $assignment->staff?->full_name,
    'notes' => $assignment->notes,
    // ...
],
```

#### Evidencia encontrada
- Todas las vistas Blade revisadas usan `{{ }}` (escape automático), ninguna usa `{!! !!}`.
- El endpoint JSON de calendario (`/admin/calendar/events`) devuelve datos directamente desde la BD sin sanitización explícita. Datos como `notes` (texto libre ingresado por admin) se renderizan en el modal via `textContent` (seguro).
- No existe CSP (Content Security Policy) configurado en Nginx ni en Laravel.
- No existe middleware de sanitización de entrada.

#### Controles existentes
- Escape automático de Blade `{{ }}` en todas las vistas.
- Uso de `textContent` en JavaScript (no `innerHTML`).
- `http_only` configurado como `true` en `config/session.php` (línea 184).
- `X-Content-Type-Options: nosniff` en Nginx (línea 8 de `default.conf`).

#### Controles faltantes
- Content Security Policy (CSP) no configurado.
- Middleware de sanitización de entrada (como HTML Purifier) para campos de texto libre.
- `X-XSS-Protection` header no configurado explícitamente (aunque es obsoleto en Chrome).

#### Riesgo actual: **Medio**
#### Prioridad: **Media**

#### Recomendación técnica
Configurar CSP en Nginx o mediante middleware. Agregar sanitización en servidor para campos de texto libre (`notes`, `reason`). Verificar que `textContent` se mantenga en lugar de `innerHTML` en JS.

---

### 3.4 Denegación de Servicio (DoS/DDoS)

#### Nivel de exposición actual
**Alto.** No existen límites de tamaño de petición, rate limiting global, ni configuración de timeout en Nginx para mitigar ataques DoS.

#### Módulos afectados
- Todos los módulos (global)

#### Código relacionado

**Nginx (`docker/nginx/default.conf`):**
```nginx
server {
    listen 80;
    server_name _;
    root /var/www/html/public;
    index index.php index.html;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

**PHP (`Dockerfile`):**
```dockerfile
FROM php:8.2-fpm
```

**.env:**
```
SESSION_DRIVER=file
```

#### Evidencia encontrada
- Nginx no tiene `limit_req_zone` ni `limit_conn_zone`.
- Nginx no tiene límite de `client_max_body_size`.
- PHP-FPM no tiene configuración explícita de `pm.max_children`, `pm.max_requests`.
- No existe `max_execution_time` personalizado.
- Sesiones almacenadas en archivos (`file` driver) — vulnerable a llenado de disco.
- El archivo `docker/nginx/default.conf` tiene solo 38 líneas con configuración mínima.
- No hay CDN, WAF ni balanceador de carga configurado.

#### Controles existentes
- Ninguno específico para DoS.

#### Controles faltantes
- `limit_req_zone` en Nginx para rate limiting por IP.
- `client_max_body_size` en Nginx.
- Configuración de pool PHP-FPM (`pm.max_children`, `pm.max_requests`).
- Timeout de Nginx (`client_body_timeout`, `client_header_timeout`).
- Configuración de `max_execution_time` en PHP.
- Sesiones en Redis o base de datos en lugar de archivo.

#### Riesgo actual: **Alto**
#### Prioridad: **Alta**

#### Recomendación técnica
Configurar `limit_req_zone` y `limit_conn_zone` en Nginx. Establecer `client_max_body_size` en 1M. Configurar `pm.max_children` y `pm.max_requests` en PHP-FPM. Agregar timeouts en Nginx y PHP.

---

### 3.5 Unvalidated Redirects and Forwards

#### Nivel de exposición actual
**Bajo.** No se encontraron redirecciones basadas en input de usuario. Todas las redirecciones son a rutas fijas con nombres de ruta. Sin embargo, no hay validación explícita de URLs.

#### Módulos afectados
- Autenticación (LoginController)
- Reportes (ReportController)

#### Código relacionado

**LoginController.php (línea 50):**
```php
return redirect()
    ->route('dashboard')
    ->with('success', 'Sesión iniciada correctamente.');
```

**LoginController.php (línea 62):**
```php
return redirect()
    ->route('login')
    ->with('success', 'Sesión cerrada correctamente.');
```

**ShiftAssignmentController.php (línea 77):**
```php
return redirect()
    ->route('admin.shift-assignments.index')
    ->with('success', 'Asignación creada correctamente.');
```

#### Evidencia encontrada
- Todas las redirecciones usan `->route('nombre.ruta')` con nombres fijos.
- No se encontró `redirect()->to()`, `redirect()->away()` ni `redirect($request->input('url'))`.
- No hay middleware `RedirectIfAuthenticated` personalizado con redirección dinámica.
- El controlador de login no tiene un parámetro `redirect` o `next` que pudiera ser manipulado.

#### Controles existentes
- Uso consistente de `->route()` con nombres de ruta predefinidos.
- No existen puntos de redirección abierta.

#### Controles faltantes
- Validación explícita de que no se permiten redirecciones a URLs externas.
- Middleware que valide URLs en parámetros de query.
- Pruebas específicas para unvalidated redirects.

#### Riesgo actual: **Bajo**
#### Prioridad: **Baja**

#### Recomendación técnica
Mantener el uso exclusivo de `->route()`. Agregar un helper o middleware que valide que cualquier redirección dinámica esté en una whitelist de URLs seguras. No implementar funcionalidad de "redirect after login" con parámetro de URL.

---

## 4. Evidencias Encontradas

### Archivos analizados (35+)

| Archivo | Vulnerabilidad Relacionada | Hallazgo |
|---------|---------------------------|----------|
| `routes/web.php:49-52` | Fuerza Bruta | Ruta login sin throttle |
| `app/Providers/RouteServiceProvider.php:27-29` | Fuerza Bruta | Rate limit solo para API |
| `app/Http/Controllers/Auth/LoginController.php:25-53` | Fuerza Bruta | Sin límite de intentos |
| `app/Services/Auth/LoginService.php:12` | Fuerza Bruta | Enumeración de emails |
| `app/Http/Requests/Auth/LoginRequest.php:22-29` | Fuerza Bruta | Sin rate limiting en request |
| `docker/nginx/default.conf` | DoS | Sin limit_req_zone ni client_max_body_size |
| `Dockerfile` | DoS | Sin configuración de pool PHP-FPM |
| `.env:23` | DoS | SESSION_DRIVER=file (riesgo de disco lleno) |
| `app/Http/Controllers/Admin/ShiftAssignmentController.php:33-35` | SQLi | Uso seguro de Eloquent |
| `resources/views/*.blade.php` | XSS | Escape `{{ }}` consistente |
| `resources/js/calendar.js:58-68` | XSS | Uso de textContent (seguro) |
| `config/session.php:184` | XSS | http_only=true |
| `docker/nginx/default.conf:7-8` | XSS | X-Frame-Options y X-Content-Type-Options |

### Fragmentos de código relevantes

**Login sin rate limiting (LoginController.php:25-53):**
```php
public function store(LoginRequest $request): RedirectResponse
{
    $credentials = $request->validated();
    $user = $this->loginService->findByEmail($credentials['email']);
    
    if (! $user) {
        return back()->withErrors(['email' => 'Las credenciales no son válidas.']);
    }
    
    if (! $user->isActive()) {
        return back()->withErrors(['email' => 'Tu cuenta está desactivada.']);
    }
    
    if (! $this->loginService->attempt($request->only('email', 'password'), ...)) {
        return back()->withErrors(['email' => 'Las credenciales no son válidas.']);
    }
    
    $request->session()->regenerate();
    return redirect()->route('dashboard');
}
```

**Nginx sin protección DoS (docker/nginx/default.conf):**
```nginx
server {
    listen 80;
    # Sin limit_req_zone
    # Sin client_max_body_size
    # Sin timeouts
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
}
```

---

## 5. Módulos Afectados

| Módulo | SQLi | Fuerza Bruta | XSS | DoS | Redirecciones |
|--------|------|-------------|-----|-----|---------------|
| Autenticación | - | **CRÍTICO** | - | Medio | Bajo |
| Dashboard | - | - | - | Medio | - |
| Usuarios | Bajo | - | Bajo | Medio | - |
| Servicios | Bajo | - | Bajo | Medio | - |
| Personal | Bajo | - | Bajo | Medio | - |
| Turnos | Bajo | - | Bajo | Medio | - |
| Asignaciones | Bajo | - | Medio | Medio | - |
| Calendario | Bajo | - | Medio | Medio | - |
| Reportes | Bajo | - | Medio | Medio | - |
| Auditoría | Bajo | - | - | Medio | - |

---

## 6. Controles Implementados

### 6.1 Controles existentes verificados

| Control | Tipo | Ubicación |
|---------|------|-----------|
| Eloquent ORM (parametrized queries) | Preventivo | Todos los modelos |
| Form Requests con validación | Preventivo | `app/Http/Requests/` |
| Middleware de autenticación | Preventivo | `routes/web.php:54` |
| Middleware de roles (`CheckRole`) | Preventivo | `app/Http/Middleware/CheckRole.php` |
| Middleware de usuario activo (`EnsureUserIsActive`) | Preventivo | `app/Http/Middleware/EnsureUserIsActive.php` |
| CSRF en todos los formularios | Preventivo | `VerifyCsrfToken.php`, @csrf en vistas |
| Escape Blade `{{ }}` | Preventivo | Todas las vistas |
| `http_only = true` en sesiones | Preventivo | `config/session.php:184` |
| `X-Frame-Options: SAMEORIGIN` | Preventivo | `docker/nginx/default.conf:7` |
| `X-Content-Type-Options: nosniff` | Preventivo | `docker/nginx/default.conf:8` |
| SoftDeletes en todos los modelos | Detective | Migraciones |
| AuditLogService para cambios | Detective | `app/Services/AuditLogService.php` |
| Políticas de autorización (Policies) | Preventivo | `app/Policies/` |
| `password => hashed` cast en User | Preventivo | `app/Models/User.php:58` |
| Bcrypt rounds = 12 | Preventivo | `config/hashing.php:32` |

### 6.2 Controles ausentes

| Control | Vulnerabilidad | Prioridad |
|---------|---------------|-----------|
| Rate limiting en login (`throttle:5,1`) | Fuerza Bruta | **Crítica** |
| Content Security Policy (CSP) | XSS | Alta |
| `client_max_body_size` en Nginx | DoS | Alta |
| `limit_req_zone` en Nginx | DoS/DDoS | Alta |
| Configuración de pool PHP-FPM | DoS | Alta |
| Sanitización de entrada (HTML Purifier) | XSS | Media |
| Timeouts de Nginx (`client_body_timeout`, etc.) | DoS | Media |
| Sesiones en Redis/BD | DoS | Media |
| Pruebas de seguridad automatizadas | Todas | Media |
| Validación de URLs de redirección | Redirecciones | Baja |
| `X-XSS-Protection` header | XSS | Baja |

---

## 7. Riesgos Identificados

| ID | Vulnerabilidad | Riesgo | Impacto | Probabilidad |
|----|---------------|--------|---------|-------------|
| R1 | Fuerza Bruta en login | **Crítico** | Acceso no autorizado al sistema | Alta |
| R2 | DoS por falta de rate limiting | **Alto** | Indisponibilidad del sistema | Alta |
| R3 | XSS sin CSP | **Medio** | Robo de sesión, phishing | Media |
| R4 | SQL Injection (residual) | **Bajo** | Fuga de datos | Baja |
| R5 | Redirecciones no validadas | **Bajo** | Phishing | Baja |

---

## 8. Priorización

| Prioridad | Vulnerabilidad | Justificación |
|-----------|---------------|---------------|
| **1** | Fuerza Bruta | Exposición crítica, sin control alguno, requisito explícito del docente |
| **2** | DoS/DDoS | Sin configuración de límites en Nginx, riesgo de indisponibilidad |
| **3** | XSS | Sin CSP, campos de texto libre sin sanitizar |
| **4** | SQL Injection | Riesgo bajo pero requiere verificación continua |
| **5** | Redirecciones | Riesgo bajo, práctica actual es segura |

---

## 9. Plan Recomendado de Implementación

### Fase 1 — Crítica (Prioridad Máxima)

1. **Rate limiting en login** — Agregar middleware `throttle:5,1` a ruta POST `/login`. Implementar contador de intentos fallidos con cache.
2. **Eliminar enumeración de usuarios** — Unificar mensajes de error en login, eliminar consulta `findByEmail` separada.

### Fase 2 — Alta Prioridad

3. **Configurar Nginx** — Agregar `limit_req_zone`, `limit_conn_zone`, `client_max_body_size`, timeouts.
4. **PHP-FPM pool** — Agregar configuración de `pm.max_children`, `pm.max_requests`.

### Fase 3 — Prioridad Media

5. **Content Security Policy** — Agregar middleware de CSP o configurar en Nginx.
6. **Sanitización de entrada** — Agregar middleware o helper para sanitizar campos de texto libre.
7. **Migrar sesiones a Redis/BD** — Cambiar `SESSION_DRIVER` a `redis` o `database`.

### Fase 4 — Prioridad Baja

8. **Validación de redirecciones** — Agregar middleware whitelist para URLs de redirección.
9. **Pruebas de seguridad** — Escribir tests automatizados para cada vulnerabilidad.

---

## 10. Conclusiones

### Vulnerabilidades ya mitigadas

- **SQL Injection**: Mitigación pasiva por uso consistente de Eloquent ORM y Form Requests con validación de tipos. Riesgo residual bajo.
- **XSS (parcial)**: Mitigación pasiva por escape automático de Blade (`{{ }}`). Sin embargo, falta CSP y sanitización de entrada.
- **Redirecciones no validadas**: Mitigación pasiva por uso exclusivo de `->route()`. Sin embargo, falta validación explícita.

### Vulnerabilidades que requieren implementación

- **Ataques de Fuerza Bruta**: **No implementado.** Requiere implementación completa de rate limiting, contador de intentos y eliminación de enumeración de usuarios.
- **DoS/DDoS**: **No implementado.** Requiere configuración de Nginx (limit_req_zone, client_max_body_size, timeouts) y PHP-FPM (pm.max_children).
- **XSS (complemento)**: Requiere implementación de CSP y sanitización de campos de texto libre.

### Porcentajes estimados

| Indicador | Porcentaje |
|-----------|------------|
| Implementación actual de medidas preventivas | **35%** |
| Cumplimiento respecto a guía del docente | **30%** |
| Cobertura de vulnerabilidades mitigadas | **40%** (2 de 5 parcialmente) |

### Nivel de confianza del análisis: **Alto**

El análisis se realizó sobre el código fuente completo del proyecto (35+ archivos revisados), incluyendo controladores, modelos, middleware, vistas Blade, configuraciones JavaScript, Docker, Nginx, Composer y configuraciones de Laravel. Todas las conclusiones están respaldadas por evidencia de código específica con ubicaciones exactas.

---

*Este informe representa la línea base "ANTES" del proyecto MediTurno. Será utilizado como referencia para comparar el estado del sistema después de aplicar las medidas preventivas de seguridad.*