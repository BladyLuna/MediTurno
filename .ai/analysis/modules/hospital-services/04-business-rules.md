# Business Rules
- Official foreign key name is `hospital_service_id` (DEC-005).
- Service names are unique among non-deleted records.
- Administrable records use SoftDeletes.
- Critical writes are transactional and audited.

