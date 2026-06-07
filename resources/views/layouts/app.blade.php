<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'MediTurno'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">MediTurno</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                @auth
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @if (auth()->user()->isAdmin())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="managementDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Gestión
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="managementDropdown">
                                    <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Usuarios</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.hospital-services.index') }}">Servicios</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.staff.index') }}">Personal</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.service-managers.index') }}">Jefes</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="shiftsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Turnos
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="shiftsDropdown">
                                    <li><a class="dropdown-item" href="{{ route('admin.shift-templates.index') }}">Plantillas de turno</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.service-shift-templates.index') }}">Turnos por servicio</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.shift-assignments.index') }}">Asignaciones</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.calendar.index') }}">Calendario</a></li>
                                </ul>
                            </li>
                        @endif

                        @if (auth()->user()->role === 'jefe_servicio')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="serviceManagerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Servicios
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="serviceManagerDropdown">
                                    <li><a class="dropdown-item" href="{{ route('service-calendar.index') }}">Calendario</a></li>
                                    <li><a class="dropdown-item" href="{{ route('service-staff.index') }}">Personal</a></li>
                                    <li><a class="dropdown-item" href="{{ route('service-reports.index') }}">Reportes</a></li>
                                </ul>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="operationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Operación
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="operationsDropdown">
                                @if (auth()->user()->role === 'personal')
                                    <li><a class="dropdown-item" href="{{ route('my-schedule.index') }}">Mis turnos</a></li>
                                    <li><a class="dropdown-item" href="{{ route('shift-change-requests.index') }}">Solicitudes</a></li>
                                @endif

                                @if (in_array(auth()->user()->role, ['admin', 'jefe_servicio'], true))
                                    <li><a class="dropdown-item" href="{{ route('admin.shift-change-requests.index') }}">Revisión solicitudes</a></li>
                                @endif

                                <li><a class="dropdown-item" href="{{ route('notifications.index') }}">Notificaciones</a></li>
                            </ul>
                        </li>

                        @if (auth()->user()->isAdmin())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="administrationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Administración
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="administrationDropdown">
                                    <li><a class="dropdown-item" href="{{ route('admin.reports.index') }}">Reportes</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.audit-logs.index') }}">Auditoría</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                @endauth

                <div class="ms-lg-auto d-flex flex-column flex-lg-row align-items-lg-center gap-2 gap-lg-3 pb-2 pb-lg-0">
                    @auth
                        <span class="badge text-bg-primary text-uppercase">{{ auth()->user()->role }}</span>
                        <span class="text-white-50 small">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
