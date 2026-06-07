@extends('layouts.app')

@section('title', 'Crear usuario | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Crear usuario</h1>
        <p class="text-muted mb-0">Registra una cuenta con rol y estado inicial.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                @include('admin.users._form', ['user' => null, 'roles' => $roles, 'submitLabel' => 'Crear usuario'])
            </form>
        </div>
    </div>
@endsection
