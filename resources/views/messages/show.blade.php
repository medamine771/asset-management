@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-3">
        <!-- Header du message -->
        <div class="card-header bg-white border-bottom">
            <h4 class="mb-0 fw-bold text-dark">{{ $message->subject }}</h4>
        </div>

        <!-- Corps du message -->
        <div class="card-body">
            <!-- Infos expéditeur / destinataire -->
            <div class="d-flex align-items-center mb-3">
                <div class="me-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:45px; height:45px; font-weight:bold;">
                        {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                    </div>
                </div>
                <div>
                    <p class="mb-0 fw-bold">{{ $message->sender->name }}</p>
                    <small class="text-muted">
                        à {{ $message->receiver->name }} • {{ $message->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>

            <hr>

            <!-- Contenu du message -->
            <div class="mt-3" style="min-height:150px;">
                <p class="text-dark" style="white-space: pre-line;">{{ $message->body }}</p>
            </div>
        </div>

        <!-- Footer avec actions -->
        <div class="card-footer bg-white">
            <a href="{{ route('messages.inbox') }}" class="btn btn-light border">
                ⬅ Retour
            </a>

            @if(Auth::user()->role === 'admin' && Auth::id() === $message->receiver_id)
                <a href="{{ route('messages.reply', $message->id) }}" class="btn btn-primary ms-2">
                    ✉ Répondre
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
