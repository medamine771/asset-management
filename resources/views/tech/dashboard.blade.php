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
        <span class="badge badge-ocp">
            <i class="bi bi-person-gear me-1"></i> Technicien
        </span>
    </div>

    <!-- Barre de recherche -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group" style="max-width: 400px;">
                <span class="input-group-text bg-ocp text-white"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher équipements...">
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

    <div class="row">
        <!-- Équipements en panne -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-ocp text-white py-2">
                    <h5 class="mb-0">
                        <i class="bi bi-hdd-network me-2"></i>Équipements en panne
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
                                        <th>État</th>
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
                                            <form action="{{ route('equipements.updateEtat', $equipement->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="etat" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    <option value="bon" {{ $equipement->etat == 'bon' ? 'selected' : '' }}>Bon</option>
                                                    <option value="en panne" {{ $equipement->etat == 'en panne' ? 'selected' : '' }}>En panne</option>
                                                    <option value="maintenance" {{ $equipement->etat == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                </select>
                                            </form>
                                        </td>
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

        <!-- Tous les équipements -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-ocp text-white py-2">
                    <h5 class="mb-0">
                        <i class="bi bi-hdd-rack me-2"></i>Tous les Équipements
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($equipements->isEmpty())
                        <div class="alert alert-warning m-3">
                            <i class="bi bi-exclamation-circle me-2"></i>Aucun équipement trouvé
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-ocp-light">
                                    <tr>
                                        <th>Nom</th>
                                        <th>Catégorie</th>
                                        <th>Emplacement</th>
                                        <th>État</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($equipements as $equipement)
                                    <tr>
                                        <td>{{ $equipement->nom }}</td>
                                        <td>{{ $equipement->categorie->nom ?? '-' }}</td>
                                        <td>{{ $equipement->emplacement->nom ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('equipements.updateEtat', $equipement->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="etat" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    <option value="bon" {{ $equipement->etat == 'bon' ? 'selected' : '' }}>Bon</option>
                                                    <option value="en panne" {{ $equipement->etat == 'en panne' ? 'selected' : '' }}>En panne</option>
                                                    <option value="maintenance" {{ $equipement->etat == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                </select>
                                            </form>
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

    <!-- Interventions -->
    <div class="col-lg-12 mb-4">
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
                                        <form action="{{ route('interventions.updateStatus', $intervention->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="statut" class="form-select form-select-sm" onchange="this.form.submit()" 
                                                style="cursor: pointer; {{ [
                                                    'en_attente' => 'background-color: #ffc10720; color: #856404;',
                                                    'en_cours' => 'background-color: #0d6efd20; color: #0a58ca;',
                                                    'terminee' => 'background-color: #19875420; color: #0f5132;'
                                                ][$intervention->statut] }}">
                                                <option value="en_attente" {{ $intervention->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                                <option value="en_cours" {{ $intervention->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                                <option value="terminee" {{ $intervention->statut == 'terminee' ? 'selected' : '' }}>Terminée</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{ $intervention->date_intervention?->format('d/m/Y') ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('interventions.show', $intervention->id) }}" class="btn btn-sm btn-ocp-outline">
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

<!-- Modal de création d'intervention -->
<div class="modal fade" id="creerInterventionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-ocp text-white">
                <h5 class="modal-title">Nouvelle Intervention</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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

<!-- Bouton pour envoyer message -->
<button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#sendMessageModal">
    📩 Envoyer un message à l'Admin
</button>

<!-- Modal d'envoi de message -->
<div class="modal fade" id="sendMessageModal" tabindex="-1" aria-labelledby="sendMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="sendMessageModalLabel">Nouveau Message</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <form method="POST" action="{{ route('messages.store') }}">
          @csrf
          <div class="modal-body">
              <div class="mb-3">
                  <label for="subject" class="form-label">Sujet</label>
                  <input type="text" name="subject" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label for="body" class="form-label">Message</label>
                  <textarea name="body" rows="4" class="form-control" required></textarea>
              </div>
              <input type="hidden" name="receiver_id" value="{{ \App\Models\User::where('role', 'admin')->first()->id }}">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Envoyer</button>
          </div>
        </form>
      </div>
    </div>
</div>

<!-- Styles -->
<style>
    /* Couleurs OCP */
    .bg-ocp { background-color: #004d40 !important; }
    .bg-ocp-light { background-color: #e0f2f1 !important; }
    .text-ocp { color: #004d40 !important; }

    /* Boutons */
    .btn-ocp { background-color: #004d40; color: #fff; border-radius: 0.5rem; font-weight: 600; transition: 0.3s; }
    .btn-ocp:hover { background-color: #00695c; color: #fff; }
    .btn-ocp-outline { border: 2px solid #004d40; color: #004d40; background: transparent; border-radius: 0.5rem; font-weight: 600; transition: 0.3s; }
    .btn-ocp-outline:hover { background-color: #004d40; color: #fff; }

    /* Badges */
    .badge-ocp { background-color: #004d40; font-size: 0.9rem; padding: 0.5rem 0.75rem; }

    /* Cartes */
    .card { border-radius: 1rem; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }

    /* Tableaux */
    .table thead { background-color: #e0f2f1; color: #004d40; font-weight: 600; }
    .table-hover tbody tr:hover { background-color: #f1fdfb; }

    /* Form Select */
    .form-select-sm { padding: 0.35rem 1rem; font-size: 0.9rem; border-radius: 0.35rem; font-weight: 500; cursor: pointer; }

    /* Modals */
    .modal-header.bg-ocp { border-bottom: none; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; }
    .modal-content { border-radius: 0.75rem; }
    .modal-footer { border-top: none; }

    /* En-tête dashboard */
    h1 { font-size: 1.8rem; }
    p { font-size: 1rem; color: #555; }

    /* Recherche */
    .input-group .form-control { border-radius: 0.5rem 0 0 0.5rem; }
    .input-group .input-group-text { border-radius: 0.5rem 0 0 0.5rem; }

    /* Responsivité */
    @media (max-width: 768px) {
        .d-flex.justify-content-between { flex-direction: column; gap: 0.5rem; }
        .btn-group { width: 100%; display: flex; flex-wrap: wrap; gap: 0.5rem; }
    }
</style>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('creerInterventionModal');
        if (modal) {
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                document.getElementById('modalEquipementId').value = button.getAttribute('data-equipement-id');
            });
        }

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

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
