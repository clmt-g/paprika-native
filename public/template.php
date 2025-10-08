<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paprika - Gestion des casernes et pompiers</title>
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

        /* HEADER */
        header {
            background: linear-gradient(90deg, var(--rouge-paprika), #e44d4d);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        header h1 {
            font-weight: 700;
            font-size: 1.8rem;
        }

        /* SIDEBAR */
        .sidebar {
            background-color: #2b2b2b;
            min-height: 100vh;
            padding-top: 1rem;
            color: white;
            transition: all 0.3s ease;
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

        /* CONTENU */
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

        /* TABLEAU */
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

        /* FOOTER */
        footer {
            background: linear-gradient(90deg, var(--rouge-paprika), #e44d4d);
            color: #fff;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
        }

        footer a {
            color: #ffeaea;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* BOUTONS */
        .btn-danger {
            background-color: var(--rouge-paprika);
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-danger:hover {
            background-color: var(--rouge-fonce);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(178,34,34,0.3);
        }

        /* ANIMATION */
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }
    </style>
</head>
<body>

<!-- HEADER -->
<header class="text-center">
    <div class="container">
        <h1><i class="bi bi-fire"></i> Paprika</h1>
        <p class="lead mb-0">Gestion des casernes & des pompiers</p>
    </div>
</header>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <aside class="col-md-2 sidebar">
            <a href="#" id="menuDashboard" class="active"><i class="bi bi-speedometer2"></i> Tableau de bord</a>
            <a href="#" id="menuCasernes"><i class="bi bi-building"></i> Casernes</a>
            <a href="#" id="menuPompiers"><i class="bi bi-people"></i> Pompiers</a>
        </aside>

        <!-- CONTENU -->
        <main class="col-md-10">
            <!-- DASHBOARD -->
            <section id="dashboard" class="fade-in">
                <h2 class="mb-4"><i class="bi bi-speedometer2"></i> Tableau de bord</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm p-3 border-start border-danger border-4">
                            <div class="card-body">
                                <i class="bi bi-building display-5 text-danger"></i>
                                <h5 class="mt-2">Casernes actives</h5>
                                <h3 id="nbCasernes">6</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm p-3 border-start border-danger border-4">
                            <div class="card-body">
                                <i class="bi bi-person-fill display-5 text-danger"></i>
                                <h5 class="mt-2">Pompiers disponibles</h5>
                                <h3 id="nbPompiers">45</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm p-3 border-start border-danger border-4">
                            <div class="card-body">
                                <i class="bi bi-alarm display-5 text-danger"></i>
                                <h5 class="mt-2">Alertes récentes</h5>
                                <h3 id="nbAlertes">2</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CASERNES -->
            <section id="casernes" class="d-none fade-in">
                <h2 class="mb-4"><i class="bi bi-building"></i> Liste des casernes</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Caserne Montmélian</h5>
                                <p><i class="bi bi-geo-alt"></i> Savoie</p>
                                <button class="btn btn-danger btn-sm">Voir le personnel</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Caserne Chambéry</h5>
                                <p><i class="bi bi-geo-alt"></i> Savoie</p>
                                <button class="btn btn-danger btn-sm">Voir le personnel</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Caserne Albertville</h5>
                                <p><i class="bi bi-geo-alt"></i> Savoie</p>
                                <button class="btn btn-danger btn-sm">Voir le personnel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- POMPIERS -->
            <section id="pompiers" class="d-none fade-in">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2><i class="bi bi-people"></i> Liste des pompiers</h2>
                    <button class="btn btn-danger"><i class="bi bi-person-plus"></i> Ajouter un pompier</button>
                </div>

                <div class="input-group mb-3 w-50">
                    <span class="input-group-text bg-danger text-white"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchPompiers" class="form-control" placeholder="Rechercher un pompier...">
                </div>

                <table class="table table-hover align-middle shadow-sm bg-white">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Grade</th>
                        <th>Caserne</th>
                        <th>Statut</th>
                    </tr>
                    </thead>
                    <tbody id="tablePompiers">
                    <tr>
                        <td>1</td>
                        <td>Jean Dupont</td>
                        <td>Caporal</td>
                        <td>Montmélian</td>
                        <td><span class="badge bg-success">Disponible</span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Sophie Martin</td>
                        <td>Sergent</td>
                        <td>Chambéry</td>
                        <td><span class="badge bg-warning text-dark">En mission</span></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Antoine Leroy</td>
                        <td>Lieutenant</td>
                        <td>Albertville</td>
                        <td><span class="badge bg-success">Disponible</span></td>
                    </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; 2025 Paprika — Gestion des casernes et pompiers. Créé avec ❤️ par Clément.</p>
    <p><a href="#">Mentions légales</a> | <a href="#">Contact</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Navigation dynamique
    const sections = {
        dashboard: document.getElementById('dashboard'),
        casernes: document.getElementById('casernes'),
        pompiers: document.getElementById('pompiers')
    };

    const menuLinks = document.querySelectorAll('.sidebar a');

    menuLinks.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            menuLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');

            Object.values(sections).forEach(sec => sec.classList.add('d-none'));
            const id = link.id.replace('menu', '').toLowerCase();
            sections[id].classList.remove('d-none');
        });
    });

    // Filtrage du tableau des pompiers
    const search = document.getElementById('searchPompiers');
    const rows = document.querySelectorAll('#tablePompiers tr');

    search.addEventListener('keyup', () => {
        const val = search.value.toLowerCase();
        rows.forEach(r => {
            r.style.display = r.textContent.toLowerCase().includes(val) ? '' : 'none';
        });
    });
</script>
</body>
</html>
