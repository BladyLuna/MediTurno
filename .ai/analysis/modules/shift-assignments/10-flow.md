# Flow
Actor selects service, staff, template and date; backend validates scope and active relationships; `ShiftTimeService` calculates interval; `ShiftConflictService` rejects overlap; transaction saves and audits. Cancel sets status, soft-deletes and audits.
