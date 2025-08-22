@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4" style="color: #004d40; font-weight: 700; letter-spacing: 1.5px;">
        Liste des équipements
    </h1>
   
    
    <a href="{{ route('equipements.create') }}" class="btn btn-ocp mb-4">
        <i class="bi bi-plus-circle"></i> Ajouter un équipement
    </a>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <!-- Barre de recherche -->
    <div class="input-group mb-4" style="max-width: 400px;">
        <span class="input-group-text bg-ocp text-white"><i class="bi bi-search"></i></span>
        <input
            type="text"
            id="searchInput"
            class="form-control"
            placeholder="Rechercher par nom, catégorie, emplacement ou état..."
            aria-label="Recherche équipements"
        />
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="equipementsTable" style="border-collapse: separate; border-spacing: 0 8px;">
            <thead class="table-ocp text-white" style="background-color: #004d40;">
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Emplacement</th>
                    <th>État</th>
                    <th>Date d'acquisition</th>
                    <th>Historique</th>
                    <th style="width: 160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($equipements as $equipement)
                <tr class="shadow-sm bg-white rounded">
                    <td style="width: 80px;">
                        @if($equipement->image)
                            <img src="{{ asset('storage/' . $equipement->image) }}" alt="Image {{ $equipement->nom }}" style="max-width: 70px; max-height: 50px; object-fit: cover; border-radius: 4px;">
                        @else
                            <img src="{{ asset('images/default-equipement.png') }}" alt="Image par défaut" style="max-width: 70px; max-height: 50px; object-fit: cover; border-radius: 4px;">
                        @endif
                    </td>
                    <td>{{ $equipement->nom }}</td>
                    <td>{{ $equipement->categorie->nom ?? '-' }}</td>
                    <td>{{ $equipement->emplacement->nom ?? '-' }}</td>
                    <td>{{ ucfirst($equipement->etat) }}</td>
                    <td>{{ $equipement->date_acquisition?->format('d/m/Y') ?? '-' }}</td>
                    <td> <a href="{{ route('equipements.interventions', $equipement) }}" class="btn btn-info btn-sm">
                        Voir l’historique
                    </a></td>
                    
                    <td>
                        <a href="{{ route('equipements.show', $equipement) }}" class="btn btn-info btn-sm me-1" title="Voir">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('equipements.edit', $equipement) }}" class="btn btn-warning btn-sm me-1" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('equipements.destroy', $equipement) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" title="Supprimer">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center fst-italic text-muted">Aucun équipement trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">
    <a href="{{ route('dashboard') }}" 
       class="btn btn-outline-dark ripple" 
       title="Retour au tableau de bord">
        <i class="bi bi-arrow-left fs-5"></i>
    </a>
</div>

<!-- Styles personnalisés -->
<style>
    .btn-ocp {
        background-color: #004d40;
        color: #ffca28;
        font-weight: 600;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }
    .btn-ocp:hover {
        background-color: #00695c;
        color: white;
    }
    .table-ocp th {
        border: none;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }
    tbody tr {
        transition: background-color 0.2s ease;
    }
    tbody tr:hover {
        background-color: #f0f9f8;
    }
    .input-group-text.bg-ocp {
        background-color: #004d40;
        border-color: #004d40;
    }
    input.form-control:focus {
        border-color: #ffca28 !important;
        box-shadow: 0 0 8px #ffca28 !important;
    }
</style>

<!-- Script de recherche dynamique -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('#equipementsTable tbody tr');

        searchInput.addEventListener('keyup', function () {
            const filter = this.value.toLowerCase().trim();

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    });
</script>

<!-- Bootstrap Icons CDN (pour les icônes) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
