# MediTurno — Contexto del Proyecto para Claude Code

## 🏥 ¿Qué es este proyecto?

**MediTurno** es un sistema web de gestión de turnos del personal de salud de un hospital.
Reemplaza el uso de Excel por una plataforma web con roles, calendario visual y reportes.

- **Autor:** Bladimir Luna Corrales
- **Tutor:** Ing. Edson Flores Condori
- **Institución:** ITNC "Federico Álvarez Plata" Nocturno
- **Stack:** Laravel 10 + MySQL + Bootstrap 5

---

## 🛠️ Stack Tecnológico

| Capa | Tecnología | Para qué |
|------|-----------|---------|
| Backend | PHP 8.2 + Laravel 10 | Lógica, base de datos, roles |
| Frontend | Blade Templates + Bootstrap 5 | Vistas, diseño responsive |
| Interactividad | JavaScript (mínimo) | Calendario (FullCalendar), alertas, confirmaciones |
| Base de datos | MySQL 8 | Almacenamiento |
| Entorno local | Docker + Docker Compose | Servidor PHP + MySQL en contenedores |
| Control de versiones | Git + GitHub | Repositorio del código |
| CI/CD | GitHub Actions | Tests + deploy automático a Render |
| Hosting | Render | Deploy del sistema Laravel en producción |
| Landing page | GitHub Pages | Presentación estática del proyecto |

> **Nota:** PHP y JavaScript se complementan. PHP maneja el servidor, base de datos y
> seguridad. JavaScript se usa solo para mejorar la experiencia visual (calendario,
> modales, confirmaciones). Bootstrap incluye su propio JS automáticamente.

---

## 🐳 Entorno Docker

### Estructura de contenedores (`docker-compose.yml`)
```yaml
services:
  app:        # PHP 8.2 + Laravel (imagen: php:8.2-fpm)
  webserver:  # Nginx (imagen: nginx:alpine)
  db:         # MySQL 8 (imagen: mysql:8.0)
```

### Comandos frecuentes
```bash
# Levantar el entorno
docker-compose up -d

# Ejecutar comandos Laravel dentro del contenedor
docker-compose exec app php artisan migrate
docker-compose exec app php artisan make:model NombreModelo -mcr
docker-compose exec app php artisan cache:clear
docker-compose exec app composer install

# Ver logs
docker-compose logs -f app

# Detener contenedores
docker-compose down
```

### Variables de entorno (`.env`)
```env
APP_ENV=local
APP_URL=http://localhost:8080

DB_HOST=db          # nombre del servicio Docker, NO localhost
DB_PORT=3306
DB_DATABASE=mediturno
DB_USERNAME=mediturno_user
DB_PASSWORD=secret
```

> ⚠️ NUNCA subir `.env` a GitHub. Usar `.env.example` sin credenciales reales.

---

## 🔄 CI/CD con GitHub Actions

### Archivo: `.github/workflows/deploy.yml`
El pipeline debe hacer en orden:
1. Checkout del código
2. Instalar dependencias PHP (`composer install`)
3. Copiar `.env.example` → `.env` y generar key
4. Ejecutar migraciones en entorno de test
5. Correr tests (`php artisan test`)
6. Si todo pasa → deploy automático a Render vía webhook

### Cuándo se ejecuta
- En cada `push` a la rama `main`
- En cada Pull Request hacia `main`

---

## 🚀 Hosting en Render

- **Tipo de servicio:** Web Service (PHP)
- **Base de datos:** MySQL 8
- **Deploy:** automático desde GitHub rama `main`
- **Variables de entorno:** configuradas en el dashboard de Render (nunca en el código)
- **URL del sistema:** `https://mediturno.onrender.com` *(o el nombre elegido)*

### Consideraciones para Render
- Configurar `APP_ENV=production` y `APP_DEBUG=false`
- Forzar HTTPS siempre en producción
- Usar `php artisan config:cache` y `php artisan route:cache` para mejor rendimiento

---

## 🌐 GitHub Pages — Landing Page

Carpeta: `docs/` en el repositorio (rama `main`)

La landing page es una presentación **estática** del proyecto MediTurno en HTML/CSS/JS puro.
No tiene PHP ni Laravel, solo muestra información del sistema.

### Contenido de la landing page
- Hero: nombre del proyecto + descripción breve
- Problema que resuelve (Excel vs MediTurno)
- Los 9 módulos del sistema
- Stack tecnológico
- Capturas de pantalla del sistema
- Enlace al sistema en Render
- Enlace al repositorio GitHub
- Datos del autor

