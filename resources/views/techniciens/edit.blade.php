@extends('layouts.app')

@section('title', 'Modifier technicien')

@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <h1 class="mb-4 text-success fw-bold" style="letter-spacing: 1.5px;">
        Modifier technicien
    </h1>

    <form method="POST" action="{{ route('techniciens.update', $technicien->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nom</label>
            <input type="text" id="name" name="name" value="{{ old('name', $technicien->name) }}" 
                   class="form-control @error('name') is-invalid @enderror" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $technicien->email) }}" 
                   class="form-control @error('email') is-invalid @enderror" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <hr>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Mot de passe <small class="text-muted">(laisser vide pour ne pas changer)</small></label>
            <input type="password" id="password" name="password" 
                   class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold">Confirmer mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label fw-semibold">Photo de profil</label>
            <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if($technicien->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $technicien->image) }}" alt="Photo de {{ $technicien->name }}" style="max-width: 120px; border-radius: 8px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('techniciens.index') }}" class="btn btn-secondary ms-2">Annuler</a>
    </form>
</div>
@endsection
