<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détail de l'utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --rouge-paprika: #b22222;
            --rouge-fonce: #8b1a1a;
            --gris-fond: #f8f9fa;
        }
        body {
            background-color: var(--gris-fond);
            overflow-x: hidden;
        }
        main {
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: translateY(-3px);
        }
        label {
            font-weight: 600;
            color: var(--rouge-fonce);
        }
        input {
            margin-bottom: 1rem;
        }
        input:disabled {
            background-color: #f5f5f5;
            color: #555;
        }
        .btn-danger {
            background-color: var(--rouge-paprika);
            border: none;
            transition: transform 0.2s ease;
        }
        .btn-danger:hover {
            background-color: var(--rouge-fonce);
            transform: translateY(-2px);
        }
        .btn-secondary {
            transition: transform 0.2s ease;
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
<main>
    <div class="card p-4 fade-in">
        <div class="text-center">
            <h2 class="fw-bold text-danger mb-0">Détails de l'utilisateur</h2>
            <hr>
        </div>

        <form class="px-3">
            <div class="row">
                <div class="col-md-6">
                    <label for="id">ID</label>
                    <input type="text" id="id" class="form-control" value="{{ $user->getId() }}" disabled>

                    <label for="login">Login</label>
                    <input type="text" id="login" class="form-control" value="{{ $user->getLogin() }}" disabled>

                    <label for="role">Rôle</label>
                    <input type="text" id="role" class="form-control" value="{{ $user->getRole() }}" disabled>
                </div>

                <div class="col-md-6">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" class="form-control" value="{{ $user->getNom() }}" disabled>

                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" class="form-control" value="{{ $user->getPrenom() }}" disabled>
                </div>
            </div>

            <div class="text-center mt-4">
                @if(Auth::can('user_show'))
                <a href="/users/show/" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                @else
                <a href="/" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                @endif
                @if(Auth::can('user_update'))
                <a href="/users/update/{{ $user->getId() }}" class="btn btn-danger me-2">
                    <i class="bi bi-pencil"></i> Modifier l'utilisateur
                </a>
                @endif
                <!-- access control : déjà gérer dans le routeur et les controlleur -->
                <a href="/users/update-password/{{ $user->getId() }}" class="btn btn-warning">
                    <i class="bi bi-key"></i> Modifier le mot de passe
                </a>
            </div>
        </form>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
