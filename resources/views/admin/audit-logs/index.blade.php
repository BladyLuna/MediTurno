@extends('layouts.app')

@section('title', 'Auditoría | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Auditoría</h1>
        <p class="text-muted mb-0">Trazabilidad mínima de operaciones críticas sobre usuarios.</p>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Acción</th>
                        <th>Entidad</th>
                        <th>Responsable</th>
                        <th class="text-end">Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($auditLogs as $auditLog)
                        <tr>
                            <td>{{ $auditLog->created_at?->format('Y-m-d H:i') }}</td>
                            <td><span class="badge text-bg-info">{{ $auditLog->action }}</span></td>
                            <td>{{ class_basename($auditLog->model_type) }} #{{ $auditLog->model_id }}</td>
                            <td>{{ $auditLog->user?->email ?? 'Sistema' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.audit-logs.show', $auditLog) }}" class="btn btn-outline-primary btn-sm">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No hay eventos de auditoría.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $auditLogs->links() }}
    </div>
@endsection
