<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression de la Caserne</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 2rem;
            text-align: center;
        }

        h1 {
            color: #b22222;
            margin-bottom: 1.5rem;
        }

        .confirm-box {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: inline-block;
            padding: 2rem 3rem;
            max-width: 600px;
        }

        p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        form {
            display: inline;
        }

        button {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.7rem 1.4rem;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 600;
        }

        button:hover {
            background-color: #b02a37;
            transform: translateY(-2px);
        }

        a {
            display: inline-block;
            margin-left: 1rem;
            padding: 0.7rem 1.4rem;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-weight: 600;
        }

        a:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }

        .caserne-id {
            color: #b22222;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="confirm-box">
    <h1>Supprimer la Caserne <span class="caserne-id">n° {{ $caserne->getNumCaserne() }}</span></h1>

    <p>Voulez-vous vraiment supprimer cette caserne ?<br>
        Cette action est <strong>irréversible</strong>.</p>

    <form method="POST" action="/caserne/delete">
        <input type="hidden" name="id" value="{{ $caserne->getNumCaserne() }}">
        <input type="hidden" name="token" value="{{ $token }}"
        <button type="submit">🗑️ Oui, supprimer</button>
    </form>

    <a href="/caserne/show">❌ Annuler</a>
</div>

</body>
</html>