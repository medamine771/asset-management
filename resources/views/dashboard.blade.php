@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-success fw-bold" style="letter-spacing: 1.5px;">Tableau de bord</h1>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-white" style="background-color: #004d40;">
                <div class="card-body text-center">
                    <h5 class="card-title">Nombre d'équipements</h5>
                    <p class="display-4">{{ $nombreEquipements }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-white" style="background-color: #6BA539;">
                <div class="card-body text-center">
                    <h5 class="card-title">Nombre d'interventions</h5>
                    <p class="display-4">{{ $nombreIntervention }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-white" style="background-color: #ffca28;">
                <div class="card-body text-center" style="color: #004d40;">
                    <h5 class="card-title">Nombre de techniciens</h5>
                    <p class="display-4">{{ $nombreTechniciens }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
