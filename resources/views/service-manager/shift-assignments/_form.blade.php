<div class="row g-3">
    <div class="col-12 col-md-6">
        <label for="staff_id" class="form-label">Personal</label>
        <select name="staff_id" id="staff_id" class="form-select @error('staff_id') is-invalid @enderror" required>
            <option value="">Seleccionar personal</option>
            @foreach ($staffOptions as $staffMember)
                <option value="{{ $staffMember->id }}" @selected(old('staff_id', $shiftAssignment?->staff_id) == $staffMember->id)>
                    {{ $staffMember->full_name }} - {{ $staffMember->ci }} ({{ $staffMember->hospitalService?->name }})
                </option>
            @endforeach
        </select>
        @error('staff_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="hospital_service_id" class="form-label">Servicio hospitalario</label>
        <select name="hospital_service_id" id="hospital_service_id" class="form-select @error('hospital_service_id') is-invalid @enderror" required>
            <option value="">Seleccionar servicio</option>
            @foreach ($hospitalServices as $hospitalService)
                <option value="{{ $hospitalService->id }}" @selected(old('hospital_service_id', $shiftAssignment?->hospital_service_id) == $hospitalService->id)>
                    {{ $hospitalService->name }}
                </option>
            @endforeach
        </select>
        @error('hospital_service_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="service_shift_template_id" class="form-label">Turno por servicio</label>
        <select name="service_shift_template_id" id="service_shift_template_id" class="form-select @error('service_shift_template_id') is-invalid @enderror" required>
            <option value="">Seleccionar turno</option>
            @foreach ($serviceShiftTemplates as $serviceShiftTemplate)
                @php
                    $base = $serviceShiftTemplate->shiftTemplate;
                @endphp
                <option value="{{ $serviceShiftTemplate->id }}" @selected(old('service_shift_template_id', $shiftAssignment?->service_shift_template_id) == $serviceShiftTemplate->id)>
                    {{ $serviceShiftTemplate->hospitalService?->name }} - {{ $serviceShiftTemplate->custom_code ?: $base?->code }} {{ $serviceShiftTemplate->custom_name ?: $base?->name }}
                </option>
            @endforeach
        </select>
        @error('service_shift_template_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-3">
        <label for="assignment_date" class="form-label">Fecha</label>
        <input type="date" name="assignment_date" id="assignment_date" value="{{ old('assignment_date', $shiftAssignment?->assignment_date?->format('Y-m-d')) }}" class="form-control @error('assignment_date') is-invalid @enderror" required>
        @error('assignment_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="notes" class="form-label">Observación operativa</label>
        <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $shiftAssignment?->notes) }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('service-assignments.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <a href="{{ route('service-availability.index') }}" class="btn btn-outline-primary">Ver disponibilidad</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>
