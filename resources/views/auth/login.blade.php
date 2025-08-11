@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100" style="background: #f5f5f5;">
    <div class="card shadow-lg border-0" style="width: 400px; border-radius: 15px; animation: fadeIn 0.6s ease-in-out;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <img src="{{ asset('images/ocp-logo.png') }}" alt="OCP Logo" style="max-width: 90px;">
                <h4 class="fw-bold mt-3" style="color: #6BA539; letter-spacing: 1px;">Connexion</h4>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger text-center py-2">
                    Identifiants incorrects.
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-ocp w-100 py-2">
                    Se connecter
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('register.form') }}" class="link-ocp">
                    Créer un compte
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animation */
    @keyframes fadeIn {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Bouton OCP */
    .btn-ocp {
        background-color: #6BA539;
        color: #fff;
        font-weight: 600;
        border-radius: 50px;
        transition: background-color 0.3s ease;
        border: none;
    }
    .btn-ocp:hover {
        background-color: #5a8f2f;
    }

    /* Liens */
    .link-ocp {
        color: #6BA539;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .link-ocp:hover {
        color: #4e8b2b;
    }

    /* Champs focus */
    input.form-control:focus {
        border-color: #6BA539 !important;
        box-shadow: 0 0 6px rgba(107,165,57,0.6) !important;
    }
</style>
@endsection
