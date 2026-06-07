@php
    $editing = $staffMember !== null;
@endphp

<div class="row g-3">
    <div class="col-12 col-md-6">
        <label for="full_name" class="form-label">Nombre completo</label>
        <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $staffMember?->full_name) }}" class="form-control @error('full_name') is-invalid @enderror" required>
        @error('full_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-3">
        <label for="ci" class="form-label">CI</label>
        <input type="text" name="ci" id="ci" value="{{ old('ci', $staffMember?->ci) }}" class="form-control @error('ci') is-invalid @enderror" required>
        @error('ci')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-3">
        <label for="position" class="form-label">Cargo</label>
        <input type="text" name="position" id="position" value="{{ old('position', $staffMember?->position) }}" class="form-control @error('position') is-invalid @enderror" required>
        @error('position')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="hospital_service_id" class="form-label">Servicio hospitalario</label>
        <select name="hospital_service_id" id="hospital_service_id" class="form-select @error('hospital_service_id') is-invalid @enderror" required>
            <option value="">Seleccionar servicio</option>
            @foreach ($hospitalServices as $hospitalService)
                <option value="{{ $hospitalService->id }}" @selected(old('hospital_service_id', $staffMember?->hospital_service_id) == $hospitalService->id)>
                    {{ $hospitalService->name }}
                </option>
            @endforeach
        </select>
        @error('hospital_service_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="user_id" class="form-label">Usuario asociado</label>
        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror">
            <option value="">Sin usuario</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id', $staffMember?->user_id) == $user->id)>
                    {{ $user->name }} - {{ $user->email }}
                </option>
            @endforeach
        </select>
        @error('user_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="phone" class="form-label">Teléfono</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone', $staffMember?->phone) }}" class="form-control @error('phone') is-invalid @enderror">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="email" class="form-label">Correo de contacto</label>
        <input type="email" name="email" id="email" value="{{ old('email', $staffMember?->email) }}" class="form-control @error('email') is-invalid @enderror">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if (! $editing)
        <div class="col-12">
            <div class="form-check">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" id="active" value="1" class="form-check-input" @checked(old('active', true))>
                <label for="active" class="form-check-label">Personal activo</label>
            </div>
        </div>
    @endif
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>
