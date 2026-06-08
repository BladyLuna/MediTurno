@extends('layouts.app')

@section('title', 'Dashboard de jefatura | MediTurno')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Dashboard operativo de jefatura</h1>
            <p class="text-muted mb-0">Resumen de servicios, personal, solicitudes y próximas asignaciones.</p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('service-assignments.create') }}" class="btn btn-primary">Crear asignación</a>
            <a href="{{ route('service-availability.index') }}" class="btn btn-outline-primary">Ver disponibilidad</a>
        </div>
    </div>

    @if (! empty($notice))
        <div class="alert alert-info" role="alert">
            {{ $notice }}
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-3">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="text-muted small">Servicios asignados</div>
                    <div class="h3 mb-0">{{ $stats['services_count'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="text-muted small">Personal activo</div>
                    <div class="h3 mb-0">{{ $stats['staff_count'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="text-muted small">Solicitudes pendientes</div>
                    <div class="h3 mb-0">{{ $stats['pending_requests_count'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="text-muted small">Próximos turnos</div>
                    <div class="h3 mb-0">{{ $stats['upcoming_assignments_count'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-5">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h2 class="h5 mb-0">Servicios administrados</h2>
                </div>
                <div class="card-body">
                    @forelse ($services as $service)
                        <span class="badge text-bg-primary me-1 mb-1">{{ $service->name }}</span>
                    @empty
                        <div class="text-muted">No hay servicios asociados.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-7">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h2 class="h5 mb-0">Próximas asignaciones</h2>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Personal</th>
                                <th>Servicio</th>
                                <th>Inicio</th>
                                <th>Turno</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($upcomingAssignments as $assignment)
                                @php
                                    $template = $assignment->serviceShiftTemplate;
                                    $base = $template?->shiftTemplate;
                                @endphp
                                <tr>
                                    <td>{{ $assignment->staff?->full_name }}</td>
                                    <td>{{ $assignment->hospitalService?->name }}</td>
                                    <td>{{ $assignment->start_at?->format('Y-m-d H:i') }}</td>
                                    <td>{{ $template?->custom_name ?: $base?->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No hay próximas asignaciones.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
