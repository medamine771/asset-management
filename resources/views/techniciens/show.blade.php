@extends('layouts.app')

@section('title', 'Détails du technicien')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-dark fw-bold" style="letter-spacing: 1.2px;">Détails du technicien</h1>

    <div class="card shadow-lg mx-auto p-4" style="max-width: 540px; border-radius: 20px; background: #fff;">
        <div class="d-flex flex-column align-items-center mb-4">
            @if($technicien->image)
                <img src="{{ asset('storage/' . $technicien->image) }}" 
                     alt="Photo de {{ $technicien->name }}" 
                     class="rounded-circle profile-photo" 
                     style="width: 150px; height: 150px; object-fit: cover; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
            @else
                <img src="{{ asset('images/default-avatar.png') }}" 
                     alt="Pas de photo" 
                     class="rounded-circle profile-photo" 
                     style="width: 150px; height: 150px; object-fit: cover; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
            @endif
        </div>

        <h2 class="text-center fw-bold mb-4">{{ $technicien->name }}</h2>

        <div class="row text-secondary fs-6 mb-4">
            <div class="col-6 mb-3 d-flex align-items-center">
                <i class="bi bi-envelope-fill text-primary me-2 fs-5"></i>
                <span>{{ $technicien->email }}</span>
            </div>
            <div class="col-6 mb-3 d-flex align-items-center">
                <i class="bi bi-person-badge-fill text-primary me-2 fs-5"></i>
                <span class="text-capitalize">{{ $technicien->role }}</span>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('techniciens.index') }}" 
               class="btn btn-outline-dark ripple" 
               data-bs-toggle="tooltip" 
               data-bs-placement="top" 
               title="Retour à la liste"
               aria-label="Retour à la liste">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>

            <a href="{{ route('techniciens.edit', $technicien->id) }}" 
               class="btn btn-primary ripple" 
               data-bs-toggle="tooltip" 
               data-bs-placement="top" 
               title="Modifier"
               aria-label="Modifier">
                <i class="bi bi-pencil-square fs-5"></i>
            </a>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));

        // Ripple effect on buttons
        document.querySelectorAll('.ripple').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const circle = document.createElement('span');
                circle.classList.add('ripple-effect');
                this.appendChild(circle);

                const max = Math.max(this.clientWidth, this.clientHeight);
                circle.style.width = circle.style.height = max + 'px';
                const rect = this.getBoundingClientRect();
                circle.style.left = (e.clientX - rect.left - max / 2) + 'px';
                circle.style.top = (e.clientY - rect.top - max / 2) + 'px';

                setTimeout(() => circle.remove(), 600);
            });
        });
    });
</script>

<style>
    /* Photo vignette hover */
    .profile-photo {
        transition: filter 0.3s ease;
    }
    .profile-photo:hover {
        filter: brightness(0.85) saturate(1.2);
        cursor: pointer;
    }

    /* Ripple effect */
    .ripple {
        position: relative;
        overflow: hidden;
    }
    .ripple-effect {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
        transform: scale(0);
    }
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Buttons style */
    .btn-outline-dark {
        width: 44px;
        height: 44px;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        font-size: 1.25rem;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    .btn-outline-dark:hover {
        background-color: #212529;
        color: #fff;
    }
    .btn-primary {
        width: 44px;
        height: 44px;
        padding: 0;
        border-radius: 50%;
        font-size: 1.25rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
@endsection