### Activar GitHub Pages
1. Ir a Settings → Pages en el repositorio
2. Source: rama `main`, carpeta `/docs`
3. URL: `https://bladimir-luna.github.io/mediturno`

---

## Fuente de Verdad

Los documentos dentro de `.ia/` son la fuente de verdad para arquitectura, reglas
de negocio, roadmap, backlog y diseño de base de datos.

`README.md` y `CLAUDE.md` deben mantenerse alineados con `.ia/*`.

## 👥 Roles del Sistema

| Rol | Guard | Accesos |
|-----|-------|---------|
| `admin` | web | Todo el sistema |
| `jefe_servicio` | web | Turnos y personal de los servicios que administra |
| `personal` | web | Ver sus turnos y calendario |

Implementar roles con `users.role`, Laravel Gates y Policies.

Decisión oficial:
No usar paquetes externos de permisos en este proyecto.

Un jefe de servicio puede administrar múltiples servicios.

---

## 📦 Módulos — Orden de Desarrollo (Metodología Incremental)

### INCREMENTO 1 — Base del sistema
1. **Autenticación** (`/login`, `/logout`, `/forgot-password`)
2. **Usuarios** (`/admin/users` — CRUD completo + roles)

### INCREMENTO 2 — Datos maestros
3. **Servicios** (`/admin/services` — CRUD áreas del hospital)
4. **Personal** (`/admin/staff` — CRUD empleados + asignar servicio)

### INCREMENTO 3 — Core del sistema
5. **Turnos** (`/admin/shifts` — CRUD tipos M/T/N + colores + plantillas por servicio)
6. **Asignación** (`/admin/assignments` — asignar turno + validar traslapes)

### INCREMENTO 4 — Visualización
7. **Calendario** (`/calendar` — vista mensual con FullCalendar.js + colores)

### INCREMENTO 5 — Reportes y configuración
8. **Reportes** (`/admin/reports` — PDF con DomPDF / Excel con Maatwebsite)
9. **Configuración** (`/admin/config`)

### INCREMENTO 6 — Deploy
10. **CI/CD** → GitHub Actions configurado
11. **Render** → sistema en producción
12. **GitHub Pages** → landing page publicada

---

## 🗄️ Esquema de Base de Datos

```sql
-- Usuarios del sistema
users: id, name, email, password, role(admin|jefe_servicio|personal), active, timestamps

-- Servicios hospitalarios
hospital_services: id, name, description, active, timestamps
-- Ejemplos: Emergencia, Laboratorio, Neonatología, UCI, Cirugía

-- Personal de salud
staff: id, user_id(FK), hospital_service_id(FK), ci, full_name, position, phone, active, timestamps

-- Tipos base de turno
shift_templates: id, code, name, start_time, end_time, color(hex), is_working_shift, active, timestamps
-- Mañana(07:00-14:00, #22c55e), Tarde(14:00-21:00, #f59e0b), Noche(21:00-07:00, #6366f1)

-- Plantillas de turno por servicio
service_shift_templates: id, hospital_service_id(FK), shift_template_id(FK),
                         custom_code, custom_name, custom_start_time,
                         custom_end_time, custom_color, active, timestamps

-- Asignaciones de turno
shift_assignments: id, staff_id(FK), hospital_service_id(FK),
                   service_shift_template_id(FK), assignment_date,
                   start_at, end_at, status(assigned|changed|cancelled),
                   notes, created_by(FK users), updated_by(FK users), timestamps
-- Regla oficial: no se permiten turnos traslapados.

-- Bitácora de auditoría
audit_logs: id, user_id(FK), action, model, model_id,
            old_values(json), new_values(json), ip_address, timestamps
```

---

## 📁 Estructura de Archivos

```
mediturno/
├── .github/
│   └── workflows/
│       └── deploy.yml          ← CI/CD GitHub Actions
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/LoginController.php
│   │   │   ├── Admin/UserController.php
│   │   │   ├── Admin/ServiceController.php
│   │   │   ├── Admin/StaffController.php
│   │   │   ├── Admin/ShiftController.php
│   │   │   ├── Admin/AssignmentController.php
│   │   │   ├── Admin/ReportController.php
│   │   │   ├── Admin/ConfigController.php
│   │   │   └── CalendarController.php
│   │   ├── Middleware/
│   │   │   └── CheckRole.php
│   │   └── Requests/           ← Form Requests para validación
│   └── Models/
│       ├── User.php
│       ├── HospitalService.php
│       ├── Staff.php
│       ├── ShiftTemplate.php
│       ├── ServiceShiftTemplate.php
│       ├── ShiftAssignment.php
│       └── AuditLog.php
├── database/migrations/
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php       ← Layout principal
│   │   └── auth.blade.php      ← Layout de login
│   ├── auth/
│   ├── dashboard/
│   ├── admin/
│   └── calendar/
├── routes/web.php
├── docker-compose.yml          ← Entorno local Docker
├── Dockerfile
├── docs/                       ← Landing page GitHub Pages
│   ├── index.html
│   ├── style.css
│   └── assets/
├── .env.example                ← Sin credenciales reales
├── .claudeignore
├── CLAUDE.md                   ← Este archivo
└── README.md
```

