<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des casernes - Paprika</title>
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
            border-radius: 15px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        table {
            border-radius: 10px;
            overflow: hidden;
        }
        thead {
            background-color: var(--rouge-paprika);
            color: white;
        }
        tbody tr:hover {
            background-color: #fff3f3;
            cursor: pointer;
        }
        footer {
            background: linear-gradient(90deg, var(--rouge-paprika), #e44d4d);
            color: #fff;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            margin-top: 3rem;
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
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .form-control:focus {
            border-color: var(--rouge-paprika);
            box-shadow: 0 0 0 0.2rem rgba(178, 34, 34, 0.25);
        }
    </style>
</head>
<body>

<header class="text-center">
    <div class="container d-flex flex-column align-items-center">
        <!-- 🖼️ Ton logo personnalisé -->
        <div class="d-flex align-items-center justify-content-center mb-2">
            <img src="/assets/imagepap.png" alt="Logo Paprika" class="logo">
            <h1>Paprika</h1>
        </div>
        <p class="lead mb-0">Gestion des casernes & des pompiers</p>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <aside class="col-md-2 sidebar">
            <a href="/" class="">
                <i class="bi bi-speedometer2"></i> Tableau de bord
            </a>
            <a href="/caserne/show" class="active">
                <i class="bi bi-building"></i> Casernes
            </a>
            <a href="/pompiers">
                <i class="bi bi-people"></i> Pompiers
            </a>
        </aside>

        <main class="col-md-10 fade-in">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-building"></i> Liste des casernes</h2>
                <a href="/caserne/add" class="btn btn-danger">
                    <i class="bi bi-plus-circle"></i> Ajouter une caserne
                </a>
            </div>

            <div class="input-group mb-3 w-50">
                <span class="input-group-text bg-danger text-white"><i class="bi bi-search"></i></span>
                <input type="text" id="searchCasernes" class="form-control" placeholder="Rechercher une caserne...">
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th>Numéro</th>
                            <th>Adresse</th>
                            <th>Code Postal</th>
                            <th>Ville</th>
                            <th>Type Caserne</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="tableCasernes">
                        @foreach($casernes as $c)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $c->getNumCaserne() }}</span></td>
                            <td>{{ $c->getAdresse() }}</td>
                            <td>{{ $c->getCp() }}</td>
                            <td><i class="bi bi-geo-alt text-danger"></i> {{ $c->getVille() }}</td>
                            <td><span class="badge bg-info">Type {{ $c->getCodeTypeC() }}</span></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/caserne/show/detail/{{ $c->getNumCaserne() }}"
                                       class="btn btn-outline-primary"
                                       title="Détails">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/caserne/update/{{ $c->getNumCaserne() }}"
                                       class="btn btn-outline-warning"
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST"
                                          action="/caserne/delete"
                                          style="display:inline;"
                                          onsubmit="return confirm('Voulez-vous vraiment supprimer cette caserne ?');">
                                        <input type="hidden" name="id" value="{{ $c->getNumCaserne() }}">
                                        <button type="submit"
                                                class="btn btn-outline-danger"
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<footer>
    <p>&copy; 2025 Paprika – Gestion des casernes et pompiers. Créé avec ❤️ par Clément.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const search = document.getElementById('searchCasernes');
    const rows = document.querySelectorAll('#tableCasernes tr');

    search.addEventListener('keyup', () => {
        const val = search.value.toLowerCase();
        rows.forEach(r => {
            r.style.display = r.textContent.toLowerCase().includes(val) ? '' : 'none';
        });
    });
</script>
</body>
</html>