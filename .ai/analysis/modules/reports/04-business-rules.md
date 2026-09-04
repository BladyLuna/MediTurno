# Business Rules
Include `assigned`/`changed`; exclude `cancelled`/soft-deleted; select real interval with `start_at < endDate+1day` and `end_at > startDate`; calculate hours from actual timestamps; exports reuse filters; read operations are not audited.
