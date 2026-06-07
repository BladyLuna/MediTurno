@extends('layouts.app')

@section('title', 'Detalle de auditoría | MediTurno')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Detalle de auditoría</h1>
            <p class="text-muted mb-0">{{ $auditLog->action }} sobre {{ class_basename($auditLog->model_type) }} #{{ $auditLog->model_id }}</p>
        </div>

        <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Evento</h2>
                    <dl class="mb-0">
                        <dt class="text-muted fw-normal">Fecha</dt>
                        <dd>{{ $auditLog->created_at?->format('Y-m-d H:i:s') }}</dd>

                        <dt class="text-muted fw-normal">Responsable</dt>
                        <dd>{{ $auditLog->user?->email ?? 'Sistema' }}</dd>

                        <dt class="text-muted fw-normal">IP</dt>
                        <dd>{{ $auditLog->ip_address ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Valores anteriores</h2>
                    <pre class="bg-light border rounded p-3 mb-0 small">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Valores nuevos</h2>
                    <pre class="bg-light border rounded p-3 mb-0 small">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            </div>
        </div>
    </div>
@endsection
