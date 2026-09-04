# Business Rules
- Roles are `admin`, `jefe_servicio`, `personal` (DEC-001).
- Last active admin cannot be deactivated or deleted (DEC-009).
- Admin cannot deactivate or delete itself (DEC-009).
- Email is unique; records use SoftDeletes.
- Critical writes are transactional and audited.

