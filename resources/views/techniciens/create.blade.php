@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un technicien</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oups !</strong> Il y a des erreurs dans le formulaire.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('techniciens.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nom complet</label>
            <input type="text" name="name" class="form-control" placeholder="Nom complet" value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="tel" name="telephone" class="form-control" 
                   placeholder="Ex: +212612345678" 
                   value="{{ old('telephone') }}"
                   pattern="[\+]{0,1}[0-9\s\-]+">
            <small class="text-muted">Format: +212612345678 ou 0612345678</small>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" placeholder="Mot de passe">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Photo de profil</label>
            <input type="file" name="image" class="form-control">
        </div>

        <input type="hidden" name="role" value="technicien">

        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="{{ route('techniciens.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection