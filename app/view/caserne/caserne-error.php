<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erreur - Paprika</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .error-container {
            max-width: 600px;
            width: 100%;
            padding: 2rem;
        }
        .error-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 3rem 2rem;
            text-align: center;
        }
        .error-icon {
            font-size: 4rem;
            color: var(--rouge-paprika);
            margin-bottom: 1.5rem;
        }
        .error-card h1 {
            color: var(--rouge-fonce);
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.8rem;
        }
        .error-card p {
            color: #555;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .error-message {
            background-color: #fff3f3;
            border-left: 4px solid var(--rouge-paprika);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            text-align: left;
            color: var(--rouge-fonce);
        }
        .error-message strong {
            display: block;
            margin-bottom: 0.5rem;
        }
        .btn-back {
            background-color: var(--rouge-paprika);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-back:hover {
            background-color: var(--rouge-fonce);
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
        .error-message ul {
            list-style-position: inside;
            padding-left: 0;
        }
        .error-message li {
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>

<div class="error-container">
    <div class="error-card">
        <div class="error-icon">
            <i class="bi bi-exclamation-circle-fill"></i>
        </div>
        <h1>Oups ! Une erreur s'est produite</h1>
        <p>Il y a un problème lors de la manipulation de la caserne.</p>

        <div class="error-message">
            <strong>Erreurs :</strong>
            <ul class="mb-0 mt-2 text-start">
                @foreach($errors as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        @if($type === 'create')
        <a href="/caserne/add" class="btn-back">
            <i class="bi bi-arrow-left me-2"></i>Retour à la création
        </a>
        @endif
        @if($type === 'update')
        <a href="/caserne/update/{{ $id }}" class="btn-back">
            <i class="bi bi-arrow-left me-2"></i>Retour à la modification
        </a>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>