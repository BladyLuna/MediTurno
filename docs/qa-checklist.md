# QA Checklist - MediTurno MVP

## Objetivo

Verificar que el MVP esté listo para defensa académica, sin agregar módulos nuevos.

## Preparación

```bash
docker compose up -d
docker compose exec app php artisan migrate:fresh --seed
npm run build
docker compose exec app php artisan test
```

## Credenciales

| Rol | Correo | Contraseña |
| --- | --- | --- |
| Administrador | `admin@mediturno.test` | `12345678` |
| Jefe de servicio | `jefe@mediturno.test` | `12345678` |
| Personal | `personal@mediturno.test` | `12345678` |

## QA Administrador

- [ ] Inicia sesión correctamente.
- [ ] Cierra sesión correctamente.
- [ ] Ve navbar agrupado y responsive.
- [ ] Puede gestionar usuarios.
- [ ] No puede desactivar su propia cuenta.
- [ ] No puede eliminar el último admin activo.
- [ ] Puede gestionar servicios hospitalarios.
- [ ] Puede gestionar personal de salud.
- [ ] Solo puede asociar staff a usuarios con rol `personal`.
- [ ] Puede asociar jefes de servicio.
- [ ] Puede gestionar plantillas de turno.
- [ ] Puede gestionar turnos por servicio.
- [ ] Puede crear asignaciones.
- [ ] El sistema rechaza turnos traslapados.
- [ ] El sistema permite turnos consecutivos.
- [ ] El sistema soporta turnos nocturnos.
- [ ] Puede cancelar asignaciones con SoftDelete.
- [ ] Ve calendario mensual.
- [ ] Filtra calendario por servicio.
- [ ] Filtra calendario por personal.
- [ ] Ve colores heredados o personalizados.
- [ ] Ve reportes por servicio.
- [ ] Ve reportes por empleado.
- [ ] Exporta CSV.
- [ ] Exporta PDF.
- [ ] Ve auditoría.
- [ ] Revisa solicitudes de cambio.
- [ ] Ve notificaciones internas.

## QA Jefe de Servicio

- [ ] Inicia sesión correctamente.
- [ ] Ve solo opciones permitidas.
- [ ] Puede acceder a revisión de solicitudes.
- [ ] Ve solicitudes del servicio asignado.
- [ ] No ve solicitudes de servicios no asignados.
- [ ] Puede aprobar solicitud pendiente.
- [ ] Puede rechazar solicitud pendiente.
- [ ] La aprobación/rechazo no modifica automáticamente la asignación.
- [ ] Se registra auditoría de la revisión.
- [ ] Se genera notificación para el personal.

## QA Personal

- [ ] Inicia sesión correctamente.
- [ ] Ve solo opciones permitidas.
- [ ] Puede ver sus solicitudes.
- [ ] Puede crear solicitud sobre asignación propia.
- [ ] No puede crear solicitud sobre asignación ajena.
- [ ] No puede solicitar cambio sobre asignación cancelada.
- [ ] Puede cancelar solicitud pendiente propia.
- [ ] No puede cancelar solicitud aprobada/rechazada.
- [ ] Ve notificaciones propias.
- [ ] No ve notificaciones ajenas.
- [ ] Puede marcar notificaciones como leídas.

## QA Seguridad

- [ ] Rutas admin bloquean usuarios no admin.
- [ ] Rutas de jefe validan servicios administrados.
- [ ] Rutas de personal validan propiedad de datos.
- [ ] Formularios usan CSRF.
- [ ] Validaciones backend impiden estados libres.
- [ ] Operaciones críticas registran auditoría.
- [ ] SoftDeletes activo en entidades administrables.

## QA Dependencias

- [ ] Ejecutar `docker compose exec app composer audit`.
- [ ] Ejecutar `npm audit`.
- [ ] No ejecutar `composer update` masivo sin revisión.
- [ ] No ejecutar `npm audit fix --force` sin revisar impacto.
- [ ] Si se actualizan dependencias, ejecutar `npm run build`.
- [ ] Si se actualizan dependencias, ejecutar `docker compose exec app php artisan test`.

## Resultado Esperado

El sistema debe quedar demostrable con datos demo, roles funcionando, pruebas
automatizadas pasando y riesgos de dependencias documentados.
