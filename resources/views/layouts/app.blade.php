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
                    @if (auth()->user()->isAdmin())
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users.index') }}">Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.hospital-services.index') }}">Servicios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.staff.index') }}">Personal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.shift-templates.index') }}">Turnos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.service-shift-templates.index') }}">Turnos por servicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.shift-assignments.index') }}">Asignaciones</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.calendar.index') }}">Calendario</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.reports.index') }}">Reportes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.audit-logs.index') }}">Auditoría</a>
                            </li>
                        </ul>
                    @endif
                @endauth

                <div class="ms-auto d-flex align-items-center gap-3">
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
