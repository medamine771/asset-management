@extends('layouts.app')

@section('title', 'Répondre au message')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Répondre au message</h3>

    <!-- Message original -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <strong>De :</strong> {{ $message->sender->name }} 
            | <strong>Objet :</strong> {{ $message->subject }}
            <span class="float-end">{{ $message->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="card-body">
            <p>{{ $message->body }}</p>
        </div>
    </div>

    <!-- Formulaire de réponse -->
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Votre réponse</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('messages.sendReply', $message->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="subject" class="form-label">Objet</label>
                    <input type="text" name="subject" class="form-control" id="subject" value="Re: {{ $message->subject }}" required>
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label">Message</label>
                    <textarea name="body" id="body" rows="5" class="form-control" placeholder="Écrivez votre réponse ici..." required></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('messages.inbox') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send-fill"></i> Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
