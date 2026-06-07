@extends('layouts.app')

@section('title', 'Crear asignación | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Crear asignación de turno</h1>
        <p class="text-muted mb-0">Asigna un turno configurado a personal activo.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.shift-assignments.store') }}">
                @csrf
                @include('admin.shift-assignments._form', [
                    'shiftAssignment' => null,
                    'staffOptions' => $staffOptions,
                    'hospitalServices' => $hospitalServices,
                    'serviceShiftTemplates' => $serviceShiftTemplates,
                    'submitLabel' => 'Crear asignación',
                ])
            </form>
        </div>
    </div>
@endsection
