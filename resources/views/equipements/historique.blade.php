{{-- resources/views/equipements/historique.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container my-5">

    <!-- Titre avec style -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">
            <i class="bi bi-clock-history me-2"></i> Historique des interventions
        </h1>
        <span class="badge bg-secondary fs-6">{{ $equipement->nom }}</span>
    </div>

    <!-- Carte -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Description</th>
                            <th>Technicien</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($interventions as $intervention)
                            <tr>
                                <td class="text-wrap" style="max-width: 300px;">
                                    {{ $intervention->description }}
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $intervention->technicien->name ?? 'Non assigné' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'en attente' => 'warning',
                                            'en cours' => 'primary',
                                            'terminée' => 'success',
                                            'annulée' => 'danger'
                                        ];
                                        $color = $statusColors[strtolower($intervention->statut)] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }}">
                                        {{ ucfirst($intervention->statut) }}
                                    </span>
                                </td>
                                <td>
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ $intervention->date_intervention?->format('d/m/Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="bi bi-exclamation-circle me-2"></i>
                                    Aucune intervention trouvée pour cet équipement.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
