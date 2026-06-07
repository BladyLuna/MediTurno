@php
    $editing = $hospitalService !== null;
@endphp

<div class="row g-3">
    <div class="col-12 col-md-6">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" value="{{ old('name', $hospitalService?->name) }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Descripción</label>
        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $hospitalService?->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if (! $editing)
        <div class="col-12">
            <div class="form-check">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" id="active" value="1" class="form-check-input" @checked(old('active', true))>
                <label for="active" class="form-check-label">Servicio activo</label>
            </div>
        </div>
    @endif
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.hospital-services.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>
