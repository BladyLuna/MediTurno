@extends('layouts.app')

@section('title', 'Crear servicio | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Crear servicio hospitalario</h1>
        <p class="text-muted mb-0">Registra un área para organizar personal, turnos y reportes futuros.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.hospital-services.store') }}">
                @csrf
                @include('admin.hospital-services._form', ['hospitalService' => null, 'submitLabel' => 'Crear servicio'])
            </form>
        </div>
    </div>
@endsection
