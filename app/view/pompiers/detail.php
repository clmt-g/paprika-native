<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détail du pompier</title>
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
        .input-group .btn {
            border: 1px solid #dee2e6;
            color: var(--rouge-paprika);
            transition: all 0.2s ease;
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
        }
        .input-group .btn:hover {
            background-color: var(--rouge-paprika);
            color: white;
            transform: translateY(-2px);
        }
        .caserne-link {
            display: block;
            padding: 0.375rem 0.75rem;
            background-color: #f5f5f5;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            color: #555;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 1rem;
        }
        .caserne-link:hover {
            background-color: #efefef;
            color: var(--rouge-paprika);
            border-color: var(--rouge-paprika);
            transform: translateY(-2px);
    </style>
</head>
<body>

<main>
    <div class="card p-4 fade-in">
        <div class="text-center">
            <h2 class="fw-bold text-danger mb-0">Détails du pompier</h2>
            <hr>
        </div>

        <form class="px-3">
            <div class="row">
                <div class="col-md-6">
                    <label for="matricule">Matricule</label>
                    <input type="text" id="matricule" class="form-control" value="{{ $pompier->getMatricule() }}" disabled>

                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" class="form-control" value="{{ $pompier->getPrenom() }}" disabled>

                    <label for="chefAgret">Chef d'agrès</label>
                    <select id="chefAgret" class="form-select" disabled>
                        <option value="O" {{ $pompier->getChefAgret() == 'O' ? 'selected' : '' }}>Oui</option>
                        <option value="N" {{ $pompier->getChefAgret() == 'N' ? 'selected' : '' }}>Non</option>
                    </select>
                    <input type="hidden" name="chefAgret" value="{{ $pompier->getChefAgret() }}">

                    <label for="numCaserne">Caserne</label>
                    <a href="/caserne/show/detail/{{ $pompier->getNumCaserne() }}" class="caserne-link">
                        Caserne n°{{ $pompier->getNumCaserne() }}
                    </a>
                </div>

                <div class="col-md-6">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" class="form-control" value="{{ $pompier->getNom() }}" disabled>

                    <label for="dateNaissance">Date de naissance</label>
                    <input type="date" id="dateNaissance" class="form-control" value="{{ $pompier->getDateNaissance() }}" disabled>

                    <label for="codeGrade">Code grade</label>
                    <input type="text" id="codeGrade" class="form-control" value="{{ $pompier->getCodeGrade() }}" disabled>

                    <label for="matriculeRespo">Matricule du responsable</label>
                    <input type="text" id="matriculeRespo" class="form-control" value="{{ $pompier->getMatriculeRespo() }}" disabled>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="/pompiers/show/" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                <a href="/pompiers/update/{{ $pompier->getMatricule() }}" class="btn btn-danger">
                    <i class="bi bi-pencil"></i> Modifier ce pompier
                </a>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>