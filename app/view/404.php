<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur 404 - Paprika</title>
    <style>
        :root {
            --rouge-paprika: #d84315;
            --fond-clair: #fff8f5;
        }

        body {
            margin: 0;
            padding: 0;
            background: var(--fond-clair);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
        }

        /* Image du pot */
        .paprika {
            width: 700px; /* ✅ plus grand */
            opacity: 0;
            transform: scale(0) rotate(0deg);
            animation: spinIn 3s ease forwards;
        }

        @keyframes spinIn {
            0% {
                opacity: 0;
                transform: scale(0) rotate(0deg);
            }
            50% {
                opacity: 1;
                transform: scale(1.3) rotate(720deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotate(720deg);
            }
        }

        /* Message d’erreur */
        .message {
            text-align: center;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .message.show {
            opacity: 1;
            transform: translateY(0);
        }

        h1 {
            color: var(--rouge-paprika);
            font-size: 3.2rem;
            margin-top: 1.5rem;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { text-shadow: 0 0 10px #ff7b54; }
            to { text-shadow: 0 0 25px #ffb199; }
        }

        p {
            color: #333;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        a {
            color: var(--rouge-paprika);
            text-decoration: none;
            font-weight: bold;
            border: 2px solid var(--rouge-paprika);
            padding: 0.5rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        a:hover {
            background-color: var(--rouge-paprika);
            color: white;
        }

        footer {
            position: absolute;
            bottom: 1rem;
            font-size: 0.9rem;
            color: #888;
        }
        /* Animation des particules */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background-color: var(--rouge-paprika);
            border-radius: 50%;
            opacity: 0.7;
            animation: float 8s linear infinite;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) scale(0);
                opacity: 0.3;
            }
            50% {
                opacity: 1;
            }
            100% {
                transform: translate(var(--x), var(--y)) scale(1.2);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
<div class="particles" id="particles"></div>
<img src="images/paprika.png" alt="Paprika" class="paprika" id="paprika">

<div class="message" id="message">
    <h1>Erreur 404</h1>
    <p>Cette page s’est volatilisée dans un nuage de paprika 🌶️</p>
    <a href="/">Retour à la caserne</a>
</div>

<footer>&copy; 2025 Paprika — Gestion des casernes et pompiers</footer>

<script>
    const paprika = document.getElementById('paprika');
    const message = document.getElementById('message');

    // Quand l'animation du pot est terminée, on affiche le message
    paprika.addEventListener('animationend', () => {
        message.classList.add('show');
    });

    // Génération des particules
    const container = document.getElementById('particles');
    for (let i = 0; i < 60; i++) {
        const p = document.createElement('div');
        p.classList.add('particle');
        p.style.width = `${Math.random() * 8 + 4}px`;
        p.style.height = p.style.width;
        p.style.left = `${Math.random() * 100}%`;
        p.style.top = `${Math.random() * 100}%`;
        p.style.setProperty('--x', `${(Math.random() - 0.5) * 400}px`);
        p.style.setProperty('--y', `${(Math.random() - 0.5) * 400}px`);
        p.style.animationDelay = `${Math.random() * 3}s`;
        container.appendChild(p);
    }

    // Apparition du contenu après le tourbillon
    setTimeout(() => {
        document.getElementById('content').classList.add('show');
    }, 2800);
</script>
</body>
</html>
