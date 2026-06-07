@php
    $editing = $shiftTemplate !== null;
@endphp

<div class="row g-3">
    <div class="col-12 col-md-3">
        <label for="code" class="form-label">Código</label>
        <input type="text" name="code" id="code" value="{{ old('code', $shiftTemplate?->code) }}" class="form-control @error('code') is-invalid @enderror" required>
        @error('code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-5">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" value="{{ old('name', $shiftTemplate?->name) }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-2">
        <label for="start_time" class="form-label">Inicio</label>
        <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $shiftTemplate ? substr($shiftTemplate->start_time, 0, 5) : '') }}" class="form-control @error('start_time') is-invalid @enderror" required>
        @error('start_time')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-2">
        <label for="end_time" class="form-label">Fin</label>
        <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $shiftTemplate ? substr($shiftTemplate->end_time, 0, 5) : '') }}" class="form-control @error('end_time') is-invalid @enderror" required>
        @error('end_time')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-3">
        <label for="color" class="form-label">Color</label>
        <input type="color" name="color" id="color" value="{{ old('color', $shiftTemplate?->color ?? '#0d6efd') }}" class="form-control form-control-color @error('color') is-invalid @enderror" required>
        @error('color')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-3 d-flex align-items-end">
        <div class="form-check">
            <input type="hidden" name="is_working_shift" value="0">
            <input type="checkbox" name="is_working_shift" id="is_working_shift" value="1" class="form-check-input" @checked(old('is_working_shift', $shiftTemplate?->is_working_shift ?? true))>
            <label for="is_working_shift" class="form-check-label">Turno laboral</label>
        </div>
    </div>

    @if (! $editing)
        <div class="col-12 col-md-3 d-flex align-items-end">
            <div class="form-check">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" id="active" value="1" class="form-check-input" @checked(old('active', true))>
                <label for="active" class="form-check-label">Turno activo</label>
            </div>
        </div>
    @endif
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.shift-templates.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>
