# Business Rules
- No overlap; consecutive intervals are allowed (DEC-003).
- Night shifts end next day (DEC-004).
- Staff and service template must belong to selected active service.
- Form cannot freely set status.
- Create=`assigned`, edit=`changed`, delete=`cancelled` then SoftDelete (DEC-012).
- Jefe cannot force IDs outside `service_managers` or operate cancelled/deleted assignments (DEC-014).
- Critical actions are transactional and audited.
