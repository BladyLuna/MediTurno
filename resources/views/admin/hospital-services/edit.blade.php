@extends('layouts.app')

@section('title', 'Editar servicio | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar servicio hospitalario</h1>
        <p class="text-muted mb-0">Actualiza los datos administrativos del servicio.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.hospital-services.update', $hospitalService) }}">
                @csrf
                @method('PUT')
                @include('admin.hospital-services._form', ['hospitalService' => $hospitalService, 'submitLabel' => 'Guardar cambios'])
            </form>
        </div>
    </div>
@endsection
