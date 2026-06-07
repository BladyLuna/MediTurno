@extends('layouts.app')

@section('title', 'Calendario de turnos | MediTurno')

@section('content')
    @php
        $pageTitle = $pageTitle ?? 'Calendario mensual de turnos';
        $pageSubtitle = $pageSubtitle ?? 'Visualización de asignaciones existentes por mes.';
        $indexRoute = $indexRoute ?? 'admin.calendar.index';
        $eventsRoute = $eventsRoute ?? 'admin.calendar.events';
        $showServiceFilter = $showServiceFilter ?? true;
        $showStaffFilter = $showStaffFilter ?? true;
        $baseFilters = [];

        if ($showServiceFilter) {
            $baseFilters['hospital_service_id'] = $filters['hospital_service_id'] ?? null;
        }

        if ($showStaffFilter) {
            $baseFilters['staff_id'] = $filters['staff_id'] ?? null;
        }
    @endphp

    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $pageTitle }}</h1>
            <p class="text-muted mb-0">{{ $pageSubtitle }}</p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route($indexRoute, array_filter([...$baseFilters, 'month' => $previousMonth])) }}" class="btn btn-outline-secondary">Mes anterior</a>
            <a href="{{ route($indexRoute, $baseFilters) }}" class="btn btn-outline-primary">Mes actual</a>
            <a href="{{ route($indexRoute, array_filter([...$baseFilters, 'month' => $nextMonth])) }}" class="btn btn-outline-secondary">Mes siguiente</a>
        </div>
    </div>

    @if (! empty($notice))
        <div class="alert alert-info" role="alert">
            {{ $notice }}
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route($indexRoute) }}" class="row g-3 align-items-end" data-calendar-filter-form>
                <div class="col-12 col-md-3">
                    <label for="month" class="form-label">Mes</label>
                    <input type="month" name="month" id="month" value="{{ $currentMonth->format('Y-m') }}" class="form-control">
                </div>

                @if ($showServiceFilter)
                    <div class="col-12 col-md-4">
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
                @endif

                @if ($showStaffFilter)
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
                @endif

                <div class="col-12 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filtrar</button>
                    <a href="{{ route($indexRoute) }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div
                id="shift-calendar"
                data-events-url="{{ route($eventsRoute) }}"
                data-initial-date="{{ $currentMonth->format('Y-m-d') }}"
            ></div>
        </div>
    </div>

    <div class="modal fade" id="shiftCalendarEventModal" tabindex="-1" aria-labelledby="shiftCalendarEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="shiftCalendarEventModalLabel">Detalle de turno</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Personal</dt>
                        <dd class="col-sm-8" data-calendar-modal-field="staff_name"></dd>

                        <dt class="col-sm-4">Servicio</dt>
                        <dd class="col-sm-8" data-calendar-modal-field="hospital_service_name"></dd>

                        <dt class="col-sm-4">Turno</dt>
                        <dd class="col-sm-8" data-calendar-modal-field="shift_name"></dd>

                        <dt class="col-sm-4">Código</dt>
                        <dd class="col-sm-8" data-calendar-modal-field="shift_code"></dd>

                        <dt class="col-sm-4">Inicio</dt>
                        <dd class="col-sm-8" data-calendar-modal-field="start_time"></dd>

                        <dt class="col-sm-4">Fin</dt>
                        <dd class="col-sm-8" data-calendar-modal-field="end_time"></dd>

                        <dt class="col-sm-4">Estado</dt>
                        <dd class="col-sm-8" data-calendar-modal-field="status"></dd>

                        <dt class="col-sm-4">Notas</dt>
                        <dd class="col-sm-8" data-calendar-modal-field="notes"></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
