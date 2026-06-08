@extends('layouts.app')

@section('title', 'Editar asignación del servicio | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar asignación de turno</h1>
        <p class="text-muted mb-0">Actualiza turno, fecha y observación operativa dentro de tus servicios.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('service-assignments.update', $shiftAssignment) }}">
                @csrf
                @method('PUT')
                @include('service-manager.shift-assignments._form', [
                    'shiftAssignment' => $shiftAssignment,
                    'staffOptions' => $staffOptions,
                    'hospitalServices' => $hospitalServices,
                    'serviceShiftTemplates' => $serviceShiftTemplates,
                    'submitLabel' => 'Guardar cambios',
                ])
            </form>
        </div>
    </div>
@endsection
