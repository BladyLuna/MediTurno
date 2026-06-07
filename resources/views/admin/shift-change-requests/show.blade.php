@extends('layouts.app')

@section('title', 'Revisar solicitud | MediTurno')

@section('content')
    @php
        $assignment = $shiftChangeRequest->shiftAssignment;
        $template = $assignment?->serviceShiftTemplate;
        $base = $template?->shiftTemplate;
    @endphp

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Revisar solicitud</h1>
            <p class="text-muted mb-0">Estado actual: <span class="badge text-bg-secondary">{{ $shiftChangeRequest->status }}</span></p>
        </div>

        <a href="{{ route('admin.shift-change-requests.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5">Detalle</h2>
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Solicitante</dt>
                        <dd class="col-sm-8">{{ $shiftChangeRequest->requestedBy?->name }}</dd>
                        <dt class="col-sm-4">Personal</dt>
                        <dd class="col-sm-8">{{ $assignment?->staff?->full_name }}</dd>
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
                        <dt class="col-sm-4">Notas de revisión</dt>
                        <dd class="col-sm-8">{{ $shiftChangeRequest->review_notes ?: 'Sin notas' }}</dd>
                    </dl>
                </div>
            </div>

            @can('review', $shiftChangeRequest)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5">Resolución</h2>
                        <form method="POST" action="{{ route('admin.shift-change-requests.approve', $shiftChangeRequest) }}" class="mb-3">
                            @csrf
                            @method('PATCH')
                            <label for="approve_review_notes" class="form-label">Notas</label>
                            <textarea name="review_notes" id="approve_review_notes" rows="3" class="form-control mb-2"></textarea>
                            <button type="submit" class="btn btn-success">Aprobar</button>
                        </form>

                        <form method="POST" action="{{ route('admin.shift-change-requests.reject', $shiftChangeRequest) }}">
                            @csrf
                            @method('PATCH')
                            <label for="reject_review_notes" class="form-label">Notas</label>
                            <textarea name="review_notes" id="reject_review_notes" rows="3" class="form-control mb-2"></textarea>
                            <button type="submit" class="btn btn-outline-danger">Rechazar</button>
                        </form>
                    </div>
                </div>
            @endcan
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
