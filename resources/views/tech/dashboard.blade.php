@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4" style="color: #004d40; font-weight: 700; letter-spacing: 1.5px;">
        Équipements en panne
    </h1>

    <p class="mb-4" style="font-weight: 600;">
        Bienvenue {{ Auth::user()->name }}
    </p>

    <!-- Barre de recherche identique -->
    <div class="input-group mb-4" style="max-width: 400px;">
        <span class="input-group-text bg-ocp text-white"><i class="bi bi-search"></i></span>
        <input
            type="text"
            id="searchInput"
            class="form-control"
            placeholder="Rechercher par nom, catégorie, emplacement ou date..."
            aria-label="Recherche équipements"
        />
    </div>

    @if($equipementsEnPanne->isEmpty())
        <div class="alert alert-success" role="alert" style="background-color: #dff0d8; color: #3c763d;">
            Aucun équipement en panne 
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="equipementsTable" style="border-collapse: separate; border-spacing: 0 8px;">
                <thead class="table-ocp text-white" style="background-color: #004d40;">
                    <tr>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Emplacement</th>
                        <th>Date d'acquisition</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipementsEnPanne as $equipement)
                        <tr class="shadow-sm bg-white rounded">
                            <td>{{ $equipement->nom }}</td>
                            <td>{{ $equipement->categorie->nom ?? '-' }}</td>
                            <td>{{ $equipement->emplacement->nom ?? '-' }}</td>
                            <td>{{ $equipement->date_acquisition?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Styles identiques -->
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

<!-- Script recherche dynamique -->
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

<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