---

## 🎯 Skills para Claude Code

### Al generar un módulo nuevo:
- Crear migration + model + controller resource + views + rutas juntas
- El controller debe tener los 7 métodos: `index, create, store, show, edit, update, destroy`
- Todas las vistas extienden `@extends('layouts.app')`
- Siempre incluir mensajes flash: `@if(session('success'))` y `@if(session('error'))`
- Cada form con `@csrf` y atributos `required` en campos obligatorios

### Para el Calendario:
- Usar **FullCalendar.js** (CDN) para la vista mensual
- Los colores vienen de `service_shift_templates.custom_color` o `shift_templates.color`
- Endpoint de eventos: `GET /calendar/events?month=Y-m` → devuelve JSON
- Formato de evento FullCalendar: `{ title, start, color, extendedProps }`
- La actualización del calendario será mediante recarga de vista o nueva consulta al endpoint.

### Para Reportes:
- PDF → **barryvdh/laravel-dompdf**: `composer require barryvdh/laravel-dompdf`
- Excel → **maatwebsite/excel**: `composer require maatwebsite/excel`
- Filtros disponibles: por servicio, por empleado, por rango de fechas

### Para Docker:
- Siempre usar `docker-compose exec app php artisan ...` en lugar de `php artisan ...` directo
- El host de MySQL en `.env` es `db`, no `localhost`

### Para CI/CD:
- Tests antes de deploy: `php artisan test`
- Solo hacer deploy si todos los tests pasan
- Deploy a Render mediante webhook secreto en GitHub Actions

---

## ⚠️ Reglas de Negocio Críticas

1. **No se permiten turnos traslapados** → validar en backend antes de guardar
2. **Solo el Administrador puede crear/editar usuarios**
3. **El Jefe de Servicio solo ve el personal de los servicios que administra**
4. **El Personal de Salud solo ve SUS propios turnos**
5. **Nunca borrar registros físicamente** → usar `softDeletes()` siempre
6. **Todo cambio en asignaciones debe quedar en `audit_logs`** con usuario, fecha y IP

### Turnos nocturnos

Un turno nocturno puede iniciar en una fecha y terminar al día siguiente.

Ejemplo:
`21:00` a `07:00` se almacena en la asignación con `start_at` en la fecha asignada
y `end_at` en la fecha siguiente.

---

## 🔒 Seguridad

### Lo que Laravel maneja automáticamente
- **CSRF** → `@csrf` en cada formulario
- **SQL Injection** → Eloquent ORM con queries parametrizadas
- **XSS** → Blade escapa con `{{ }}` automáticamente
- **Hash de contraseñas** → `bcrypt()` nativo

### Lo que hay que implementar en MediTurno
- **Throttle de login** → bloquear después de 5 intentos fallidos:
  ```php
  // En routes/web.php
  Route::middleware('throttle:5,1')->group(function () {
      Route::post('/login', [LoginController::class, 'store']);
  });
  ```
- **HTTPS forzado en producción** → en `AppServiceProvider`:
  ```php
  if (config('app.env') === 'production') {
      URL::forceScheme('https');
  }
  ```
- **Audit logs** → registrar quién asignó, modificó o eliminó un turno
- **Variables sensibles solo en `.env`** → nunca hardcodear credenciales en el código
- **`.env` en `.gitignore`** → solo subir `.env.example` a GitHub
- **`APP_DEBUG=false`** en producción → nunca mostrar errores al usuario final

---

## 📝 Notas Adicionales

- Este es un **Proyecto de Grado** → código limpio, comentado y organizado
- Comentarios en **español** para lógica de negocio, **inglés** para código técnico
- Diseño **responsive** con Bootstrap 5 obligatorio
- Priorizar **funcionalidad sobre estética** en esta versión
- La **validación de conflictos de turno** es la funcionalidad más crítica del sistema
- Mantener el **CLAUDE.md actualizado** si cambia alguna decisión técnica del proyecto
