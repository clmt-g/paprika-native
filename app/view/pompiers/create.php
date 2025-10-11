<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détail du pompier - Paprika</title>
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
    </style>
</head>
<body>

<main>
    <div class="card p-4 fade-in">
        <div class="text-center">
            <h2 class="fw-bold text-danger mb-0">Créer un nouveau Pompier</h2>
            <hr>
        </div>

        <form class="px-3">
            <div class="row">
                <div class="col-md-6">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" class="form-control" required>

                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" class="form-control" required>

                    <label for="chefAgret">Chef d'agrès</label>
                    <select id="chefAgret" class="form-select" required>
                        <option value="N">Non</option>
                        <option value="O">Oui</option>
                    </select>

                    <!-- FIXME : liste des casernes existantes -->
                    <label for="numCaserne">Caserne</label>
                    <input type="text" id="numCaserne" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="dateNaissance">Date de naissance</label>
                    <input type="date" id="dateNaissance" class="form-control" required>

                    <label for="codeGrade">Code grade</label>
                    <input type="text" id="codeGrade" class="form-control" required>

                    <label for="matriculeRespo">Matricule du responsable</label>
                    <input type="text" id="matriculeRespo" class="form-control" required>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="/pompiers/show/" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                <a href="#" class="btn btn-danger">
                    <i class="bi bi-pencil"></i> Créer ce pompier
                </a>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>