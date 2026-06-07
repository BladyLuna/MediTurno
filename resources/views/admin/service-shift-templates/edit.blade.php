@extends('layouts.app')

@section('title', 'Editar turno por servicio | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar turno por servicio</h1>
        <p class="text-muted mb-0">Actualiza la configuración de turno para el servicio seleccionado.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.service-shift-templates.update', $serviceShiftTemplate) }}">
                @csrf
                @method('PUT')
                @include('admin.service-shift-templates._form', [
                    'serviceShiftTemplate' => $serviceShiftTemplate,
                    'hospitalServices' => $hospitalServices,
                    'shiftTemplates' => $shiftTemplates,
                    'submitLabel' => 'Guardar cambios',
                ])
            </form>
        </div>
    </div>
@endsection
