<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestion des équipements - @yield('title')</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Segoe UI", sans-serif;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #004d40, #00695c);
            color: #fff;
            padding-top: 20px;
            transition: all 0.3s;
        }

        .sidebar .brand {
            font-weight: 700;
            font-size: 1.3rem;
            text-align: center;
            padding: 15px 0;
            color: #ffca28;
            text-transform: uppercase;
        }

        .sidebar .nav-link {
            color: #b2dfdb;
            font-weight: 500;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            transition: 0.3s;
        }

        .sidebar .nav-link:hover {
            color: #ffca28;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .sidebar .logout-btn {
            color: #e57373;
            font-weight: 600;
            padding: 10px 20px;
            border: none;
            background: none;
            text-align: left;
            width: 100%;
        }
        .sidebar .logout-btn:hover {
            color: #ff5252;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        /* Badge messages */
        .nav-badge {
            font-size: 0.65rem;
            font-weight: bold;
            color: #fff;
            background-color: #dc3545;
            border-radius: 50%;
            padding: 2px 6px;
            margin-left: 5px;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">OCP - Équipements</div>
        <ul class="nav flex-column mt-3">
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('equipements.index') }}">
                            <i class="bi bi-tools"></i> Équipements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">
                            <i class="bi bi-tags"></i> Catégories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('emplacements.index') }}">
                            <i class="bi bi-geo-alt-fill"></i> Emplacements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('interventions.index') }}">
                            <i class="bi bi-wrench-adjustable"></i> Interventions
                        </a>
                    </li>
                @endif

                {{-- Messages --}}
                <li class="nav-item">
                    @php
                        $unreadCount = \App\Models\Message::where('receiver_id', Auth::id())
                                        ->where('read', false)->count();
                    @endphp
                    <a class="nav-link" href="{{ route('messages.inbox') }}">
                        <i class="bi bi-envelope-fill"></i> Messages
                        @if($unreadCount > 0)
                            <span class="nav-badge">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>

                {{-- Déconnexion --}}
                <li class="nav-item mt-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                        </button>
                    </form>
                </li>
            @endauth
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>
</html>
