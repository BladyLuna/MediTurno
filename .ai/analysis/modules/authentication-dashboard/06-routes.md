# Routes
| Method | URI | Name | Handler |
|---|---|---|---|
| GET | `/login` | `login` | `LoginController@create` |
| POST | `/login` | `login.store` | `LoginController@store` |
| POST | `/logout` | `logout` | `LoginController@destroy` |
| GET | `/dashboard` | `dashboard` | `DashboardController@index` |

