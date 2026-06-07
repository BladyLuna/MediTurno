@extends('layouts.app')

@section('title', 'Configurar turno por servicio | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Configurar turno por servicio</h1>
        <p class="text-muted mb-0">Activa una plantilla base y personaliza sus datos si el servicio lo requiere.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.service-shift-templates.store') }}">
                @csrf
                @include('admin.service-shift-templates._form', [
                    'serviceShiftTemplate' => null,
                    'hospitalServices' => $hospitalServices,
                    'shiftTemplates' => $shiftTemplates,
                    'submitLabel' => 'Configurar turno',
                ])
            </form>
        </div>
    </div>
@endsection
