@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- En-tête -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 text-ocp mb-0">Détails Intervention #{{ $intervention->id }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord </a></li>
                            <li class="breadcrumb-item active">Détails</li>
                        </ol>
                    </nav>
                </div>
                <span class="badge bg-{{ 
                    $intervention->statut === 'terminee' ? 'success' : 
                    ($intervention->statut === 'en_cours' ? 'primary' : 'warning') 
                }}">
                    {{ ucfirst(str_replace('_', ' ', $intervention->statut)) }}
                </span>
            </div>

            <!-- Carte principale -->
            <div class="card shadow-sm">
                <div class="card-header bg-ocp text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-clipboard2-pulse me-2"></i>
                        {{ $intervention->equipement->nom }}
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Informations de base -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-ocp"><i class="bi bi-tools me-2"></i>Équipement</h6>
                            <ul class="list-unstyled">
                                <li><strong>Catégorie:</strong> {{ $intervention->equipement->categorie->nom ?? '-' }}</li>
                                <li><strong>Emplacement:</strong> {{ $intervention->equipement->emplacement->nom ?? '-' }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-ocp"><i class="bi bi-info-circle me-2"></i>Détails</h6>
                            <ul class="list-unstyled">
                                <li><strong>Technicien:</strong> {{ $intervention->technicien->name }}</li>
                                <li><strong>Créée le:</strong> {{ $intervention->created_at->format('d/m/Y H:i') }}</li>
                                <li><strong>Date intervention:</strong> 
                                    {{ $intervention->date_intervention ? $intervention->date_intervention->format('d/m/Y H:i') : 'Non planifiée' }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h6 class="text-ocp"><i class="bi bi-card-text me-2"></i>Description</h6>
                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($intervention->description)) !!}
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tech.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Retour
                            </a>

                            <div class="btn-group">
                                @isset($actions['start'])
                                <form method="POST" action="{{ route('interventions.update', $intervention) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="start_intervention" value="1">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-play-fill me-1"></i> Démarrer
                                    </button>
                                </form>
                                @endisset

                                @isset($actions['complete'])
                                <form method="POST" action="{{ route('interventions.update', $intervention) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="complete_intervention" value="1">
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check-circle me-1"></i> Terminer
                                    </button>
                                </form>
                                @endisset

                                @can('update', $intervention)
                                <a href="{{ route('interventions.edit', $intervention) }}" class="btn btn-ocp">
                                    <i class="bi bi-pencil me-1"></i> Modifier
                                </a>
                                @endcan
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection