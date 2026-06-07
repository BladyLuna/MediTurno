@extends('layouts.app')

@section('title', 'Turnos por servicio | MediTurno')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Turnos por servicio</h1>
            <p class="text-muted mb-0">Activa o personaliza plantillas de turno para cada servicio hospitalario.</p>
        </div>

        <a href="{{ route('admin.service-shift-templates.create') }}" class="btn btn-primary">Configurar turno</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Servicio</th>
                        <th>Turno base</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Horario</th>
                        <th>Color</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($serviceShiftTemplates as $serviceShiftTemplate)
                        @php
                            $base = $serviceShiftTemplate->shiftTemplate;
                            $color = $serviceShiftTemplate->custom_color ?: $base?->color;
                        @endphp
                        <tr>
                            <td>{{ $serviceShiftTemplate->hospitalService?->name }}</td>
                            <td>{{ $base?->code }} - {{ $base?->name }}</td>
                            <td>{{ $serviceShiftTemplate->custom_code ?: $base?->code }}</td>
                            <td>{{ $serviceShiftTemplate->custom_name ?: $base?->name }}</td>
                            <td>{{ substr($serviceShiftTemplate->custom_start_time ?: $base?->start_time, 0, 5) }} - {{ substr($serviceShiftTemplate->custom_end_time ?: $base?->end_time, 0, 5) }}</td>
                            <td>
                                <span class="d-inline-flex align-items-center gap-2">
                                    <span class="border rounded" style="width: 1.25rem; height: 1.25rem; background-color: {{ $color }}"></span>
                                    {{ $color }}
                                </span>
                            </td>
                            <td>
                                @if ($serviceShiftTemplate->active)
                                    <span class="badge text-bg-success">Activo</span>
                                @else
                                    <span class="badge text-bg-warning">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2 flex-wrap">
                                    <a href="{{ route('admin.service-shift-templates.edit', $serviceShiftTemplate) }}" class="btn btn-outline-primary btn-sm">Editar</a>

                                    @if ($serviceShiftTemplate->active)
                                        <form method="POST" action="{{ route('admin.service-shift-templates.deactivate', $serviceShiftTemplate) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-warning btn-sm">Desactivar</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.service-shift-templates.activate', $serviceShiftTemplate) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-success btn-sm">Activar</button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.service-shift-templates.destroy', $serviceShiftTemplate) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No hay turnos configurados por servicio.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $serviceShiftTemplates->links() }}
    </div>
@endsection
