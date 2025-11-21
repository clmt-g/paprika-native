<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer un nouvel utilisateur</title>
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
            <h2 class="fw-bold text-danger mb-0">Créer un nouvel utilisateur</h2>
            <hr>
        </div>

        <form class="px-3" method="POST" action="/users/create">
            <div class="row">
                <div class="col-md-6">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" class="form-control" required>

                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" class="form-control" required>

                    <label for="login">Login</label>
                    <input type="text" id="login" name="login" class="form-control" required>

                    <label for="role">Rôle</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="">-- Choisir un rôle --</option>
                        <option value="default">Default</option>
                        <option value="secretaire">Secrétaire</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="passwd" class="form-control" required>

                    <!-- Barre segmentée -->
                    <div id="passwordStrengthWrapper" style="display: flex; gap: 4px; margin-top: 0.5rem; cursor: pointer; position: relative;">
                        <div class="strength-segment" style="flex:1; height:15px; background:#e0e0e0; border-radius:4px; transition: background 0.3s;"></div>
                        <div class="strength-segment" style="flex:1; height:15px; background:#e0e0e0; border-radius:4px; transition: background 0.3s;"></div>
                        <div class="strength-segment" style="flex:1; height:15px; background:#e0e0e0; border-radius:4px; transition: background 0.3s;"></div>
                        <div class="strength-segment" style="flex:1; height:15px; background:#e0e0e0; border-radius:4px; transition: background 0.3s;"></div>
                        <div class="strength-segment" style="flex:1; height:15px; background:#e0e0e0; border-radius:4px; transition: background 0.3s;"></div>

                        <!-- Tooltip -->
                        <div id="passwordTooltip" style="position:absolute; top:-130%; left:50%; transform:translateX(-50%); display:none; background:#fff; border:1px solid #ccc; padding:0.75rem; border-radius:8px; font-size:0.85rem; box-shadow:0 3px 8px rgba(0,0,0,0.25); z-index:100; width:max-content; max-width:250px;">
                            <ul style="margin:0; padding-left:1.2rem;">
                                <li>12 caractères minimum</li>
                                <li>Une lettre minuscule</li>
                                <li>Une lettre majuscule</li>
                                <li>Un chiffre</li>
                                <li>Un caractère spécial</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Token ou autre champ caché si nécessaire -->
                    <input type="hidden" name="token" value="{{ $token }}">
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="/users/show/" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-pencil"></i> Créer cet utilisateur
                </button>
            </div>
        </form>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const passwordInput = document.getElementById("password");
        const segments = document.querySelectorAll("#passwordStrengthWrapper .strength-segment");
        const tooltip = document.getElementById("passwordTooltip");
        const wrapper = document.getElementById("passwordStrengthWrapper");

        // Tooltip hover
        wrapper.addEventListener("mouseenter", () => tooltip.style.display = "block");
        wrapper.addEventListener("mouseleave", () => tooltip.style.display = "none");

        passwordInput.addEventListener("input", () => {
            const val = passwordInput.value;
            let score = 0;

            if(val.length >= 12) score++;
            if(/[a-z]/.test(val)) score++;
            if(/[A-Z]/.test(val)) score++;
            if(/[0-9]/.test(val)) score++;
            if(/[!@#$%^&*(),.?":{}|<>]/.test(val)) score++;

            segments.forEach((seg, index) => {
                if(index < score) seg.style.background = "green";
                else seg.style.background = "#e0e0e0";
            });
        });
    });
</script>
