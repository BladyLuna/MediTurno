@extends('layouts.app')

@section('title', 'Revisión de solicitudes | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Revisión de solicitudes</h1>
        <p class="text-muted mb-0">Aprobación o rechazo administrativo de solicitudes de cambio de turno.</p>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Solicitante</th>
                        <th>Personal</th>
                        <th>Servicio</th>
                        <th>Inicio</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shiftChangeRequests as $requestItem)
                        <tr>
                            <td>{{ $requestItem->requestedBy?->name }}</td>
                            <td>{{ $requestItem->shiftAssignment?->staff?->full_name }}</td>
                            <td>{{ $requestItem->shiftAssignment?->hospitalService?->name }}</td>
                            <td>{{ $requestItem->shiftAssignment?->start_at?->format('Y-m-d H:i') }}</td>
                            <td><span class="badge text-bg-secondary">{{ $requestItem->status }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.shift-change-requests.show', $requestItem) }}" class="btn btn-outline-primary btn-sm">Revisar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No hay solicitudes para revisar.</td>
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
