@extends('layouts.app')

@section('title', 'Asignaciones del servicio | MediTurno')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Asignaciones del servicio</h1>
            <p class="text-muted mb-0">Gestión operativa de turnos en los servicios que administras.</p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('service-availability.index') }}" class="btn btn-outline-primary">Ver disponibilidad</a>
            <a href="{{ route('service-assignments.create') }}" class="btn btn-primary">Crear asignación</a>
        </div>
    </div>

    @if (! empty($notice))
        <div class="alert alert-info" role="alert">
            {{ $notice }}
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('service-assignments.index') }}" class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label for="staff_id" class="form-label">Personal</label>
                    <select name="staff_id" id="staff_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach ($staffOptions as $staffMember)
                            <option value="{{ $staffMember->id }}" @selected(($filters['staff_id'] ?? '') == $staffMember->id)>
                                {{ $staffMember->full_name }} - {{ $staffMember->ci }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label for="hospital_service_id" class="form-label">Servicio</label>
                    <select name="hospital_service_id" id="hospital_service_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach ($hospitalServices as $hospitalService)
                            <option value="{{ $hospitalService->id }}" @selected(($filters['hospital_service_id'] ?? '') == $hospitalService->id)>
                                {{ $hospitalService->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label for="assignment_date" class="form-label">Fecha</label>
                    <input type="date" name="assignment_date" id="assignment_date" value="{{ $filters['assignment_date'] ?? '' }}" class="form-control">
                </div>

                <div class="col-12 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filtrar</button>
                    <a href="{{ route('service-assignments.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Personal</th>
                        <th>Servicio</th>
                        <th>Turno</th>
                        <th>Fecha</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Estado</th>
                        <th>Observación</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shiftAssignments as $shiftAssignment)
                        @php
                            $template = $shiftAssignment->serviceShiftTemplate;
                            $base = $template?->shiftTemplate;
                            $canOperate = $shiftAssignment->status !== \App\Models\ShiftAssignment::STATUS_CANCELLED;
                        @endphp
                        <tr>
                            <td>{{ $shiftAssignment->staff?->full_name }}</td>
                            <td>{{ $shiftAssignment->hospitalService?->name }}</td>
                            <td>{{ $template?->custom_code ?: $base?->code }} - {{ $template?->custom_name ?: $base?->name }}</td>
                            <td>{{ $shiftAssignment->assignment_date?->format('Y-m-d') }}</td>
                            <td>{{ $shiftAssignment->start_at?->format('Y-m-d H:i') }}</td>
                            <td>{{ $shiftAssignment->end_at?->format('Y-m-d H:i') }}</td>
                            <td><span class="badge text-bg-secondary">{{ $shiftAssignment->status }}</span></td>
                            <td class="text-break">{{ $shiftAssignment->notes ?: '-' }}</td>
                            <td>
                                <div class="d-flex justify-content-end gap-2 flex-wrap">
                                    @if ($canOperate)
                                        <a href="{{ route('service-assignments.edit', $shiftAssignment) }}" class="btn btn-outline-primary btn-sm">Editar</a>
                                        <form method="POST" action="{{ route('service-assignments.destroy', $shiftAssignment) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Cancelar</button>
                                        </form>
                                    @else
                                        <span class="text-muted small">Sin acciones</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">No hay asignaciones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $shiftAssignments->links() }}
    </div>
@endsection
