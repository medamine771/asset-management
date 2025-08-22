@extends('layouts.app')

@section('title', 'Dashboard Technicien')

@section('content')
<div class="container mt-5">

    <!-- Titre et bouton -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary" style="letter-spacing: 1px;">Liste des interventions</h1>
        <a href="{{ route('interventions.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Ajouter une intervention
        </a>
    </div>

    <!-- Message succès -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <!-- Barre de recherche -->
    <div class="input-group mb-4" style="max-width: 400px;">
        <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher une intervention...">
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle shadow-sm rounded" id="interventionsTable">
            <thead class="table-primary text-white" style="background-color: #0d6efd;">
                <tr>
                    <th>Équipement</th>
                    <th>Description</th>
                    <th>Technicien</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th class="text-center" style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($interventions as $intervention)
                    <tr>
                        <td>{{ $intervention->equipement->nom ?? '-' }}</td>
                        <td>{{ $intervention->description }}</td>
                        <td>{{ $intervention->technicien->name ?? '-' }}</td>
                        <td>{{ $intervention->date_intervention?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            @if(Auth::user()->role === 'technicien' && Auth::id() == $intervention->technicien_id)
                                <form action="{{ route('interventions.updateStatut', $intervention->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="statut" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="en_attente" {{ $intervention->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="en_cours" {{ $intervention->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                        <option value="terminee" {{ $intervention->statut == 'terminee' ? 'selected' : '' }}>Terminée</option>
                                    </select>
                                </form>
                            @else
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
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('interventions.edit', $intervention) }}" class="btn btn-warning btn-sm me-1" title="Modifier">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('interventions.destroy', $intervention) }}" method="POST" class="delete-form d-inline">
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
                        <td colspan="6" class="text-center text-muted fst-italic">Aucune intervention trouvée.</td>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Recherche dynamique
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('#interventionsTable tbody tr');

    searchInput.addEventListener('keyup', function () {
        const filter = this.value.toLowerCase().trim();
        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
        });
    });

    // Confirmation SweetAlert2 pour suppression
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Confirmer la suppression',
                text: "Êtes-vous sûr de vouloir supprimer cette intervention ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if(result.isConfirmed) {
                    const row = form.closest('tr');
                    row.style.opacity = 0;
                    row.style.transition = 'all 0.3s ease';
                    setTimeout(() => form.submit(), 300);
                }
            });
        });
    });

    // Message de succès après action
    @if(session('swal'))
        Swal.fire({
            icon: "{{ session('swal')['icon'] }}",
            title: "{{ session('swal')['title'] }}",
            text: "{{ session('swal')['text'] }}",
            timer: 2500,
            showConfirmButton: false
        });
    @endif
});
</script>
@endpush
@endsection
