@php
    $editing = $serviceShiftTemplate !== null;
@endphp

<div class="row g-3">
    <div class="col-12 col-md-6">
        <label for="hospital_service_id" class="form-label">Servicio hospitalario</label>
        <select name="hospital_service_id" id="hospital_service_id" class="form-select @error('hospital_service_id') is-invalid @enderror" required>
            <option value="">Seleccionar servicio</option>
            @foreach ($hospitalServices as $hospitalService)
                <option value="{{ $hospitalService->id }}" @selected(old('hospital_service_id', $serviceShiftTemplate?->hospital_service_id) == $hospitalService->id)>
                    {{ $hospitalService->name }}
                </option>
            @endforeach
        </select>
        @error('hospital_service_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="shift_template_id" class="form-label">Plantilla base</label>
        <select name="shift_template_id" id="shift_template_id" class="form-select @error('shift_template_id') is-invalid @enderror" required>
            <option value="">Seleccionar turno</option>
            @foreach ($shiftTemplates as $shiftTemplate)
                <option value="{{ $shiftTemplate->id }}" @selected(old('shift_template_id', $serviceShiftTemplate?->shift_template_id) == $shiftTemplate->id)>
                    {{ $shiftTemplate->code }} - {{ $shiftTemplate->name }}
                </option>
            @endforeach
        </select>
        @error('shift_template_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-3">
        <label for="custom_code" class="form-label">Código personalizado</label>
        <input type="text" name="custom_code" id="custom_code" value="{{ old('custom_code', $serviceShiftTemplate?->custom_code) }}" class="form-control @error('custom_code') is-invalid @enderror">
        @error('custom_code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-5">
        <label for="custom_name" class="form-label">Nombre personalizado</label>
        <input type="text" name="custom_name" id="custom_name" value="{{ old('custom_name', $serviceShiftTemplate?->custom_name) }}" class="form-control @error('custom_name') is-invalid @enderror">
        @error('custom_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-2">
        <label for="custom_start_time" class="form-label">Inicio personalizado</label>
        <input type="time" name="custom_start_time" id="custom_start_time" value="{{ old('custom_start_time', $serviceShiftTemplate?->custom_start_time ? substr($serviceShiftTemplate->custom_start_time, 0, 5) : '') }}" class="form-control @error('custom_start_time') is-invalid @enderror">
        @error('custom_start_time')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-2">
        <label for="custom_end_time" class="form-label">Fin personalizado</label>
        <input type="time" name="custom_end_time" id="custom_end_time" value="{{ old('custom_end_time', $serviceShiftTemplate?->custom_end_time ? substr($serviceShiftTemplate->custom_end_time, 0, 5) : '') }}" class="form-control @error('custom_end_time') is-invalid @enderror">
        @error('custom_end_time')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-3">
        <label for="custom_color" class="form-label">Color personalizado</label>
        <input type="text" name="custom_color" id="custom_color" value="{{ old('custom_color', $serviceShiftTemplate?->custom_color) }}" placeholder="#0d6efd" class="form-control @error('custom_color') is-invalid @enderror">
        @error('custom_color')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if (! $editing)
        <div class="col-12 col-md-3 d-flex align-items-end">
            <div class="form-check">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" id="active" value="1" class="form-check-input" @checked(old('active', true))>
                <label for="active" class="form-check-label">Configuración activa</label>
            </div>
        </div>
    @endif
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.service-shift-templates.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>
