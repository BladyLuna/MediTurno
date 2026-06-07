@extends('layouts.app')

@section('title', 'Notificaciones | MediTurno')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Notificaciones</h1>
            <p class="text-muted mb-0">Avisos internos del sistema.</p>
        </div>

        <form method="POST" action="{{ route('notifications.read-all') }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-outline-primary">Marcar todas como leídas</button>
        </form>
    </div>

    <div class="card shadow-sm">
        <div class="list-group list-group-flush">
            @forelse ($notifications as $notification)
                <div class="list-group-item">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                        <div>
                            <div class="fw-semibold">{{ $notification->title }}</div>
                            <div>{{ $notification->message }}</div>
                            <div class="text-muted small">{{ $notification->created_at?->format('Y-m-d H:i') }}</div>
                        </div>
                        <div class="d-flex align-items-start gap-2">
                            @if ($notification->read_at)
                                <span class="badge text-bg-secondary">Leída</span>
                            @else
                                <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-success btn-sm">Marcar leída</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="list-group-item text-center text-muted py-4">No hay notificaciones.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-3">
        {{ $notifications->links() }}
    </div>
@endsection
