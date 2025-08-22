{{-- resources/views/login.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - OCP Asset Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #6BA539, #4e8b2b);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            width: 400px;
            padding: 40px 30px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.25);
            animation: fadeIn 0.7s ease-in-out;
        }

        .login-card img {
            max-width: 90px;
            transition: transform 0.3s ease;
        }
        .login-card img:hover {
            transform: scale(1.08);
        }

        .login-card h4 {
            color: #6BA539;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Animation */
        @keyframes fadeIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Bouton OCP */
        .btn-ocp {
            background: linear-gradient(135deg, #6BA539, #5a8f2f);
            color: #fff;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-ocp:hover {
            background: linear-gradient(135deg, #5a8f2f, #4e8b2b);
            box-shadow: 0 0 12px rgba(106, 165, 57, 0.6);
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
</head>
<body>

    <div class="login-card text-center">
        <img src="{{ asset('images/ocp-logo.png') }}" alt="OCP Logo" class="mb-3">
        <h4 class="mb-4">Connexion</h4>

        @if ($errors->any())
            <div class="alert alert-danger text-center py-2">
                Identifiants incorrects.
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3 text-start">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-semibold">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-ocp w-100 py-2">
                Se connecter
            </button>
        </form>

        <div class="mt-3">
            <a href="{{ route('register.form') }}" class="link-ocp">
                Créer un compte
            </a>
        </div>
    </div>

</body>
</html>
