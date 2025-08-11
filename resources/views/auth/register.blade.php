
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inscription - OCP Équipements</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 70px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 450px;
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            margin-top: 50px;
        }

        h1 {
            color: #004d40; /* vert OCP */
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 1.5px;
        }

        .form-control:focus {
            border-color: #ffca28;
            box-shadow: 0 0 8px #ffca28;
        }

        select.form-select {
            border-color: #004d40;
        }

        select.form-select:focus {
            border-color: #ffca28;
            box-shadow: 0 0 8px #ffca28;
        }

        .btn-ocp {
            background-color: #004d40;
            color: #ffca28;
            font-weight: 600;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .btn-ocp:hover {
            background-color: #00695c;
            color: white;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c2c7;
            color: #842029;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        a.login-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #004d40;
            font-weight: 600;
            text-decoration: none;
        }
        a.login-link:hover {
            color: #ffca28;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Créer un compte</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <input type="text" name="name" placeholder="Nom" class="form-control" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="mb-3">
            <input type="email" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" placeholder="Mot de passe" class="form-control" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password_confirmation" placeholder="Confirmer mot de passe" class="form-control" required>
        </div>

        <div class="mb-4">
            <select name="role" class="form-select" required>
                <option value="" disabled selected>Choisissez un rôle</option>
                <option value="technicien" {{ old('role') == 'technicien' ? 'selected' : '' }}>Technicien</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-ocp">S'inscrire</button>
    </form>

    <a href="{{ route('login.form') }}" class="login-link">Déjà inscrit ? Se connecter</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
