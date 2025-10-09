<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Caserne</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 2rem;
            color: #333;
        }

        h1 {
            color: #b22222;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        form {
            background: #fff;
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-bottom: 1rem;
            font-weight: 600;
            color: #444;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 0.6rem 0.8rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: all 0.2s ease;
            margin-top: 0.3rem;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #b22222;
            box-shadow: 0 0 0 3px rgba(178, 34, 34, 0.15);
            outline: none;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            background-color: #b22222;
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 1rem;
        }

        button[type="submit"]:hover {
            background-color: #8b1a1a;
            transform: translateY(-2px);
        }

        a {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #b22222;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        a:hover {
            color: #8b1a1a;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Modifier la Caserne <?php echo $caserne->getNumCaserne(); ?></h1>

<form method="POST" action="/caserne/update">
    <input type="hidden" name="NumCaserne" value="<?php echo $caserne->getNumCaserne(); ?>">

    <label>Adresse :
        <input type="text" name="adresse" value="<?php echo $caserne->getAdresse(); ?>" required>
    </label>

    <label>Code Postal :
        <input type="text" name="cp" value="<?php echo $caserne->getCp(); ?>" required>
    </label>

    <label>Ville :
        <input type="text" name="ville" value="<?php echo $caserne->getVille(); ?>" required>
    </label>

    <label>Code Type :
        <input type="number" name="codeTypeC" value="<?php echo $caserne->getCodeTypeC(); ?>" required>
    </label>

    <button type="submit">Mettre à jour</button>
</form>

<a href="/caserne/show">← Retour à la liste</a>

</body>
</html>