@extends('layouts.app')

@section('title', 'Catégories')

@push('styles')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .table {
        border-collapse: separate;
        border-spacing: 0;
    }
    .table thead th {
        border-bottom: 1px solid #dee2e6;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    .table tbody tr {
        transition: all 0.3s ease;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .btn-sm {
        padding: 0.35rem 0.75rem;
        font-size: 0.825rem;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 text-dark">Catégories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Ajouter une catégorie
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Nom</th>
                        <th class="text-end pe-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $categorie)
                        <tr>
                            <td class="ps-4 align-middle">{{ $categorie->nom }}</td>
                            <td class="text-end pe-4">
                                <div class="d-inline-flex">
                                    <a href="{{ route('categories.edit', $categorie) }}" 
                                       class="btn btn-sm btn-outline-primary me-2">
                                        <i class="far fa-edit me-1"></i>Modifier
                                    </a>
                                    <form action="{{ route('categories.destroy', $categorie) }}" 
                                          method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="far fa-trash-alt me-1"></i>Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle me-2"></i>Aucune catégorie trouvée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">
    <a href="{{ route('dashboard') }}" 
       class="btn btn-outline-dark ripple" 
       title="Retour au tableau de bord">
        <i class="bi bi-arrow-left fs-5"></i>
    </a>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Confirmation suppression
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Confirmer la suppression',
                text: "Êtes-vous sûr de vouloir supprimer cette catégorie ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if(result.isConfirmed) {
                    // Animation avant suppression
                    const row = form.closest('tr');
                    row.style.opacity = 0;
                    row.style.transition = 'all 0.3s ease';
                    setTimeout(() => form.submit(), 300); // submit après animation
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
