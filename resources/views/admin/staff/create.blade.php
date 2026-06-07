@extends('layouts.app')

@section('title', 'Registrar personal | MediTurno')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Registrar personal de salud</h1>
        <p class="text-muted mb-0">Asocia el personal a un servicio y, opcionalmente, a una cuenta de usuario.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.staff.store') }}">
                @csrf
                @include('admin.staff._form', [
                    'staffMember' => null,
                    'hospitalServices' => $hospitalServices,
                    'users' => $users,
                    'submitLabel' => 'Registrar personal',
                ])
            </form>
        </div>
    </div>
@endsection
