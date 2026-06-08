@extends('layouts.app')

@section('title', 'Disponibilidad del personal | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Disponibilidad del personal</h1>
        <p class="text-muted mb-0">Consulta si un turno se traslapa antes de crear una asignación.</p>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('service-availability.index') }}" class="row g-3 align-items-end">
                <div class="col-12 col-md-3">
                    <label for="staff_id" class="form-label">Personal</label>
                    <select name="staff_id" id="staff_id" class="form-select @error('staff_id') is-invalid @enderror">
                        <option value="">Seleccionar personal</option>
                        @foreach ($staffOptions as $staffMember)
                            <option value="{{ $staffMember->id }}" @selected(($filters['staff_id'] ?? '') == $staffMember->id)>
                                {{ $staffMember->full_name }} - {{ $staffMember->ci }}
                            </option>
                        @endforeach
                    </select>
                    @error('staff_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-3">
                    <label for="hospital_service_id" class="form-label">Servicio</label>
                    <select name="hospital_service_id" id="hospital_service_id" class="form-select @error('hospital_service_id') is-invalid @enderror">
                        <option value="">Seleccionar servicio</option>
                        @foreach ($hospitalServices as $hospitalService)
                            <option value="{{ $hospitalService->id }}" @selected(($filters['hospital_service_id'] ?? '') == $hospitalService->id)>
                                {{ $hospitalService->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('hospital_service_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-3">
                    <label for="service_shift_template_id" class="form-label">Turno</label>
                    <select name="service_shift_template_id" id="service_shift_template_id" class="form-select @error('service_shift_template_id') is-invalid @enderror">
                        <option value="">Seleccionar turno</option>
                        @foreach ($serviceShiftTemplates as $serviceShiftTemplate)
                            @php
                                $base = $serviceShiftTemplate->shiftTemplate;
                            @endphp
                            <option value="{{ $serviceShiftTemplate->id }}" @selected(($filters['service_shift_template_id'] ?? '') == $serviceShiftTemplate->id)>
                                {{ $serviceShiftTemplate->hospitalService?->name }} - {{ $serviceShiftTemplate->custom_code ?: $base?->code }} {{ $serviceShiftTemplate->custom_name ?: $base?->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_shift_template_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-2">
                    <label for="assignment_date" class="form-label">Fecha</label>
                    <input type="date" name="assignment_date" id="assignment_date" value="{{ $filters['assignment_date'] ?? '' }}" class="form-control @error('assignment_date') is-invalid @enderror">
                    @error('assignment_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-1">
                    <button type="submit" class="btn btn-outline-primary w-100">Ver</button>
                </div>
            </form>
        </div>
    </div>

    @if ($result)
        <div class="alert {{ $result['available'] ? 'alert-success' : 'alert-warning' }}" role="alert">
            <div class="fw-semibold">
                {{ $result['available'] ? 'Personal disponible' : 'Personal no disponible' }}
            </div>
            <div>
                {{ $selectedStaff?->full_name }} -
                {{ $result['start_at']->format('Y-m-d H:i') }} a {{ $result['end_at']->format('Y-m-d H:i') }}
            </div>
            @if (! $result['available'] && $result['conflict'])
                <div class="mt-2">
                    Conflicto con asignación #{{ $result['conflict']->id }}
                    ({{ $result['conflict']->start_at?->format('Y-m-d H:i') }} a {{ $result['conflict']->end_at?->format('Y-m-d H:i') }}).
                </div>
            @endif
        </div>
    @else
        <div class="alert alert-info" role="alert">
            Selecciona personal, servicio, turno y fecha para consultar disponibilidad.
        </div>
    @endif
@endsection
