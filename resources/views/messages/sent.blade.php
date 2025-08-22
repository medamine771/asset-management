@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📤 Messages envoyés</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Destinataire</th>
                <th>Sujet</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $message)
                <tr>
                    <td>{{ $message->receiver->name }}</td>
                    <td>{{ $message->subject }}</td>
                    <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
