@extends('layouts.app')

@section('title', 'Asociar jefe de servicio | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Asociar jefe de servicio</h1>
        <p class="text-muted mb-0">Selecciona un usuario administrador o jefe de servicio y un servicio activo.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.service-managers.store') }}" class="row g-3">
                @csrf

                <div class="col-12 col-md-6">
                    <label for="user_id" class="form-label">Usuario</label>
                    <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                        <option value="">Seleccionar usuario</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                {{ $user->name }} - {{ $user->email }} ({{ $user->role }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label for="hospital_service_id" class="form-label">Servicio</label>
                    <select name="hospital_service_id" id="hospital_service_id" class="form-select @error('hospital_service_id') is-invalid @enderror" required>
                        <option value="">Seleccionar servicio</option>
                        @foreach ($hospitalServices as $hospitalService)
                            <option value="{{ $hospitalService->id }}" @selected(old('hospital_service_id') == $hospitalService->id)>
                                {{ $hospitalService->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('hospital_service_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.service-managers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
