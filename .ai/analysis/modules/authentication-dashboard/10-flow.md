# Flow
1. Guest opens `/login`.
2. Form submits credentials to `LoginController@store`.
3. `LoginRequest` validates input and `LoginService` attempts authentication.
4. Active authenticated user reaches `/dashboard`.
5. Logout invalidates the session and returns to login.

Exceptions: invalid credentials or inactive account produce controlled denial.

