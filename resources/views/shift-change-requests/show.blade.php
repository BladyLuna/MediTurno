@extends('layouts.app')

@section('title', 'Solicitud de cambio | MediTurno')

@section('content')
    @php
        $assignment = $shiftChangeRequest->shiftAssignment;
        $template = $assignment?->serviceShiftTemplate;
        $base = $template?->shiftTemplate;
    @endphp

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Solicitud de cambio</h1>
            <p class="text-muted mb-0">Estado actual: <span class="badge text-bg-secondary">{{ $shiftChangeRequest->status }}</span></p>
        </div>

        <a href="{{ route('shift-change-requests.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h5">Detalle</h2>
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Turno</dt>
                        <dd class="col-sm-8">{{ $template?->custom_name ?: $base?->name }}</dd>
                        <dt class="col-sm-4">Servicio</dt>
                        <dd class="col-sm-8">{{ $assignment?->hospitalService?->name }}</dd>
                        <dt class="col-sm-4">Inicio</dt>
                        <dd class="col-sm-8">{{ $assignment?->start_at?->format('Y-m-d H:i') }}</dd>
                        <dt class="col-sm-4">Fin</dt>
                        <dd class="col-sm-8">{{ $assignment?->end_at?->format('Y-m-d H:i') }}</dd>
                        <dt class="col-sm-4">Motivo</dt>
                        <dd class="col-sm-8">{{ $shiftChangeRequest->reason }}</dd>
                        <dt class="col-sm-4">Revisado por</dt>
                        <dd class="col-sm-8">{{ $shiftChangeRequest->reviewedBy?->name ?: 'Pendiente' }}</dd>
                        <dt class="col-sm-4">Notas de revisión</dt>
                        <dd class="col-sm-8">{{ $shiftChangeRequest->review_notes ?: 'Sin notas' }}</dd>
                    </dl>

                    @can('cancel', $shiftChangeRequest)
                        <form method="POST" action="{{ route('shift-change-requests.cancel', $shiftChangeRequest) }}" class="mt-3">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger">Cancelar solicitud</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h5">Historial</h2>
                    <div class="list-group list-group-flush">
                        @forelse ($auditLogs as $auditLog)
                            <div class="list-group-item px-0">
                                <div class="fw-semibold">{{ $auditLog->action }}</div>
                                <div class="text-muted small">{{ $auditLog->created_at?->format('Y-m-d H:i') }}</div>
                            </div>
                        @empty
                            <div class="text-muted">No hay auditoría registrada.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
