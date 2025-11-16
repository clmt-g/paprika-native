<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Accès refusé - Paprika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --rouge-paprika: #b22222;
            --rouge-fonce: #8b1a1a;
            --gris-fond: #f8f9fa;
        }
        body {
            background: linear-gradient(135deg, var(--rouge-paprika) 0%, #e44d4d 50%, var(--rouge-fonce) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }
        .error-container {
            max-width: 600px;
            width: 100%;
            padding: 0 20px;
        }
        .error-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            padding: 3rem 2.5rem;
            text-align: center;
            animation: slideDown 0.5s ease;
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .error-icon {
            font-size: 8rem;
            color: var(--rouge-paprika);
            animation: shake 0.5s ease;
            animation-delay: 0.3s;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        .error-code {
            font-size: 4rem;
            font-weight: 700;
            color: var(--rouge-paprika);
            margin: 1rem 0 0.5rem;
        }
        .error-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }
        .error-message {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .btn-home {
            background: linear-gradient(90deg, var(--rouge-paprika), #e44d4d);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(178, 34, 34, 0.4);
            background: linear-gradient(90deg, var(--rouge-fonce), var(--rouge-paprika));
            color: white;
        }
        .info-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            margin-top: 2rem;
            border-radius: 5px;
            text-align: left;
        }
        .info-box strong {
            color: #856404;
        }
        .info-box p {
            margin: 0;
            color: #856404;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="error-container">
    <div class="error-card">
        <div class="error-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <div class="error-code">403</div>
        <h1 class="error-title">Accès refusé</h1>
        <p class="error-message">
            Désolé, vous n'avez pas les permissions nécessaires pour accéder à cette page.<br>
            Cette section est réservée aux utilisateurs autorisés.
        </p>

        <a href="/" class="btn-home">
            <i class="bi bi-house-fill"></i> Retour à l'accueil
        </a>

        <div class="info-box">
            <strong><i class="bi bi-info-circle-fill"></i> Besoin d'accès ?</strong>
            <p>Si vous pensez que c'est une erreur, contactez votre administrateur système.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
