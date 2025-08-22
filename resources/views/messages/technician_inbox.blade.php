@extends('layouts.app')

@section('title', 'Boîte de réception')

@section('content')
<div class="container">
    <h2>Boîte de réception</h2>

    @if($messages->isEmpty())
        <div class="alert alert-info mt-3">
            Vous n'avez aucun message pour le moment.
        </div>
    @else
        <table class="table table-hover mt-3">
            <thead>
                <tr>
                    <th>De</th>
                    <th>Sujet</th>
                    <th>Reçu le</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $message)
                    <tr>
                        <td>{{ $message->sender->name }}</td>
                        <td>{{ $message->subject }}</td>
                        <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($message->read)
                                <span class="badge bg-success">Lu</span>
                            @else
                                <span class="badge bg-warning text-dark">Non lu</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('messages.show', $message->id) }}" class="btn btn-primary btn-sm">
                                Voir
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
