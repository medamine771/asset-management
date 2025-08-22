@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container mt-4">

    {{-- Titre principal --}}
    <h1 class="mb-4 text-success fw-bold" style="letter-spacing: 1.5px;">Tableau de bord</h1>

    {{-- ====== Row 1 : Statistiques principales ====== --}}
    <div class="row g-3">

        <div class="col-6 col-md-3">
            <a href="{{ route('equipements.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 text-white stat-card" style="background-color: #004d40;">
                    <div class="card-body text-center p-2">
                        <i class="bi bi-hdd-network display-4 mb-1"></i>
                        <h6 class="card-title mb-1">Équipements</h6>
                        <p class="h4 mb-0">{{ $nombreEquipements }}</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-3">
            <a href="{{ route('interventions.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 text-white stat-card" style="background-color: #6BA539;">
                    <div class="card-body text-center p-2">
                        <i class="bi bi-tools display-4 mb-1"></i>
                        <h6 class="card-title mb-1">Interventions</h6>
                        <p class="h4 mb-0">{{ $nombreIntervention }}</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-3">
            <a href="{{ route('techniciens.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 text-dark stat-card" style="background-color: #ffca28;">
                    <div class="card-body text-center p-2">
                        <i class="bi bi-person-badge display-4 mb-1"></i>
                        <h6 class="card-title mb-1">Techniciens</h6>
                        <p class="h4 mb-0">{{ $nombreTechniciens }}</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-3">
            <a href="{{ route('equipements.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 text-white stat-card" style="background-color: #d32f2f;">
                    <div class="card-body text-center p-2">
                        <i class="bi bi-exclamation-triangle display-4 mb-1"></i>
                        <h6 class="card-title mb-1">En panne</h6>
                        <p class="h4 mb-0">{{ $nombreEquipementsEnPanne }}</p>
                    </div>
                </div>
            </a>
        </div>

    </div>

    {{-- ====== Row 2 : Actifs numériques ====== --}}
    <div class="row g-3 mt-3">

        <div class="col-6 col-md-4">
            <a href="{{ route('actifs-numeriques.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 text-white stat-card" style="background-color: #6c757d;">
                    <div class="card-body text-center p-2">
                        <i class="bi bi-cloud-arrow-down-fill display-4 mb-1"></i>
                        <h6 class="card-title mb-1">Actifs numériques</h6>
                        <p class="h4 mb-0">{{ $nombreActifsNumeriques }}</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4">
            <a href="{{ route('actifs-numeriques.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 text-white stat-card" style="background-color: #d32f2f;">
                    <div class="card-body text-center p-2">
                        <i class="bi bi-clock-history display-4 mb-1"></i>
                        <h6 class="card-title mb-1">Expirés</h6>
                        <p class="h4 mb-0">{{ $actifsExpirés }}</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4">
            <a href="{{ route('actifs-numeriques.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-3 text-dark stat-card" style="background-color: #ffca28;">
                    <div class="card-body text-center p-2">
                        <i class="bi bi-hourglass-split display-4 mb-1"></i>
                        <h6 class="card-title mb-1">Expire bientôt</h6>
                        <p class="h4 mb-0">{{ $actifsBientotExpirés }}</p>
                    </div>
                </div>
            </a>
        </div>

    </div>

    {{-- ====== Row 3 : Graphiques ====== --}}
    <div class="row g-3 mt-3">

        <div class="col-md-6">
            <div class="card shadow-sm rounded-3 p-2">
                <h6 class="card-title text-center mb-2">Interventions par mois</h6>
                <canvas id="interventionsChart" height="120"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm rounded-3 p-2">
                <h6 class="card-title text-center mb-2">Répartition des actifs numériques</h6>
                <canvas id="actifsChart" height="120"></canvas>
            </div>
        </div>

    </div>

    {{-- ====== Row 4 : Tableaux ====== --}}
    <div class="mt-4">

        <h6 class="text-success fw-bold mb-2">Interventions par technicien</h6>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th>Technicien</th>
                        <th>Nombre d'interventions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($interventionsParTechnicien as $tech)
                        <tr>
                            <td>{{ $tech->name }}</td>
                            <td>{{ $tech->interventions_count }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center">Aucun technicien trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h6 class="text-success fw-bold mt-4 mb-2">Top 5 équipements les plus souvent en panne</h6>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-danger">
                    <tr>
                        <th>Équipement</th>
                        <th>Nombre de pannes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($equipementsPannes as $equip)
                        <tr>
                            <td>{{ $equip->nom }}</td>
                            <td>{{ $equip->panne_count }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center">Aucun équipement trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

{{-- Styles cartes --}}
<style>
    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }
    .stat-card:hover, .stat-card:focus-visible {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
        outline: none;
    }
    .stat-card i {
        transition: transform 0.2s ease;
    }
    .stat-card:hover i {
        transform: scale(1.1) rotate(8deg);
    }
</style>

{{-- Scripts Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Interventions par mois
    const ctx1 = document.getElementById('interventionsChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: @json($mois),
            datasets: [{
                label: 'Interventions',
                data: @json($interventionsParMois),
                borderColor: '#004d40',
                backgroundColor: 'rgba(0, 77, 64, 0.2)',
                fill: true,
                tension: 0.3,
                pointRadius: 5,
                pointHoverRadius: 7,
                borderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top', labels: { font: { size: 12, weight: 'bold' } } },
                tooltip: { enabled: true, mode: 'nearest', intersect: false }
            },
            scales: {
                y: { beginAtZero: true, stepSize: 5, grid: { color: '#e0e0e0' } },
                x: { grid: { color: '#f5f5f5' } }
            }
        }
    });

    // Répartition actifs numériques
    const ctx2 = document.getElementById('actifsChart').getContext('2d');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: @json($repartitionActifs->pluck('type')),
            datasets: [{
                data: @json($repartitionActifs->pluck('total')),
                backgroundColor: ['#004d40','#6BA539','#ffca28','#d32f2f','#6f42c1']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 12 } } },
                tooltip: { enabled: true }
            }
        }
    });
});
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
