# Business Rules
- `shift_templates` and `service_shift_templates` are official names.
- Code/name uniqueness applies among non-deleted records.
- Custom start/end must be provided together (DEC-011).
- Start later than end represents a night shift.
- Empty custom color/name/code inherits global values.
- Records use SoftDeletes, transactions and audit.

