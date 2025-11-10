<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; background: #f8f8f8; }
        form { background: #fff; padding: 1.5rem; border-radius: 8px; max-width: 300px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
        input { display: block; width: 100%; margin-bottom: 1rem; padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc; }
        button { padding: 0.5rem 1rem; background: #b22222; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #8b1a1a; }
        .error { color: red; margin-bottom: 1rem; }
    </style>
</head>
<body>
<h1 style="text-align:center;">Connexion</h1>

<?php if(!empty($error)) : ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post" action="/login">
    <input type="hidden" name="_csrf" value="<?= \Paprika\utils\CSRFTokenSession::generateToken(); ?>">
    <input type="text" name="login" placeholder="Login" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>
</body>
</html>