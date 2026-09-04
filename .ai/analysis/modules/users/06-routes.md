# Routes
| Method | URI | Handler |
|---|---|---|
| GET/POST | `/admin/users`, `/admin/users` | `index`, `store` |
| GET | `/admin/users/create` | `create` |
| GET | `/admin/users/{user}/edit` | `edit` |
| PUT/PATCH | `/admin/users/{user}` | `update` |
| DELETE | `/admin/users/{user}` | `destroy` |
| PATCH | `/admin/users/{user}/activate` | `UserStatusController@activate` |
| PATCH | `/admin/users/{user}/deactivate` | `UserStatusController@deactivate` |

