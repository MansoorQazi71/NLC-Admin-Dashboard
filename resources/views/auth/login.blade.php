<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary">
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <form method="POST" action="{{ route('login.attempt') }}" class="card border-0 shadow-sm rounded-4 p-4" style="max-width: 460px; width:100%;">
        @csrf
        <div class="mb-3">
            <h1 class="h3 fw-bold">Connexion administrateur</h1>
            <p class="text-muted mb-0">Connectez-vous pour acceder au dashboard.</p>
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input id="email" name="email" type="email" class="form-control form-control-lg rounded-3" value="{{ old('email') }}" required>
            @error('email') <p class="text-danger small mt-1 mb-0">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="password">Mot de passe</label>
            <input id="password" name="password" type="password" class="form-control form-control-lg rounded-3" required>
        </div>
        <label class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" value="1">
            Se souvenir de moi
        </label>
        <button class="btn btn-primary btn-lg rounded-pill w-100">Se connecter</button>
    </form>
</div>
</body>
</html>
