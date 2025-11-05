<?php
// caserne-form_create.php
// Variables attendues par le renderer : $errors (array), $data (array), $csrf_token (string)
$errors = $errors ?? [];
$data = $data ?? [];
$csrf_token = $csrf_token ?? '';

// helper pour échapper avant affichage
function h($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Caserne</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
            text-align: center;
            margin-bottom: 1.5rem;
        }

        form {
            background-color: #fff;
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

        input[type="text"] {
            width: 100%;
            padding: 0.6rem 0.8rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: all 0.2s ease;
            margin-top: 0.3rem;
        }

        input[type="text"]:focus {
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

        .accordion-button:not(.collapsed) {
            background-color: #b22222;
            color: white;
        }

        .accordion-button:focus {
            box-shadow: 0 0 0 0.2rem rgba(178, 34, 34, 0.25);
        }

        .alert-errors {
            background-color: #fff3f3;
            border-left: 4px solid #b22222;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            color: #b22222;
        }

        .alert-errors li { margin-bottom: 0.5rem; }
    </style>
</head>
<body>

<h1>Ajouter une Caserne</h1>

<?php if (!empty($errors) && is_array($errors)): ?>
    <div class="alert-errors">
        <ul class="mb-0">
            <?php foreach ($errors as $err): ?>
                <li><?php echo h($err); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="/caserne/add" novalidate>
    <!-- CSRF Token -->
    <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>">

    <label>Adresse :
        <input type="text" name="adresse" value="<?php echo h($data['adresse'] ?? ''); ?>" required>
    </label>

    <label>Code Postal :
        <input type="text" name="cp" value="<?php echo h($data['cp'] ?? ''); ?>" required>
    </label>

    <label>Ville :
        <input type="text" name="ville" value="<?php echo h($data['ville'] ?? ''); ?>" required>
    </label>

    <!-- Accordéon Type Caserne -->
    <div class="accordion mt-3" id="accordionType">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#typeCaserne" aria-expanded="false" aria-controls="typeCaserne">
                    Choisir le Type de Caserne
                </button>
            </h2>
            <div id="typeCaserne" class="accordion-collapse collapse" data-bs-parent="#accordionType">
                <div class="accordion-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="codeTypeC" id="type1" value="1" <?php echo (isset($data['codeTypeC']) && $data['codeTypeC'] == 1) ? 'checked' : ''; ?> required>
                        <label class="form-check-label" for="type1">
                            🚒 Caserne <strong>Professionnelle</strong>
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="codeTypeC" id="type2" value="2" <?php echo (isset($data['codeTypeC']) && $data['codeTypeC'] == 2) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="type2">
                            🧯 Caserne <strong>Mixte</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="codeTypeC" id="type3" value="3" <?php echo (isset($data['codeTypeC']) && $data['codeTypeC'] == 3) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="type3">
                            👨‍🚒 Caserne <strong>Volontaires</strong>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="submit">Créer</button>
</form>

<a href="/caserne/show">← Retour à la liste</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>