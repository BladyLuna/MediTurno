@extends('layouts.app')

@section('title', 'Reportes | MediTurno')

@section('content')
    @php
        $filters = $report['filters'];
        $summary = $report['summary'];
        $grouped = $report['grouped'];
        $details = $report['details'];
        $exportParams = array_filter($filters, fn ($value) => $value !== null && $value !== '');
    @endphp

    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Reportes básicos</h1>
            <p class="text-muted mb-0">Resumen de turnos asignados y horas trabajadas.</p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.reports.export', $exportParams) }}" class="btn btn-outline-success">Exportar CSV</a>
            <a href="{{ route('admin.reports.pdf', $exportParams) }}" class="btn btn-outline-danger">Exportar PDF</a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3 align-items-end">
                <div class="col-12 col-md-2">
                    <label for="start_date" class="form-label">Fecha inicial</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $filters['start_date'] }}" class="form-control">
                </div>

                <div class="col-12 col-md-2">
                    <label for="end_date" class="form-label">Fecha final</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $filters['end_date'] }}" class="form-control">
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

                <div class="col-12 col-md-2">
                    <label for="group_by" class="form-label">Agrupar por</label>
                    <select name="group_by" id="group_by" class="form-select">
                        <option value="service" @selected($filters['group_by'] === 'service')>Servicio</option>
                        <option value="staff" @selected($filters['group_by'] === 'staff')>Empleado</option>
                    </select>
                </div>

                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                    <button type="submit" class="btn btn-outline-primary">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-3">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="text-muted small">Turnos asignados</div>
                    <div class="h3 mb-0">{{ $summary['assignments_count'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="text-muted small">Horas trabajadas</div>
                    <div class="h3 mb-0">{{ $summary['total_duration'] }}</div>
                    <div class="text-muted small">{{ number_format($summary['total_hours_decimal'], 2) }} h</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="text-muted small">Servicios incluidos</div>
                    <div class="h3 mb-0">{{ $summary['services_count'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="text-muted small">Personal incluido</div>
                    <div class="h3 mb-0">{{ $summary['staff_count'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h2 class="h5 mb-0">Resumen por {{ $filters['group_by'] === 'staff' ? 'empleado' : 'servicio' }}</h2>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>{{ $filters['group_by'] === 'staff' ? 'Empleado' : 'Servicio' }}</th>
                        <th>Turnos</th>
                        <th>Horas</th>
                        <th>Personal</th>
                        <th>Desglose por turno</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($grouped as $row)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $row['label'] }}</div>
                                @if ($row['secondary'])
                                    <div class="text-muted small">{{ $row['secondary'] }}</div>
                                @endif
                            </td>
                            <td>{{ $row['assignments_count'] }}</td>
                            <td>
                                <div>{{ $row['total_duration'] }}</div>
                                <div class="text-muted small">{{ number_format($row['total_hours_decimal'], 2) }} h</div>
                            </td>
                            <td>{{ $row['staff_count'] }}</td>
                            <td>
                                @foreach ($row['shift_breakdown'] as $shift)
                                    <span class="badge text-bg-secondary me-1">
                                        {{ $shift['shift_name'] }}: {{ $shift['assignments_count'] }} / {{ $shift['total_duration'] }}
                                    </span>
                                @endforeach
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No hay datos para el rango seleccionado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h2 class="h5 mb-0">Detalle de asignaciones</h2>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Personal</th>
                        <th>Servicio</th>
                        <th>Turno</th>
                        <th>Estado</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Duración</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($details as $row)
                        <tr>
                            <td>{{ $row['assignment_date'] }}</td>
                            <td>
                                <div>{{ $row['staff_name'] }}</div>
                                <div class="text-muted small">{{ $row['staff_ci'] }}</div>
                            </td>
                            <td>{{ $row['hospital_service_name'] }}</td>
                            <td>{{ trim($row['shift_code'] . ' - ' . $row['shift_name'], ' -') }}</td>
                            <td><span class="badge text-bg-secondary">{{ $row['status'] }}</span></td>
                            <td>{{ $row['start_at'] }}</td>
                            <td>{{ $row['end_at'] }}</td>
                            <td>{{ $row['duration'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No hay asignaciones para mostrar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
