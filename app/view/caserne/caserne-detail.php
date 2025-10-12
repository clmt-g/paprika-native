<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Caserne</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 2rem;
        }

        h1 {
            color: #b22222;
            text-align: center;
            margin-bottom: 2rem;
        }

        .detail-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            margin: 0 auto;
            padding: 2rem;
        }

        p {
            font-size: 1.1rem;
            margin: 1rem 0;
        }

        strong {
            color: #b22222;
        }

        .actions {
            text-align: center;
            margin-top: 2rem;
        }

        a {
            display: inline-block;
            margin: 0.5rem;
            text-decoration: none;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.2s ease;
            background-color: #b22222;
            color: white;
        }

        a:hover {
            background-color: #8b1a1a;
            transform: translateY(-2px);
        }

        .back-link {
            display: inline-block;
            margin-top: 2rem;
            color: #b22222;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link:hover {
            color: #8b1a1a;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Détails de la Caserne n° {{ $caserne->getNumCaserne() }}</h1>

<div class="detail-container">
    <p><strong>Adresse :</strong> {{ $caserne->getAdresse() }}</p>
    <p><strong>Code Postal :</strong> {{ $caserne->getCp() }}</p>
    <p><strong>Ville :</strong> {{ $caserne->getVille() }}</p>
    <p><strong>Type de Caserne :</strong> {{ $caserne->getTypeTexte() }}</p>

    <div class="actions">
        <a href="/caserne/show">← Retour à la liste</a>
    </div>
</div>

</body>
</html>