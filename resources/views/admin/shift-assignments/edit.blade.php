@extends('layouts.app')

@section('title', 'Editar asignación | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar asignación de turno</h1>
        <p class="text-muted mb-0">Actualiza servicio, personal, turno y fecha de la asignación.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.shift-assignments.update', $shiftAssignment) }}">
                @csrf
                @method('PUT')
                @include('admin.shift-assignments._form', [
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
