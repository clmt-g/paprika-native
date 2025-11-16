<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier l'utilisateur</title>
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
        input, select {
            margin-bottom: 1rem;
        }
        input:disabled, select:disabled {
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
        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }
    </style>
</head>
<body>

<main>
    <div class="card p-4 fade-in">
        <div class="text-center">
            <h2 class="fw-bold text-danger mb-0">
                <i class="bi bi-person-gear"></i>
                Modifier l'utilisateur
            </h2>
            <hr>
        </div>

        <form method="POST" action="/users/update/{{ $user->getId() }}" class="px-3">
            <div class="row">
                <div class="col-md-6">
                    <label for="id">ID</label>
                    <input type="text" id="id" name="id" class="form-control" value="{{ $user->getId() }}" readonly>

                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" class="form-control" value="{{ $user->getNom() }}" required>

                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" class="form-control" value="{{ $user->getPrenom() }}" required>
                </div>

                <div class="col-md-6">
                    <label for="login">Login</label>
                    <input type="text" id="login" name="login" class="form-control" value="{{ $user->getLogin() }}" required>

                    <label for="role">Rôle</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="default" {{ $user->getRole() == 'default' ? 'selected' : '' }}>Default</option>
                        <option value="secretaire" {{ $user->getRole() == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                        <option value="admin" {{ $user->getRole() == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>

                    <input type="hidden" id="token" name="token" value="{{ $token }}">
                </div>
            </div>

            <div class="alert alert-info mt-3" role="alert">
                <i class="bi bi-info-circle"></i>
                <strong>Note :</strong> Le mot de passe ne peut pas être modifié via ce formulaire.
                Utilisez la fonction <a href="/users/update-password/{{ $user->getId() }}">"Modifier le mot de passe"</a> si nécessaire.
            </div>

            <div class="text-center mt-4">
                <a href="/users/show" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-save"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
