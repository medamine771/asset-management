@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📥 Boîte de réception</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Expéditeur</th>
                <th>Sujet</th>
                <th>Date</th>
                <th>Lu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $message)
                <tr>
                    <td>{{ $message->sender->name }}</td>
                    <td>
                        <a href="{{ route('messages.show', $message->id) }}">
                            {{ $message->subject }}
                        </a>
                    </td>
                    <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                    <td>{!! $message->read ? '✅' : '📩' !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
