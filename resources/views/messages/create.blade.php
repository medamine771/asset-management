@extends('layouts.app')

@section('content')
<div class="container">
    <h2>✉️ Envoyer un message</h2>

    <form action="{{ route('messages.store') }}" method="POST">
        @csrf
        <div class="form-group mb-2">
            <label for="receiver_id">Choisir un Admin</label>
            <select name="receiver_id" class="form-control">
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-2">
            <label>Sujet</label>
            <input type="text" name="subject" class="form-control">
        </div>
        <div class="form-group mb-2">
            <label>Message</label>
            <textarea name="body" rows="5" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Envoyer</button>
    </form>
</div>
@endsection
