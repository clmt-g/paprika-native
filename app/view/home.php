<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paprika - Accueil</title>
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

        /* HEADER */
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

        /* SIDEBAR */
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

        /* ANIMATIONS */
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
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
    </style>
</head>
<body>

<!-- HEADER -->
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

        <!-- SIDEBAR -->
        <aside class="col-md-2 sidebar">
            <a href="" class="active"><i class="bi bi-house"></i> Accueil</a>
            <a href="/caserne/show"><i class="bi bi-building"></i> Casernes</a>
            <a href="/pompiers/show"><i class="bi bi-people"></i> Pompiers</a>
        </aside>

        <!-- CONTENU PRINCIPAL -->
        <main class="col-md-10">
            <section id="dashboard" class="fade-in">
                <h2 class="mb-4"><i class="bi bi-speedometer2"></i> Tableau de bord</h2>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm p-3 border-start border-danger border-4">
                            <div class="card-body">
                                <i class="bi bi-building display-5 text-danger"></i>
                                <h5 class="mt-2">Casernes actives</h5>
                                <h3>{{ $nbCasernes }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-center shadow-sm p-3 border-start border-danger border-4">
                            <div class="card-body">
                                <i class="bi bi-person-fill display-5 text-danger"></i>
                                <h5 class="mt-2">Pompiers disponibles</h5>
                                <h3>{{ $nbPompiers }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-center shadow-sm p-3 border-start border-danger border-4">
                            <div class="card-body">
                                <i class="bi bi-alarm display-5 text-danger"></i>
                                <h5 class="mt-2">Alertes récentes</h5>
                                <h3>2</h3> <!-- code en dur exprès -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PETITE INTERACTION DYNAMIQUE -->
                <div class="mt-5 text-center">
                    <button id="refreshBtn" class="btn btn-danger">
                        <i class="bi bi-arrow-repeat"></i> Actualiser les données
                    </button>
                    <p class="mt-3 text-muted" id="refreshMsg"></p>
                </div>
            </section>
        </main>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; 2025 Paprika — Gestion des casernes et pompiers. Créé avec ❤️ par Clément.</p>
</footer>

<script>
    // Animation d'apparition
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelector("#dashboard").classList.add("fade-in");
    });

    // Simulation du bouton "Actualiser"
    document.getElementById("refreshBtn").addEventListener("click", () => {
        const msg = document.getElementById("refreshMsg");
        msg.textContent = "Mise à jour des données en cours...";
        msg.style.color = "gray";

        setTimeout(() => {
            msg.textContent = "✅ Données actualisées avec succès !";
            msg.style.color = "green";
        }, 1500);
    });
</script>

</body>
</html>
