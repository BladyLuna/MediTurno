@extends('layouts.app')

@section('title', 'Nueva solicitud de cambio | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Nueva solicitud de cambio</h1>
        <p class="text-muted mb-0">Selecciona una asignación propia y registra el motivo.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('shift-change-requests.store') }}" class="row g-3">
                @csrf

                <div class="col-12">
                    <label for="shift_assignment_id" class="form-label">Asignación</label>
                    <select name="shift_assignment_id" id="shift_assignment_id" class="form-select @error('shift_assignment_id') is-invalid @enderror" required>
                        <option value="">Seleccionar asignación</option>
                        @foreach ($assignments as $assignment)
                            @php
                                $template = $assignment->serviceShiftTemplate;
                                $base = $template?->shiftTemplate;
                                $shiftName = $template?->custom_name ?: $base?->name;
                            @endphp
                            <option value="{{ $assignment->id }}" @selected(old('shift_assignment_id') == $assignment->id)>
                                {{ $assignment->start_at?->format('Y-m-d H:i') }} - {{ $shiftName }} - {{ $assignment->hospitalService?->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('shift_assignment_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="reason" class="form-label">Motivo</label>
                    <textarea name="reason" id="reason" rows="4" class="form-control @error('reason') is-invalid @enderror" required>{{ old('reason') }}</textarea>
                    @error('reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('shift-change-requests.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Enviar solicitud</button>
                </div>
            </form>
        </div>
    </div>
@endsection
