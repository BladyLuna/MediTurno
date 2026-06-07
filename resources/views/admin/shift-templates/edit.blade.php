@extends('layouts.app')

@section('title', 'Editar turno | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar plantilla de turno</h1>
        <p class="text-muted mb-0">Actualiza los datos base del turno.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.shift-templates.update', $shiftTemplate) }}">
                @csrf
                @method('PUT')
                @include('admin.shift-templates._form', ['shiftTemplate' => $shiftTemplate, 'submitLabel' => 'Guardar cambios'])
            </form>
        </div>
    </div>
@endsection
