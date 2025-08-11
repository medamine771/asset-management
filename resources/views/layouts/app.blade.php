<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestion des équipements - @yield('title')</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            padding-top: 70px;
            background-color: #f8f9fa;
        }

        /* Navbar OCP style */
        .navbar-ocp {
            background: linear-gradient(90deg, #004d40, #00695c); /* nuances de vert OCP */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-ocp .navbar-brand {
            font-weight: 700;
            color: #ffca28 !important; /* jaune/or pour contraste */
            font-size: 1.5rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .navbar-ocp .nav-link {
            color: #b2dfdb !important; /* vert clair */
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .navbar-ocp .nav-link:hover,
        .navbar-ocp .nav-link:focus {
            color: #ffca28 !important; /* jaune/or au survol */
            text-decoration: underline;
        }

        .btn-logout {
            color: #b2dfdb;
            font-weight: 500;
            padding: 0;
            border: none;
            background: none;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .btn-logout:hover {
            color: #ffca28;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-ocp fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">OCP - Équipements</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span> 
                {{-- Inverse l’icône pour que ça contraste --}}
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('equipements.index') }}">Équipements</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('categories.index') }}">Catégories</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('emplacements.index') }}">Emplacements</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('interventions.index') }}">Interventions</a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-logout nav-link">
                                    Déconnexion
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container my-4">
        @if(session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>
</html>
