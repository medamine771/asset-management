@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-white">
            <h2 class="h4 mb-0 font-weight-bold">Modifier la catégorie</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.update', $categorie->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Nom de la catégorie</label>
                    <input type="text" name="nom" 
                           class="form-control @error('nom') is-invalid @enderror"
                           value="{{ old('nom', $categorie->nom) }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection