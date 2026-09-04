# Business Rules
- `hospital_service_id` is mandatory.
- `user_id` is optional and must reference role `personal` (DEC-010).
- `ci` and active `user_id` associations are unique among non-deleted records.
- Writes are transactional, audited and use SoftDeletes.

