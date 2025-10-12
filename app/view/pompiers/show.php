<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des pompiers - Paprika</title>
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
        <div class="d-flex align-items-center justify-content-center mb-2">
            <img src="/assets/imagepap.png" alt="Logo Paprika" class="logo">
            <h1>Paprika</h1>
        </div>
        <p class="lead mb-0">Gestion des casernes & des pompiers</p>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-2 sidebar">
            <a href="/" class="">
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
        <main class="col-md-10 fade-in">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-fire text-danger"></i> Liste des pompiers</h2>
                <a href="/pompiers/create" class="btn btn-danger">
                    <i class="bi bi-plus-circle"></i> Ajouter un pompier
                </a>
            </div>

            <div class="input-group mb-3 w-50">
                <span class="input-group-text bg-danger text-white"><i class="bi bi-search"></i></span>
                <input type="text" id="searchPompiers" class="form-control" placeholder="Rechercher un pompier...">
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Matricule</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Chef d'agré</th>
                            <th>Date de naissance</th>
                            <th>Caserne</th>
                            <th>Grade</th>
                            <th>Responsable</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="tablePompiers">
                        @foreach($pompiers as $pompier)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $i++ }}</span></td>
                            <td>{{ $pompier->getMatricule() }}</td>
                            <td>{{ $pompier->getPrenom() }}</td>
                            <td>{{ $pompier->getNom() }}</td>
                            <td>{{ $pompier->getChefAgret() }}</td>
                            <td>{{ $pompier->getDateNaissance() }}</td>
                            <td>
                                <a href="/caserne/show/detail/{{ $pompier->getNumCaserne() }}"
                                   class="text-decoration-none text-danger fw-bold">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    {{ $villes[$pompier->getMatricule()] }}
                                </a>
                            </td>
                            <td>{{ $nomsGrades[$pompier->getMatricule()] ?? $pompier->getCodeGrade() }}</td>                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="/pompiers/show/detail/{{ $pompier->getMatricule() }}" class="btn btn-outline-primary" title="Détails">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/pompiers/update/{{ $pompier->getMatricule() }}" class="btn btn-outline-warning" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-danger" title="Supprimer" onclick="loadDeleteModal('/pompiers/delete/{{ $pompier->getMatricule() }}')">
                                        <i class="bi bi-trash"></i>
                                    </a>
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
    const search = document.getElementById('searchPompiers');
    const rows = document.querySelectorAll('#tablePompiers tr');

    search.addEventListener('keyup', () => {
        const val = search.value.toLowerCase();
        rows.forEach(r => {
            r.style.display = r.textContent.toLowerCase().includes(val) ? '' : 'none';
        });
    });
    function loadDeleteModal(url) {
        // Change l'URL sans recharger la page
        window.history.pushState({}, '', url);

        fetch(url)
            .then(response => response.text())
            .then(html => {
                let container = document.createElement('div');
                container.innerHTML = html;
                document.body.appendChild(container);

                let modal = new bootstrap.Modal(document.querySelector('.modal'));
                modal.show();

                // Quand on ferme la modale, revenir à l'URL précédente
                document.querySelector('.modal').addEventListener('hidden.bs.modal', function() {
                    window.history.back();
                    this.parentElement.remove();
                });
            });
    }
</script>
</body>
</html>
