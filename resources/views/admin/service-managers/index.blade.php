@extends('layouts.app')

@section('title', 'Jefes de servicio | MediTurno')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Jefes de servicio</h1>
            <p class="text-muted mb-0">Usuarios autorizados para revisar solicitudes por servicio.</p>
        </div>

        <a href="{{ route('admin.service-managers.create') }}" class="btn btn-primary">Asociar jefe</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Servicio</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($serviceManagers as $serviceManager)
                        <tr>
                            <td>
                                <div>{{ $serviceManager->user?->name }}</div>
                                <div class="text-muted small">{{ $serviceManager->user?->email }}</div>
                            </td>
                            <td><span class="badge text-bg-secondary">{{ $serviceManager->user?->role }}</span></td>
                            <td>{{ $serviceManager->hospitalService?->name }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.service-managers.destroy', $serviceManager) }}" class="d-flex justify-content-end">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No hay jefes asociados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $serviceManagers->links() }}
    </div>
@endsection
