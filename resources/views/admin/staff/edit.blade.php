@extends('layouts.app')

@section('title', 'Editar personal | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar personal de salud</h1>
        <p class="text-muted mb-0">Actualiza datos administrativos del personal.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.staff.update', $staffMember) }}">
                @csrf
                @method('PUT')
                @include('admin.staff._form', [
                    'staffMember' => $staffMember,
                    'hospitalServices' => $hospitalServices,
                    'users' => $users,
                    'submitLabel' => 'Guardar cambios',
                ])
            </form>
        </div>
    </div>
@endsection
