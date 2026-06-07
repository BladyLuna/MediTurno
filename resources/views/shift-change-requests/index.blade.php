@extends('layouts.app')

@section('title', 'Mis solicitudes de cambio | MediTurno')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Mis solicitudes de cambio</h1>
            <p class="text-muted mb-0">Seguimiento de solicitudes administrativas de cambio de turno.</p>
        </div>

        <a href="{{ route('shift-change-requests.create') }}" class="btn btn-primary">Nueva solicitud</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Turno</th>
                        <th>Servicio</th>
                        <th>Inicio</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shiftChangeRequests as $requestItem)
                        @php
                            $assignment = $requestItem->shiftAssignment;
                            $template = $assignment?->serviceShiftTemplate;
                            $base = $template?->shiftTemplate;
                        @endphp
                        <tr>
                            <td>{{ $template?->custom_name ?: $base?->name }}</td>
                            <td>{{ $assignment?->hospitalService?->name }}</td>
                            <td>{{ $assignment?->start_at?->format('Y-m-d H:i') }}</td>
                            <td><span class="badge text-bg-secondary">{{ $requestItem->status }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('shift-change-requests.show', $requestItem) }}" class="btn btn-outline-primary btn-sm">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No hay solicitudes registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $shiftChangeRequests->links() }}
    </div>
@endsection
