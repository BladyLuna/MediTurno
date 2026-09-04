# Flow
Admin opens the list, selects create/edit/status/delete, submits validated data,
the controller executes a transaction, persists `User`, records audit and returns
a controlled message. DEC-009 blocks unsafe admin operations.

