@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-0" style="color: #004d40; font-weight: 700; letter-spacing: 1.5px;">
                Tableau de Bord Technicien
            </h1>
            <p class="mb-0" style="font-weight: 600;">
                Bienvenue {{ Auth::user()->name }}
            </p>
        </div>
        <span class="badge bg-ocp text-white py-2 px-3">
            <i class="bi bi-person-gear me-1"></i> Technicien
        </span>
    </div>

    <!-- Barre de recherche -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group" style="max-width: 400px;">
                <span class="input-group-text bg-ocp text-white"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput" class="form-control" 
                       placeholder="Rechercher équipements...">
            </div>
        </div>
        <div class="col-md-6 text-end">
            <div class="btn-group">
                <a href="?filter=all" class="btn btn-sm btn-ocp{{ request('filter', 'all') === 'all' ? '' : '-outline' }}">Toutes</a>
                <a href="?filter=en_attente" class="btn btn-sm btn-ocp{{ request('filter') === 'en_attente' ? '' : '-outline' }}">En attente</a>
                <a href="?filter=en_cours" class="btn btn-sm btn-ocp{{ request('filter') === 'en_cours' ? '' : '-outline' }}">En cours</a>
                <a href="?filter=terminee" class="btn btn-sm btn-ocp{{ request('filter') === 'terminee' ? '' : '-outline' }}">Terminées</a>
            </div>
        </div>
    </div>

    <!-- Deux sections côte à côte -->
    <div class="row">
        <!-- Équipements en panne -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-ocp text-white py-2">
                    <h5 class="mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>Équipements en panne
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($equipementsEnPanne->isEmpty())
                        <div class="alert alert-success m-3">
                            <i class="bi bi-check-circle me-2"></i>Aucun équipement en panne
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="equipementsTable">
                                <thead class="bg-ocp-light">
                                    <tr>
                                        <th>Nom</th>
                                        <th>Catégorie</th>
                                        <th>Emplacement</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($equipementsEnPanne as $equipement)
                                    <tr>
                                        <td>{{ $equipement->nom }}</td>
                                        <td>{{ $equipement->categorie->nom ?? '-' }}</td>
                                        <td>{{ $equipement->emplacement->nom ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-ocp" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#creerInterventionModal"
                                                    data-equipement-id="{{ $equipement->id }}">
                                                <i class="bi bi-plus-circle"></i> Créer intervention
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Interventions du technicien -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-ocp text-white py-2">
                    <h5 class="mb-0">
                        <i class="bi bi-clipboard2-pulse me-2"></i>Mes Interventions
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($interventions->isEmpty())
                        <div class="alert alert-info m-3">
                            <i class="bi bi-info-circle me-2"></i>Vous n'avez aucune intervention
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-ocp-light">
                                    <tr>
                                        <th>Équipement</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($interventions as $intervention)
                                    <tr>
                                        <td>{{ $intervention->equipement->nom }}</td>
                                        <td>
                                            @php
                                                $badgeClass = [
                                                    'en_attente' => 'bg-warning',
                                                    'en_cours' => 'bg-primary',
                                                    'terminee' => 'bg-success'
                                                ][$intervention->statut];
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $intervention->statut)) }}
                                            </span>
                                        </td>
                                        <td>{{ $intervention->date_intervention?->format('d/m/Y') ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('interventions.show', $intervention->id) }}" 
                                               class="btn btn-sm btn-ocp-outline">
                                                <i class="bi bi-eye"></i> Voir
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de création d'intervention -->
<div class="modal fade" id="creerInterventionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-ocp text-white">
                <h5 class="modal-title">Nouvelle Intervention</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('interventions.store') }}">
                @csrf
                <input type="hidden" name="equipement_id" id="modalEquipementId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Urgence</label>
                        <select class="form-select" name="urgence">
                            <option value="normal">Normal</option>
                            <option value="urgent">Urgent</option>
                            <option value="critique">Critique</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-ocp">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    .bg-ocp { background-color: #004d40; }
    .bg-ocp-light { background-color: #e0f2f1; }
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
    .btn-ocp-outline {
        border: 1px solid #004d40;
        color: #004d40;
        background: transparent;
    }
    .btn-ocp-outline:hover {
        background-color: #004d40;
        color: white;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 77, 64, 0.05);
    }
    
    .badge.bg-warning { color: #212529; }
</style>

<!-- Scripts -->
<script>
    // Gestion de la modal
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('creerInterventionModal');
        if (modal) {
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                document.getElementById('modalEquipementId').value = button.getAttribute('data-equipement-id');
            });
        }
        
        // Recherche dynamique
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            const rows = document.querySelectorAll('#equipementsTable tbody tr');
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                rows.forEach(row => {
                    row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
                });
            });
        }
    });
</script>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection