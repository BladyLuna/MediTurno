@extends('layouts.app')

@section('title', 'Asignaciones de turno | MediTurno')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Asignaciones de turno</h1>
            <p class="text-muted mb-0">Turnos asignados al personal con validación de conflictos.</p>
        </div>

        <a href="{{ route('admin.shift-assignments.create') }}" class="btn btn-primary">Crear asignación</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.shift-assignments.index') }}" class="row g-3 align-items-end">
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
                    <a href="{{ route('admin.shift-assignments.index') }}" class="btn btn-outline-secondary">Limpiar</a>
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
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shiftAssignments as $shiftAssignment)
                        @php
                            $template = $shiftAssignment->serviceShiftTemplate;
                            $base = $template?->shiftTemplate;
                        @endphp
                        <tr>
                            <td>{{ $shiftAssignment->staff?->full_name }}</td>
                            <td>{{ $shiftAssignment->hospitalService?->name }}</td>
                            <td>{{ $template?->custom_code ?: $base?->code }} - {{ $template?->custom_name ?: $base?->name }}</td>
                            <td>{{ $shiftAssignment->assignment_date?->format('Y-m-d') }}</td>
                            <td>{{ $shiftAssignment->start_at?->format('Y-m-d H:i') }}</td>
                            <td>{{ $shiftAssignment->end_at?->format('Y-m-d H:i') }}</td>
                            <td><span class="badge text-bg-secondary">{{ $shiftAssignment->status }}</span></td>
                            <td>
                                <div class="d-flex justify-content-end gap-2 flex-wrap">
                                    <a href="{{ route('admin.shift-assignments.edit', $shiftAssignment) }}" class="btn btn-outline-primary btn-sm">Editar</a>
                                    <form method="POST" action="{{ route('admin.shift-assignments.destroy', $shiftAssignment) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Cancelar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No hay asignaciones registradas.</td>
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
