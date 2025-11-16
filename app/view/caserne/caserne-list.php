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
            font-family: "Segoe UI", sans-serif;
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

        .btn-danger,
        .btn-outline-warning,
        .btn-outline-primary,
        .btn-outline-danger {
            transition: all 0.25s ease, box-shadow 0.25s ease;
        }
        .btn-danger {
            background-color: var(--rouge-paprika);
            border: none;
        }
        .btn-danger:hover {
            background-color: var(--rouge-fonce);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(178,34,34,0.3);
        }
        .btn-outline-danger {
            color: #b22222;
            border: 1px solid #b22222;
            background-color: transparent;
            position: relative;
        }
        .btn-outline-danger i {
            transition: transform 0.25s ease;
        }
        .btn-outline-danger:hover {
            color: #fff;
            background-color: #b22222;
            border-color: #8b1a1a;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(178, 34, 34, 0.3);
        }
        .btn-outline-danger:hover i {
            transform: rotate(-15deg) scale(1.2);
        }
    </style>
</head>
<body>

<header class="text-center">
    <div class="container d-flex flex-column align-items-center position-relative">
        <!-- Icônes en haut à droite -->
        <div class="position-absolute top-0 end-0 mt-2 me-3 d-flex gap-3">
            <a href="/users/show/detail/{{ $_SESSION['auth']['id'] }}" class="text-decoration-none text-dark" title="Mon profil">
                <i class="bi bi-person-circle fs-2"></i>
            </a>
            <a href="#" class="text-decoration-none text-dark" title="Se déconnecter" onclick="loadLogoutModal(); return false;">
                <i class="bi bi-box-arrow-right fs-2"></i>
            </a>
        </div>

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
            <a href="/pompiers/show">
                <i class="bi bi-people"></i> Pompiers
            </a>
            @if(Auth::can('user_show'))
                <a href="/users/show"><i class="bi bi-person-badge"></i> Users</a>
            @endif
        </aside>

        <main class="col-md-10 fade-in">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-building"></i> Liste des casernes</h2>
                @if(Auth::can('caserne_save'))
                <a href="/caserne/add" class="btn btn-danger">
                    <i class="bi bi-plus-circle"></i> Ajouter une caserne
                </a>
                @endif
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
                            <th class="text-center">Nombre de pompiers</th>
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
                            <td><span class="badge bg-info">{{ $c->getTypeTexte() }}</span></td>
                            <td class="text-center">
                                <span class="badge bg-dark">{{ $c->getNbPompiers() }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/caserne/show/detail/{{ $c->getNumCaserne() }}"
                                       class="btn btn-outline-primary"
                                       title="Détails">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(Auth::can('caserne_update'))
                                    <a href="/caserne/update/{{ $c->getNumCaserne() }}"
                                       class="btn btn-outline-warning"
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endif
                                    @if(Auth::can('caserne_delete'))
                                    <a href="#"
                                       class="btn btn-outline-danger"
                                       title="Supprimer"
                                       onclick="loadDeleteModal('{{ $c->getNumCaserne() }}')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    @endif
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

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill"></i> Confirmer la suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                Voulez-vous vraiment supprimer cette caserne ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST" action="/caserne/delete" style="display:inline;">
                    <input type="hidden" name="id" id="deleteCaserneId" value="">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Recherche dans le tableau
    const search = document.getElementById('searchCasernes');
    const rows = document.querySelectorAll('#tableCasernes tr');
    search.addEventListener('keyup', () => {
        const val = search.value.toLowerCase();
        rows.forEach(r => r.style.display = r.textContent.toLowerCase().includes(val) ? '' : 'none');
    });

    // Chargement du modal et assignation de l'ID à supprimer
    function loadDeleteModal(caserneId) {
        document.getElementById('deleteCaserneId').value = caserneId;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
    // modal de logout
    function loadLogoutModal() {
        fetch('/auth/logout')
            .then(response => response.text())
            .then(html => {
                let container = document.createElement('div');
                container.innerHTML = html;
                document.body.appendChild(container);

                let modal = new bootstrap.Modal(document.querySelector('#logoutModal'));
                modal.show();

                document.querySelector('#logoutModal').addEventListener('hidden.bs.modal', function() {
                    this.parentElement.remove();
                });
            })
            .catch(error => {
                console.error('Erreur lors du chargement du modal:', error);
            });
    }
</script>

</body>
</html>