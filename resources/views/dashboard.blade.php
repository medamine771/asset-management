@extends('layouts.app') {{-- si tu utilises Laravel UI ou Breeze --}}

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    {{-- <p>Bienvenue {{ Auth::user()->name }} 👋</p> --}}

    {{-- Exemple : afficher des stats --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h5>Total équipements</h5>
                <p>{{ $nombreEquipements }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h5>Interventions en cours</h5>
                <p>{{ $nombreIntervention }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
