@extends('layouts.app')

@section('title', 'Editar usuario | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Editar usuario</h1>
        <p class="text-muted mb-0">Actualiza datos de acceso y rol.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')
                @include('admin.users._form', ['user' => $user, 'roles' => $roles, 'submitLabel' => 'Guardar cambios'])
            </form>
        </div>
    </div>
@endsection
