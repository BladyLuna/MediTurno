@extends('layouts.app')

@section('title', 'Crear turno | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Crear plantilla de turno</h1>
        <p class="text-muted mb-0">Define código, horario y color base del turno.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.shift-templates.store') }}">
                @csrf
                @include('admin.shift-templates._form', ['shiftTemplate' => null, 'submitLabel' => 'Crear turno'])
            </form>
        </div>
    </div>
@endsection
