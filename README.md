# 🏥 MediTurno — Sistema Web de Gestión de Turnos Hospitalarios

> Sistema web integral para la gestión y asignación de turnos del personal de salud.  
> Desarrollado por **Bladimir Luna Corrales** | Tutor: **Ing. Edson Flores Condori**  
> Instituto Técnico Nacional de Comercio "Federico Álvarez Plata" Nocturno — 2025

---

## 📋 Descripción

**MediTurno** reemplaza el uso de hojas de cálculo (Excel) para gestionar los turnos hospitalarios. Centraliza toda la información del personal, servicios y turnos en una sola plataforma web con roles diferenciados, calendario visual y reportes administrativos.

---

## 🛠️ Stack Tecnológico

| Capa | Tecnología |
|------|-----------|
| Backend | PHP 8.2 + Laravel 10 (MVC) |
| Frontend | Blade Templates + Bootstrap 5 + JavaScript |
| Base de datos | MySQL 8 + Eloquent ORM |
| Entorno local | Docker + Docker Compose |
| Control de versiones | Git + GitHub |
| Editor recomendado | VS Code + Claude Code |

---

## 👥 Roles del Sistema

| Rol | Permisos |
|-----|---------|
| **Administrador** | Acceso total: usuarios, personal, servicios, turnos, asignaciones, reportes, configuración |
| **Jefe de Servicio** | Gestión de turnos y personal de los servicios que administra, ver calendario |
| **Personal de Salud** | Ver sus propios turnos, consultar calendario mensual |

---

## 📦 Módulos del Sistema

### 🔐 Módulo 1 — Autenticación
Controla el acceso seguro al sistema.
- Iniciar sesión (correo + contraseña)
- Cerrar sesión
- Recuperar contraseña *(opcional)*
- Redirección automática según rol

---

### 👥 Módulo 2 — Usuarios
Administra los usuarios del sistema y sus permisos.
- Registrar usuario con rol asignado
- Editar datos del usuario
- Eliminar / desactivar usuario
- Asignar roles: Administrador / Jefe de Servicio / Personal de Salud

---

### 🏥 Módulo 3 — Servicios Hospitalarios
Gestiona las áreas del hospital.
- Registrar servicio (ej: Emergencia, Laboratorio, Neonatología)
- Editar y eliminar servicio
- Listar todos los servicios

---

### 👨‍⚕️ Módulo 4 — Personal de Salud
Gestiona los empleados del hospital.
- Registrar personal (nombre, cargo, CI, contacto)
- Editar datos del empleado
- Asignar servicio hospitalario
- Buscar por nombre o servicio

---

### ⏰ Módulo 5 — Tipos de Turno
Configura los tipos de turno disponibles.
- Crear turno con nombre y horario
  - Mañana: 07:00 – 14:00
  - Tarde: 14:00 – 21:00
  - Noche: 21:00 – 07:00
- Editar nombre y horario
- Definir color identificativo por turno
- Configurar plantillas de turno por servicio

---

### 📅 Módulo 6 — Asignación de Turnos
Asigna turnos al personal por fecha y servicio.
- Asignar turno por empleado y fecha
- Editar asignación existente
- Eliminar asignación
- ⚠️ Validación automática de turnos traslapados

---

### 📆 Módulo 7 — Calendario Mensual
Visualiza los turnos del mes de forma gráfica.
- Vista mensual de todos los turnos
- Filtrar por servicio hospitalario
- Filtrar por empleado
- Colores diferenciados por tipo de turno (M/T/N)
- Actualización mediante recarga de la vista o consulta de eventos

---

### 📊 Módulo 8 — Reportes Administrativos
Genera reportes para la toma de decisiones.
- Reporte mensual por servicio
- Reporte por empleado y periodo
- Exportar en PDF *(opcional)*
- Exportar en Excel *(opcional)*

---

