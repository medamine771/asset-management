@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container mt-5">

    {{-- Titre principal --}}
    <h1 class="mb-4 text-success fw-bold" style="letter-spacing: 1.5px;">
        Tableau de bord
    </h1>

    {{-- Section cartes statistiques --}}
    <div class="row g-4">

        {{-- Carte : Nombre d'équipements --}}
        <div class="col-md-4">
            <a href="{{ route('equipements.index') }}" class="text-decoration-none" aria-label="Voir la liste des équipements">
                <div 
                    class="card shadow-sm border-0 rounded-4 text-white stat-card"
                    style="background-color: #004d40;"
                    title="Nombre total d'équipements enregistrés"
                >
                    <div class="card-body text-center">
                        <i class="bi bi-hdd-network display-3 mb-3"></i>
                        <h5 class="card-title">Nombre d'équipements</h5>
                        <p class="display-4 mb-0">{{ $nombreEquipements }}</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Carte : Nombre d'interventions --}}
        <div class="col-md-4">
            <a href="{{ route('interventions.index') }}" class="text-decoration-none" aria-label="Voir la liste des interventions">
                <div 
                    class="card shadow-sm border-0 rounded-4 text-white stat-card"
                    style="background-color: #6BA539;"
                    title="Nombre total d'interventions réalisées"
                >
                    <div class="card-body text-center">
                        <i class="bi bi-tools display-3 mb-3"></i>
                        <h5 class="card-title">Nombre d'interventions</h5>
                        <p class="display-4 mb-0">{{ $nombreIntervention }}</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Carte : Nombre de techniciens --}}
        <div class="col-md-4">
            <a href="{{ route('techniciens.index') }}" class="text-decoration-none" aria-label="Voir la liste des techniciens">
                <div 
                    class="card shadow-sm border-0 rounded-4 text-dark stat-card"
                    style="background-color: #ffca28;"
                    title="Voir la liste des techniciens"
                >
                    <div class="card-body text-center">
                        <i class="bi bi-person-badge display-3 mb-3"></i>
                        <h5 class="card-title">Nombre de techniciens</h5>
                        <p class="display-4 mb-0">{{ $nombreTechniciens }}</p>
                    </div>
                </div>
            </a>
        </div>
        
    </div>
    {{-- Fin cartes --}}

    {{-- Section graphique (exemple interventions mensuelles) --}}
    <div class="mt-5">
        <h2 class="text-success fw-bold mb-3">Statistiques mensuelles des interventions</h2>
        <canvas id="interventionsChart" height="130" aria-label="Graphique des interventions mensuelles" role="img"></canvas>
    </div>

</div>

{{-- Styles personnalisés --}}
<style>
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }
    .stat-card:hover, .stat-card:focus-visible {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 16px 30px rgba(0, 0, 0, 0.3);
        outline: none;
    }
    .stat-card i {
        transition: transform 0.3s ease;
    }
    .stat-card:hover i {
        transform: scale(1.15) rotate(10deg);
    }
</style>

{{-- Librairie Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('interventionsChart').getContext('2d');

    // Données dynamiques venant du backend Laravel
    const labels = {!! json_encode($mois ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!};
    const dataValues = {!! json_encode($interventionsParMois ?? [10, 15, 12, 18, 20, 22]) !!};

    // Configuration graphique
    const config = {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Interventions',
                data: dataValues,
                borderColor: '#004d40',
                backgroundColor: 'rgba(75, 192, 192, 0.3)',
                fill: true,
                tension: 0.35,
                pointRadius: 6,
                pointHoverRadius: 9,
                borderWidth: 4,
                hoverBorderWidth: 5,
                hoverBackgroundColor: '#00796b66',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: 'top', labels: { font: { size: 14, weight: 'bold' } } },
                tooltip: { enabled: true, mode: 'nearest', intersect: false }
            },
            scales: {
                y: { beginAtZero: true, stepSize: 5, grid: { color: '#e0e0e0' } },
                x: { grid: { color: '#f5f5f5' } }
            }
        }
    };

    // Création du graphique
    new Chart(ctx, config);
});
</script>
@endsection
