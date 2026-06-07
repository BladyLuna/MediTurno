@extends('layouts.app')

@section('title', 'Personal de salud | MediTurno')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Personal de salud</h1>
            <p class="text-muted mb-0">Registro administrativo del personal por servicio hospitalario.</p>
        </div>

        <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">Registrar personal</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.staff.index') }}" class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ $filters['name'] ?? '' }}" class="form-control">
                </div>

                <div class="col-12 col-md-3">
                    <label for="ci" class="form-label">CI</label>
                    <input type="text" name="ci" id="ci" value="{{ $filters['ci'] ?? '' }}" class="form-control">
                </div>

                <div class="col-12 col-md-3">
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

                <div class="col-12 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filtrar</button>
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>CI</th>
                        <th>Servicio</th>
                        <th>Cargo</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($staff as $staffMember)
                        <tr>
                            <td>{{ $staffMember->full_name }}</td>
                            <td>{{ $staffMember->ci }}</td>
                            <td>{{ $staffMember->hospitalService?->name }}</td>
                            <td>{{ $staffMember->position }}</td>
                            <td class="text-break">{{ $staffMember->user?->email ?? '-' }}</td>
                            <td>
                                @if ($staffMember->active)
                                    <span class="badge text-bg-success">Activo</span>
                                @else
                                    <span class="badge text-bg-warning">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2 flex-wrap">
                                    <a href="{{ route('admin.staff.edit', $staffMember) }}" class="btn btn-outline-primary btn-sm">Editar</a>

                                    @if ($staffMember->active)
                                        <form method="POST" action="{{ route('admin.staff.deactivate', $staffMember) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-warning btn-sm">Desactivar</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.staff.activate', $staffMember) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-success btn-sm">Activar</button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.staff.destroy', $staffMember) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No hay personal registrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $staff->links() }}
    </div>
@endsection
