@extends('layouts.app')

@section('title', 'Servicios hospitalarios | MediTurno')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Servicios hospitalarios</h1>
            <p class="text-muted mb-0">Administración de áreas del hospital disponibles para la gestión de turnos.</p>
        </div>

        <a href="{{ route('admin.hospital-services.create') }}" class="btn btn-primary">Crear servicio</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($hospitalServices as $hospitalService)
                        <tr>
                            <td>{{ $hospitalService->name }}</td>
                            <td>{{ $hospitalService->description ?: '-' }}</td>
                            <td>
                                @if ($hospitalService->active)
                                    <span class="badge text-bg-success">Activo</span>
                                @else
                                    <span class="badge text-bg-warning">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2 flex-wrap">
                                    <a href="{{ route('admin.hospital-services.edit', $hospitalService) }}" class="btn btn-outline-primary btn-sm">Editar</a>

                                    @if ($hospitalService->active)
                                        <form method="POST" action="{{ route('admin.hospital-services.deactivate', $hospitalService) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-warning btn-sm">Desactivar</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.hospital-services.activate', $hospitalService) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-success btn-sm">Activar</button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.hospital-services.destroy', $hospitalService) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No hay servicios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $hospitalServices->links() }}
    </div>
@endsection
