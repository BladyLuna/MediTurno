# Flujo de Defensa - MediTurno MVP

## Objetivo de la Demo

Mostrar que MediTurno reemplaza una hoja Excel para gestionar turnos hospitalarios
con validación de conflictos, visualización mensual, reportes, auditoría y flujo
básico de solicitudes.

## Preparación

```bash
docker compose up -d
docker compose exec app php artisan migrate:fresh --seed
npm run build
```

Abrir:

```text
http://localhost:8080
```

## Credenciales

| Rol | Correo | Contraseña |
| --- | --- | --- |
| Administrador | `admin@mediturno.test` | `12345678` |
| Jefe de servicio | `jefe@mediturno.test` | `12345678` |
| Personal | `personal@mediturno.test` | `12345678` |

## Guion Sugerido

### 1. Ingreso Administrador

1. Iniciar sesión con `admin@mediturno.test`.
2. Mostrar dashboard y navbar agrupado.
3. Explicar roles:
   - admin,
   - jefe de servicio,
   - personal.

### 2. Configuración Base

1. Abrir Gestión > Servicios.
2. Mostrar Emergencia, UCI y Laboratorio.
3. Abrir Gestión > Personal.
4. Mostrar personal demo asociado a servicios.
5. Abrir Gestión > Jefes.
6. Mostrar `jefe@mediturno.test` asociado a Emergencia.

### 3. Turnos y Asignaciones

1. Abrir Turnos > Plantillas de turno.
2. Mostrar Mañana, Tarde, Noche y Libre.
3. Abrir Turnos > Turnos por servicio.
4. Mostrar turnos habilitados por servicio.
5. Abrir Turnos > Asignaciones.
6. Mostrar asignaciones del mes actual.
7. Explicar:
   - no se permiten traslapes,
   - se permiten consecutivos,
   - turnos nocturnos cruzan al día siguiente.

### 4. Calendario

1. Abrir Turnos > Calendario.
2. Mostrar vista mensual.
3. Filtrar por Emergencia.
4. Filtrar por Personal Demo.
5. Abrir un evento.
6. Mostrar detalle de horario, servicio, turno y estado.

### 5. Reportes

1. Abrir Administración > Reportes.
2. Mostrar resumen general.
3. Cambiar agrupación por empleado.
4. Exportar CSV.
5. Exportar PDF.

### 6. Auditoría

1. Abrir Administración > Auditoría.
2. Mostrar trazabilidad demo.
3. Explicar datos auditados:
   - usuario responsable,
   - acción,
   - entidad,
   - valores anteriores/nuevos,
   - fecha.

### 7. Solicitud Personal

1. Cerrar sesión.
2. Entrar con `personal@mediturno.test`.
3. Abrir Operación > Solicitudes.
4. Mostrar solicitudes demo.
5. Crear una nueva solicitud sobre asignación propia.
6. Abrir Operación > Notificaciones.

### 8. Revisión Jefe

1. Cerrar sesión.
2. Entrar con `jefe@mediturno.test`.
3. Abrir Operación > Revisión solicitudes.
4. Mostrar solo solicitudes de Emergencia.
5. Aprobar o rechazar una solicitud pendiente.
6. Explicar que la aprobación es administrativa y no modifica automáticamente la asignación.

### 9. Notificación Final

1. Volver a `personal@mediturno.test`.
2. Abrir Operación > Notificaciones.
3. Mostrar notificación generada por aprobación/rechazo.
4. Marcarla como leída.

## Mensaje de Cierre

El MVP demuestra:

- autenticación por roles;
- gestión base de usuarios, servicios y personal;
- turnos configurables por servicio;
- validación de conflictos;
- calendario mensual;
- reportes administrativos;
- auditoría;
- solicitudes y notificaciones internas básicas.

Quedan como Post-MVP:

- ausencias;
- vacaciones;
- notificaciones externas;
- estadísticas avanzadas.
