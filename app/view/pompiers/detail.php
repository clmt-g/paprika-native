<!-- FIXME : est ce qu'on garde la photo, et si oui, ajouter la posibilité de mettre une photo -->

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
        header {
            background: linear-gradient(90deg, var(--rouge-paprika), #e44d4d);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        header .logo {
            width: 181px;
            height: 40px;
            object-fit: scale-down;
            margin-right: -75px;
            vertical-align: middle;
        }
        header h1 {
            display: inline-block;
            vertical-align: middle;
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
        }
        .sidebar {
            background-color: #2b2b2b;
            min-height: 100vh;
            padding-top: 1rem;
            color: white;
        }
        .sidebar a {
            color: #ddd;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            transition: background 0.2s, transform 0.2s;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: var(--rouge-paprika);
            color: white;
            transform: translateX(4px);
        }
        main {
            padding: 2rem;
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
        footer {
            background: linear-gradient(90deg, var(--rouge-paprika), #e44d4d);
            color: #fff;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            margin-top: 3rem;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--rouge-paprika);
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<header class="text-center">
    <div class="container d-flex flex-column align-items-center">
        <div class="d-flex align-items-center justify-content-center mb-2">
            <img src="/assets/imagepap.png" alt="Logo Paprika" class="logo">
            <h1>Paprika</h1>
        </div>
        <p class="lead mb-0">Fiche détaillée du pompier</p>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-2 sidebar">
            <a href="/">
                <i class="bi bi-speedometer2"></i> Tableau de bord
            </a>
            <a href="/caserne/show">
                <i class="bi bi-building"></i> Casernes
            </a>
            <a href="/pompiers/show" class="active">
                <i class="bi bi-people"></i> Pompiers
            </a>
        </aside>

        <!-- Contenu principal -->
        <main class="col-md-10">
            <div class="card p-4 fade-in">
                <div class="text-center">
                    <img src="/assets/pompier.png" alt="Photo pompier" class="profile-avatar">
                    <h2 class="fw-bold text-danger mb-0">{{ $pompier->getPrenom() }} {{ $pompier->getNom() }}</h2>
                    <p class="text-muted">Grade : <span class="fw-semibold">{{ $pompier->getCodeGrade() ?? $pompier->getCodeGrade() }}</span></p>
                    <hr>
                </div>

                <form class="px-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="matricule">Matricule</label>
                            <input type="text" id="matricule" class="form-control" value="{{ $pompier->getMatricule() }}" disabled>

                            <label for="chefAgret">Chef d’agrès</label>
                            <select id="chefAgret" class="form-select" disabled>
                                <option value="0" {{ $pompier->getChefAgret() == 0 ? 'selected' : '' }}>Non</option>
                                <option value="1" {{ $pompier->getChefAgret() == 1 ? 'selected' : '' }}>Oui</option>
                            </select>

                            <label for="numCaserne">Caserne</label>
                            <input type="text" id="numCaserne" class="form-control"
                                   value="{{ 'Caserne n°'.$pompier->getNumCaserne() }}" disabled>
                        </div>

                        <div class="col-md-6">
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
                        <a href="/pompier/update/{{ $pompier->getMatricule() }}" class="btn btn-danger">
                            <i class="bi bi-pencil"></i> Modifier ce pompier
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<footer>
    <p>&copy; 2025 Paprika – Gestion des casernes et pompiers. Créé avec ❤️ par Clément.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
