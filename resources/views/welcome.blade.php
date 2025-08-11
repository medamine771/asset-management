{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue - OCP Asset Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Slideshow */
        .slideshow {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            overflow: hidden;
        }
        .slideshow img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            animation: fade 18s infinite;
            opacity: 0;
        }
        .slideshow img:nth-child(1) { animation-delay: 0s; }
        .slideshow img:nth-child(2) { animation-delay: 6s; }
        .slideshow img:nth-child(3) { animation-delay: 12s; }

        @keyframes fade {
            0% { opacity: 0; }
            8% { opacity: 1; }
            33% { opacity: 1; }
            41% { opacity: 0; }
            100% { opacity: 0; }
        }

        /* Overlay sombre */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.55);
            z-index: -1;
        }

        /* Contenu */
        .welcome-content {
            background: rgba(255, 255, 255, 0.92);
            padding: 50px 40px;
            border-radius: 15px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0px 5px 30px rgba(0,0,0,0.3);
            animation: fadeIn 1.5s ease-in-out;
            position: relative;
            transition: transform 0.2s ease-out;
        }

        /* Animation apparition */
        @keyframes fadeIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Bouton OCP */
        .btn-ocp {
            background-color: #6BA539;
            border: none;
            padding: 12px 25px;
            font-size: 1.1rem;
            font-weight: bold;
            color: white;
            border-radius: 50px;
            transition: background-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .btn-ocp:hover {
            background-color: #5a8f2f;
            box-shadow: 0 0 15px rgba(106, 165, 57, 0.8);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">

    <!-- Slideshow -->
    <div class="slideshow">
        <img src="{{ asset('images/ocp1.jpg') }}" alt="OCP Image 1">
        <img src="{{ asset('images/ocp2.jpg') }}" alt="OCP Image 2">
        <img src="{{ asset('images/ocp3.jpg') }}" alt="OCP Image 3">
    </div>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Contenu -->
    <div class="welcome-content text-center" id="welcomeCard">
        <img src="{{ asset('images/ocp-logo.png') }}" alt="OCP Logo" class="mb-4" style="max-width: 120px;">
        <h1 class="fw-bold text-success mb-3">Bienvenue sur OCP Asset Management</h1>
        <p class="lead text-muted">
            Optimisez la gestion, le suivi et la maintenance de vos actifs industriels et informatiques.
        </p>
        <a href="{{ route('login') }}" class="btn btn-ocp mt-4">Se connecter</a>
        <p class="mt-4 text-secondary small">Projet réalisé dans le cadre du stage OCP 2025</p>
    </div>

    <!-- Script pour effets souris -->
    <script>
        const card = document.getElementById('welcomeCard');

        document.addEventListener('mousemove', (e) => {
            let x = (window.innerWidth / 2 - e.pageX) / 40;
            let y = (window.innerHeight / 2 - e.pageY) / 40;
            card.style.transform = `rotateY(${x}deg) rotateX(${y}deg)`;
        });

        document.addEventListener('mouseleave', () => {
            card.style.transform = 'rotateY(0deg) rotateX(0deg)';
        });
    </script>

</body>
</html>
