@extends('layouts.app')

@section('title', 'Dashboard | MediTurno')

@section('content')
    <div class="dashboard-hero rounded-4 p-4 p-md-5 mb-4">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-8">
                <span class="badge text-bg-light text-dark mb-3">MVP cerrado</span>
                <h1 class="display-6 fw-semibold mb-3">{{ $roleMeta['title'] }}</h1>
                <p class="lead mb-0">{{ $roleMeta['subtitle'] }}</p>
            </div>

            <div class="col-12 col-lg-4 text-lg-end">
                <div class="fs-6 text-white-50">Sesión activa</div>
                <div class="fs-4 fw-semibold">{{ $user?->name }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Estado de acceso</h2>
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted fw-normal">Rol</dt>
                        <dd class="col-7 text-uppercase">{{ $user?->role }}</dd>

                        <dt class="col-5 text-muted fw-normal">Estado</dt>
                        <dd class="col-7">
                            <span class="badge text-bg-success">Activo</span>
                        </dd>

                        <dt class="col-5 text-muted fw-normal">Correo</dt>
                        <dd class="col-7 text-break">{{ $user?->email }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Accesos del módulo</h2>
                    <div class="row g-3">
                        @foreach ($roleMeta['items'] as $item)
                            <div class="col-12 col-md-6">
                                <div class="border rounded-3 p-3 bg-light h-100">
                                    {{ $item }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
