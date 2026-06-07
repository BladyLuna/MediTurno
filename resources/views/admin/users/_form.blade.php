@php
    $editing = $user !== null;
@endphp

<div class="row g-3">
    <div class="col-12 col-md-6">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user?->name) }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user?->email) }}" class="form-control @error('email') is-invalid @enderror" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" @if (! $editing) required @endif>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if ($editing)
            <div class="form-text">Dejar en blanco para conservar la contraseña actual.</div>
        @endif
    </div>

    <div class="col-12 col-md-6">
        <label for="role" class="form-label">Rol</label>
        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
            @foreach ($roles as $role)
                <option value="{{ $role }}" @selected(old('role', $user?->role) === $role)>{{ $role }}</option>
            @endforeach
        </select>
        @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if (! $editing)
        <div class="col-12">
            <div class="form-check">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" id="active" value="1" class="form-check-input" @checked(old('active', true))>
                <label for="active" class="form-check-label">Usuario activo</label>
            </div>
        </div>
    @endif
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>
