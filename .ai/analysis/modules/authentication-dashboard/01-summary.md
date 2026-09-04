# Authentication and Dashboard

## Objective
Provide session login/logout and the authenticated entry view for `admin`, `jefe_servicio`, and `personal`.

## Evidence
`CONFIRMED`: KB FEAT-001; `routes/web.php`; `LoginController`; `DashboardController`.

## Dependencies
Laravel web session, `User`, `LoginRequest`, `LoginService`, `auth`, `guest`, `active`, and `role` middleware.

