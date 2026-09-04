# Business Rules
Statuses: `pending`, `approved`, `rejected`, `cancelled`. Only pending requests can be reviewed/cancelled. Creation/review/cancel are transactional, audited and notify recipients. CONFLICT-004: whether approval updates assignment is `PENDING CONFIRMATION`; current README/demo/QA say it does not.
