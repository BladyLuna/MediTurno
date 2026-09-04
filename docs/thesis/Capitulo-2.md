# CAPÍTULO II

# 2. OBJETIVOS

## 2.1 General

Desarrollar un sistema web para la gestión de turnos del personal hospitalario
que permita administrar servicios, personal, configuraciones de turno,
asignaciones, calendarios y reportes con control de acceso y trazabilidad.

Este objetivo conserva el sentido del objetivo general incluido en el perfil y
lo alinea con las funcionalidades validadas del proyecto.

## 2.2 Específicos

1. Estructurar la información de usuarios, servicios hospitalarios, personal,
   plantillas de turno y asignaciones mediante un modelo de datos relacional.
2. Implementar autenticación y separación de permisos para Administrador, Jefe
   de Servicio y Personal de Salud.
3. Implementar la gestión de usuarios, servicios, personal y jefaturas por
   servicio.
4. Permitir la configuración de plantillas globales y turnos específicos por
   servicio.
5. Implementar asignaciones con cálculo de intervalos, soporte de turnos
   nocturnos y validación de traslapes.
6. Proporcionar calendarios de solo lectura con alcance global, por servicio y
   personal.
7. Generar reportes por servicio y empleado con filtros, resumen de turnos,
   horas y exportaciones CSV y PDF.
8. Registrar operaciones críticas mediante auditoría y eliminación lógica.
9. Permitir solicitudes de cambio con aprobación o rechazo administrativo y
   notificaciones internas.
10. Preparar datos demo, pruebas y documentación para la presentación académica.

Fuentes: `.ai/knowledge-base/features.md`, `README.md`,
`docs/decisions.md`.

## 2.3 Alcances

El alcance funcional documentado incluye:

| Área | Alcance implementado |
|---|---|
| Acceso | Login, logout, cuentas activas y dashboard por rol |
| Usuarios | CRUD, roles, activación, desactivación y SoftDeletes |
| Servicios | CRUD y control de estado |
| Personal | CRUD, filtros, servicio obligatorio y usuario opcional |
| Jefaturas | Asociación de uno o varios servicios a un usuario |
| Turnos | Plantillas globales y configuraciones por servicio |
| Asignaciones | Crear, editar, cancelar, calcular intervalos y validar conflictos |
| Calendario | Vista mensual global, por servicio y personal |
| Reportes | HTML, CSV y PDF por servicio o empleado |
| Solicitudes | Creación, cancelación, aprobación y rechazo administrativo |
| Notificaciones | Avisos internos y estado de lectura |
| Auditoría | Registro y consulta de operaciones críticas |

El Administrador conserva la gestión global. El Jefe de Servicio consulta y
opera únicamente servicios asociados. El Personal de Salud consulta sus turnos,
solicitudes y notificaciones propias.

La solución es una aplicación web y está preparada para una demostración con
datos demo. El estado funcional actual requiere confirmación mediante QA
fechado.

## 2.4 Límites

Quedan fuera del alcance implementado:

- aplicación móvil nativa;
- integración confirmada con otros sistemas hospitalarios;
- inteligencia artificial;
- WebSockets y actualización en tiempo real;
- drag and drop o edición rápida desde calendario;
- ausencias, permisos o bajas;
- vacaciones;
- notificaciones externas;
- estadísticas avanzadas de equidad, carga y cobertura;
- exportación Excel real;
- despliegue productivo certificado.

También permanecen pendientes:

- confirmación actual de QA;
- ERD oficial obtenido desde MySQL Workbench;
- resolución documental del alcance completo de jefatura;
- resolución formal de la contradicción sobre el efecto de aprobar solicitudes;
- controles operativos de producción como backup, restauración, monitoreo, MFA
  y retención de auditoría.

Fuentes: `README.md`, `.ai/knowledge-base/features.md`,
`.ai/knowledge-base/problems.md`, `.ai/reports/08-information-security-review.md`
y `.ai/reports/09-database-diagram-verification.md`.

