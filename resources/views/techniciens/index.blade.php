@extends('layouts.app')

@section('title', 'Liste des techniciens')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-success fw-bold" style="letter-spacing: 1.5px;">
        Liste des techniciens
    </h1>

    @if($techniciens->isEmpty())
        <div class="alert alert-warning">
            Aucun technicien trouvé.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-ocp text-white" style="background-color: #004d40;">
                    <tr>
                        <th>Photo</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th style="width: 140px; white-space: nowrap;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($techniciens as $tech)
                        <tr>
                            <td>
                                @if($tech->image)
                                    <img src="{{ asset('storage/' . $tech->image) }}" alt="Photo de {{ $tech->name }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}" alt="Pas de photo" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                @endif
                            </td>
                            <td>{{ $tech->name }}</td>
                            <td>{{ $tech->email }}</td>
                            <td>{{ ucfirst($tech->role) }}</td>
                            <td style="white-space: nowrap;">
                                <a href="{{ route('techniciens.show', $tech->id) }}" 
                                   class="btn btn-info btn-sm me-1" 
                                   title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('techniciens.edit', $tech->id) }}" 
                                   class="btn btn-warning btn-sm me-1" 
                                   title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('techniciens.destroy', $tech->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce technicien ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Supprimer" type="submit">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $techniciens->links() }}
        </div>
    @endif
    <div  class="d-flex justify-content-center gap-3">
        <a href="{{ route('dashboard') }}" 
        class="btn btn-outline-dark ripple" 
        data-bs-toggle="tooltip" 
        data-bs-placement="top" 
        title="Retour à la liste"
        aria-label="Retour à la liste">
         <i class="bi bi-arrow-left fs-5"></i>
     </a>
    </div>
</div>

<style>
    .table-ocp th {
        border: none;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }

    tbody tr:hover {
        background-color: #e6f4f1;
        transition: background-color 0.3s ease;
    }

    td {
        vertical-align: middle;
    }

    /* Empêche les boutons de passer à la ligne */
    td[style*="white-space: nowrap"] {
        white-space: nowrap;
    }

    .btn-sm {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        border-radius: 6px;
    }
</style>
@endsection
