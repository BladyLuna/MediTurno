@extends('layouts.app')

@section('title', 'Plantillas de turno | MediTurno')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Plantillas de turno</h1>
            <p class="text-muted mb-0">Turnos base con código, horario y color para calendario futuro.</p>
        </div>

        <a href="{{ route('admin.shift-templates.create') }}" class="btn btn-primary">Crear turno</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Horario</th>
                        <th>Color</th>
                        <th>Laboral</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shiftTemplates as $shiftTemplate)
                        <tr>
                            <td><span class="badge text-bg-secondary">{{ $shiftTemplate->code }}</span></td>
                            <td>{{ $shiftTemplate->name }}</td>
                            <td>{{ substr($shiftTemplate->start_time, 0, 5) }} - {{ substr($shiftTemplate->end_time, 0, 5) }}</td>
                            <td>
                                <span class="d-inline-flex align-items-center gap-2">
                                    <span class="border rounded" style="width: 1.25rem; height: 1.25rem; background-color: {{ $shiftTemplate->color }}"></span>
                                    {{ $shiftTemplate->color }}
                                </span>
                            </td>
                            <td>{{ $shiftTemplate->is_working_shift ? 'Sí' : 'No' }}</td>
                            <td>
                                @if ($shiftTemplate->active)
                                    <span class="badge text-bg-success">Activo</span>
                                @else
                                    <span class="badge text-bg-warning">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2 flex-wrap">
                                    <a href="{{ route('admin.shift-templates.edit', $shiftTemplate) }}" class="btn btn-outline-primary btn-sm">Editar</a>

                                    @if ($shiftTemplate->active)
                                        <form method="POST" action="{{ route('admin.shift-templates.deactivate', $shiftTemplate) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-warning btn-sm">Desactivar</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.shift-templates.activate', $shiftTemplate) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-success btn-sm">Activar</button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.shift-templates.destroy', $shiftTemplate) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No hay plantillas de turno.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $shiftTemplates->links() }}
    </div>
@endsection
