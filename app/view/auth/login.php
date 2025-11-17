<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Paprika</title>
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
        }
        .login-container {
            max-width: 450px;
            width: 100%;
            padding: 0 20px;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            padding: 3rem 2.5rem;
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
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo-container img {
            width: 120px;
            height: auto;
            margin-bottom: 1rem;
        }
        .logo-container h1 {
            color: var(--rouge-paprika);
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .logo-container p {
            color: #666;
            font-size: 0.95rem;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: var(--rouge-paprika);
            box-shadow: 0 0 0 0.2rem rgba(178, 34, 34, 0.25);
        }
        .input-group-text {
            background-color: var(--gris-fond);
            border: 2px solid #e0e0e0;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        .btn-login {
            background: linear-gradient(90deg, var(--rouge-paprika), #e44d4d);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            padding: 0.75rem;
            width: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-top: 1.5rem;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(178, 34, 34, 0.4);
            background: linear-gradient(90deg, var(--rouge-fonce), var(--rouge-paprika));
        }
        .alert {
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        .footer-text {
            text-align: center;
            color: white;
            margin-top: 2rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <div class="logo-container">
            <img src="/assets/imagepap.png" alt="Logo Paprika">
            <h1>Paprika</h1>
            <p>Gestion des casernes & des pompiers</p>
        </div>

        <form method="POST" action="/auth/login">
            <div class="mb-3">
                <label for="login" class="form-label">
                    <i class="bi bi-person-fill text-danger"></i> Login
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text"
                           class="form-control"
                           id="login"
                           name="login"
                           placeholder="Votre login"
                           required
                           autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label for="passwd" class="form-label">
                    <i class="bi bi-lock-fill text-danger"></i> Mot de passe
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password"
                           class="form-control"
                           id="passwd"
                           name="passwd"
                           placeholder="Votre mot de passe"
                           required>
                </div>
            </div>

            <input type="hidden" name="token" value="{{ $token }}">

            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right"></i> Se connecter
            </button>
        </form>
    </div>

    <p class="footer-text">
        &copy; 2025 Paprika - Créé avec ❤️ par Clément
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