### ⚙️ Módulo 9 — Configuración
Configura los parámetros generales del sistema.
- Configurar tipos y nombres de turnos
- Configurar horarios de inicio y fin
- Configurar colores del calendario

---

## 🗂️ Estructura del Proyecto

```
mediturno/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── UserController.php
│   │   │   ├── ServiceController.php
│   │   │   ├── StaffController.php
│   │   │   ├── ShiftController.php
│   │   │   ├── AssignmentController.php
│   │   │   ├── CalendarController.php
│   │   │   ├── ReportController.php
│   │   │   └── ConfigController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── HospitalService.php
│       ├── Staff.php
│       ├── ShiftTemplate.php
│       ├── ServiceShiftTemplate.php
│       ├── ShiftAssignment.php
│       └── Report.php
├── database/
│   └── migrations/
│       ├── create_users_table.php
│       ├── create_hospital_services_table.php
│       ├── create_staff_table.php
│       ├── create_shift_templates_table.php
│       ├── create_service_shift_templates_table.php
│       └── create_shift_assignments_table.php
├── resources/
│   └── views/
│       ├── auth/
│       ├── dashboard/
│       ├── users/
│       ├── services/
│       ├── staff/
│       ├── shifts/
│       ├── assignments/
│       ├── calendar/
│       └── reports/
├── routes/
│   └── web.php
├── public/
├── CLAUDE.md          ← Contexto para Claude Code
├── .claudeignore      ← Archivos ignorados por Claude Code
├── .env.example
└── README.md
```

---

## 🗄️ Base de Datos — Tablas Principales

| Tabla | Descripción |
|-------|------------|
| `users` | Usuarios del sistema con roles |
| `hospital_services` | Áreas/servicios del hospital |
| `staff` | Personal de salud |
| `shift_templates` | Tipos base de turno (M/T/N/Libre) |
| `service_shift_templates` | Plantillas de turno configuradas por servicio |
| `shift_assignments` | Asignaciones de turno por empleado y fecha |
| `audit_logs` | Bitácora de cambios |

---

## 🚀 Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/bladimir-luna/mediturno.git
cd mediturno

# 2. Levantar Docker
docker compose up -d

# 3. Configurar entorno
cp .env.example .env
docker compose exec app php artisan key:generate

# 4. Ejecutar migraciones y seeders
docker compose exec app php artisan migrate --seed

# 5. Ejecutar pruebas
docker compose exec app php artisan test

# 6. Acceder al sistema
# http://localhost:8080
```

## 🐳 Docker

El proyecto incluye un entorno local con:

- `app`: PHP 8.2 FPM con extensiones para Laravel y MySQL
- `webserver`: Nginx
- `db`: MySQL 8

Comandos principales:

```bash
docker compose up -d
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan test
```

---

## 🔄 Flujo del Sistema

```
Administrador inicia sesión
        ↓
Registra personal → Asigna servicio
        ↓
Crea tipos y plantillas de turno por servicio
        ↓
Asigna turno por empleado + fecha
        ↓
Sistema valida turnos traslapados ✅ / ❌
        ↓
Calendario actualizado mediante recarga
        ↓
Genera reporte mensual
```

---

## 📌 Estado del Proyecto

| Módulo | Estado |
|--------|--------|
| Autenticación | 🔲 Pendiente |
| Usuarios | 🔲 Pendiente |
| Servicios | 🔲 Pendiente |
| Personal | 🔲 Pendiente |
| Turnos | 🔲 Pendiente |
| Asignación | 🔲 Pendiente |
| Calendario | 🔲 Pendiente |
| Reportes | 🔲 Pendiente |
| Configuración | 🔲 Pendiente |

---

## 👤 Autor

**Bladimir Luna Corrales**  
Instituto Técnico Nacional de Comercio "Federico Álvarez Plata" Nocturno  
Carrera: Sistemas Informáticos  
Tutor: Ing. Edson Flores Condori  
Cochabamba – Bolivia, 2025
