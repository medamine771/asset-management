@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-ocp text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="bi bi-clipboard2-pulse me-2"></i>Modifier l'intervention
                </h2>
                <span class="badge bg-light text-ocp fs-6">
                    ID: {{ $intervention->id }}
                </span>
            </div>
        </div>
        
        <div class="card-body">
            <form action="{{ route('interventions.update', $intervention) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Équipement concerné</label>
                        <select name="equipement_id" class="form-select @error('equipement_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionner un équipement --</option>
                            @foreach($equipements as $equipement)
                                <option value="{{ $equipement->id }}" 
                                    {{ $intervention->equipement_id == $equipement->id ? 'selected' : '' }}
                                    data-categorie="{{ $equipement->categorie->nom ?? '' }}"
                                    data-emplacement="{{ $equipement->emplacement->nom ?? '' }}">
                                    {{ $equipement->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('equipement_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <small class="text-muted">
                                <span id="categorie-info">Catégorie: {{ $intervention->equipement->categorie->nom ?? '-' }}</span>, 
                                <span id="emplacement-info">Emplacement: {{ $intervention->equipement->emplacement->nom ?? '-' }}</span>
                            </small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Statut</label>
                        <select name="statut" class="form-select @error('statut') is-invalid @enderror" required>
                            <option value="en_attente" {{ $intervention->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="en_cours" {{ $intervention->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="terminee" {{ $intervention->statut == 'terminee' ? 'selected' : '' }}>Terminée</option>
                        </select>
                        @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $intervention->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date d'intervention</label>
                        <input type="date" name="date_intervention" 
                               class="form-control @error('date_intervention') is-invalid @enderror" 
                               value="{{ old('date_intervention', $intervention->date_intervention?->format('Y-m-d')) }}" 
                               required>
                        @error('date_intervention')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Technicien</label>
                        <select name="technicien_id" class="form-select @error('technicien_id') is-invalid @enderror" required>
                            @foreach($techniciens as $technicien)
                                <option value="{{ $technicien->id }}" {{ $intervention->technicien_id == $technicien->id ? 'selected' : '' }}>
                                    {{ $technicien->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('technicien_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('interventions.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Retour
                    </a>
                    
                    <div>
                        <button type="submit" class="btn btn-ocp">
                            <i class="bi bi-check-circle me-1"></i> Enregistrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mise à jour des infos catégorie/emplacement quand on change d'équipement
        const equipementSelect = document.querySelector('select[name="equipement_id"]');
        
        equipementSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('categorie-info').textContent = 'Catégorie: ' + selectedOption.dataset.categorie || '-';
            document.getElementById('emplacement-info').textContent = 'Emplacement: ' + selectedOption.dataset.emplacement || '-';
        });
    });
</script>
@endsection

<style>
    .bg-ocp { background-color: #004d40; }
    .text-ocp { color: #004d40; }
    .btn-ocp {
        background-color: #004d40;
        color: white;
        border: none;
    }
    .btn-ocp:hover {
        background-color: #00695c;
        color: white;
    }
    .card-header {
        border-radius: 0.375rem 0.375rem 0 0 !important;
    }
</style>
@endsection