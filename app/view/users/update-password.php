<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réinitialiser le mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* bouton placé au coin droit de l'input */
        .pwd-toggle-wrapper { position: relative; display: block; }
        .pwd-toggle-button {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            padding: 0.25rem 0.35rem;
            cursor: pointer;
            color: #495057;
            font-size: 1.05rem;
            line-height: 1;
        }
        .pwd-toggle-button:focus { outline: none; box-shadow: none; }
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
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 2rem 2.5rem;
            max-width: 550px;
            width: 100%;
        }

        label {
            font-weight: 600;
            color: var(--rouge-fonce);
        }

        .btn-danger {
            background-color: var(--rouge-paprika);
            border: none;
            transition: transform 0.2s ease;
        }

        .btn-danger:hover:enabled {
            background-color: var(--rouge-fonce);
            transform: translateY(-2px);
        }

        .btn-danger:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .strength-segment {
            flex: 1;
            height: 15px;
            background: #e0e0e0;
            border-radius: 4px;
            transition: background 0.3s;
        }

        #passwordTooltip {
            position: absolute;
            top: -130%;
            left: 50%;
            transform: translateX(-50%);
            display: none;
            background: #fff;
            border: 1px solid #ccc;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            box-shadow: 0 3px 8px rgba(0,0,0,0.25);
            z-index: 100;
            width: max-content;
            max-width: 250px;
        }

        #matchInfo {
            font-size: 0.9rem;
            margin-top: 0.3rem;
        }

        #matchInfo.valid {
            color: green;
        }

        #matchInfo.invalid {
            color: var(--rouge-fonce);
        }
    </style>
</head>
<body>

<main>
    <div class="card">
        <div class="text-center mb-3">
            <h2 class="fw-bold text-danger mb-0">Modification du mot de passe</h2>
            <hr>
        </div>

        <form method="POST" action="/users/update-password/{{ $user->getId() }}">
            <div class="mb-3">
                <label for="oldPassword">Ancien mot de passe</label>
                <input type="password" id="oldPassword" name="old_password" class="form-control" required>
            </div>

            <div class="mb-3 position-relative">
                <label for="newPassword">Nouveau mot de passe</label>
                <input type="password" id="newPassword" name="new_password" class="form-control" required>

                <div id="passwordStrengthWrapper" style="display: flex; gap: 4px; margin-top: 0.5rem; cursor: pointer; position: relative;">
                    <div class="strength-segment"></div>
                    <div class="strength-segment"></div>
                    <div class="strength-segment"></div>
                    <div class="strength-segment"></div>
                    <div class="strength-segment"></div>

                    <div id="passwordTooltip">
                        <ul style="margin:0; padding-left:1.2rem;">
                            <li>12 caractères minimum</li>
                            <li>Une lettre minuscule</li>
                            <li>Une lettre majuscule</li>
                            <li>Un chiffre</li>
                            <li>Un caractère spécial</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="confirmPassword">Confirmer le nouveau mot de passe</label>
                <input type="password" id="confirmPassword" name="confirm_password" class="form-control" required>
                <div id="matchInfo" class="invalid">Les mots de passe ne correspondent pas.</div>
            </div>

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="text-center mt-4">
                <a href="/users/show/detail/{{ $user->getId() }}" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Annuler
                </a>
                <button id="submitBtn" type="submit" class="btn btn-danger" disabled>
                    <i class="bi bi-key"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const newPasswordInput = document.getElementById("newPassword");
        const confirmPasswordInput = document.getElementById("confirmPassword");
        const matchInfo = document.getElementById("matchInfo");
        const submitBtn = document.getElementById("submitBtn");

        const segments = document.querySelectorAll("#passwordStrengthWrapper .strength-segment");
        const tooltip = document.getElementById("passwordTooltip");
        const wrapper = document.getElementById("passwordStrengthWrapper");

        let passwordScore = 0;

        // Tooltip hover
        wrapper.addEventListener("mouseenter", () => tooltip.style.display = "block");
        wrapper.addEventListener("mouseleave", () => tooltip.style.display = "none");

        // Vérifie la force du mot de passe
        function checkPasswordStrength() {
            const val = newPasswordInput.value;
            let score = 0;

            if (val.length >= 12) score++;
            if (/[a-z]/.test(val)) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[!@#$%^&*(),.?":{}|<>]/.test(val)) score++;

            segments.forEach((seg, index) => {
                seg.style.background = index < score ? "green" : "#e0e0e0";
            });

            passwordScore = score;
        }

        // Vérifie que les deux mots de passe correspondent
        function checkMatch() {
            const newVal = newPasswordInput.value;
            const confirmVal = confirmPasswordInput.value;

            if (confirmVal === "") {
                matchInfo.textContent = "Les mots de passe ne correspondent pas.";
                matchInfo.className = "invalid";
                return false;
            }

            if (newVal === confirmVal) {
                matchInfo.textContent = "Les mots de passe correspondent ✅";
                matchInfo.className = "valid";
                return true;
            } else {
                matchInfo.textContent = "Les mots de passe ne correspondent pas ❌";
                matchInfo.className = "invalid";
                return false;
            }
        }

        // Active / désactive le bouton submit
        function updateSubmitState() {
            const match = checkMatch();
            const strongEnough = passwordScore === 5;
            submitBtn.disabled = !(match && strongEnough);
        }

        newPasswordInput.addEventListener("input", () => {
            checkPasswordStrength();
            updateSubmitState();
        });

        confirmPasswordInput.addEventListener("input", updateSubmitState);
    });
    document.addEventListener('DOMContentLoaded', () => {
        // IDs des inputs à équiper
        const ids = ['oldPassword', 'newPassword', 'confirmPassword'];

        ids.forEach(id => {
            const input = document.getElementById(id);
            if (!input) return;

            // Ensure parent wrapper is positioned relatively so button can be absolute
            const parent = input.parentElement;
            // Add wrapper class for consistent styling
            parent.classList.add('pwd-toggle-wrapper');

            // Create button
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'pwd-toggle-button';
            btn.setAttribute('aria-label', 'Afficher/masquer le mot de passe');
            btn.setAttribute('aria-pressed', 'false');
            // Using Bootstrap Icons classes. Initial icon = eye (hidden -> can show)
            btn.innerHTML = '<i class="bi bi-eye" aria-hidden="true"></i>';

            // Insert button after input
            // if input is inside an input-group, append to input-group (works visually)
            // otherwise append as sibling (CSS wrapper positions it)
            parent.appendChild(btn);

            // Toggle handler
            btn.addEventListener('click', () => {
                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');

                // Update icon + aria-pressed
                const icon = btn.querySelector('i');
                if (isPassword) {
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                    btn.setAttribute('aria-pressed', 'true');
                } else {
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                    btn.setAttribute('aria-pressed', 'false');
                }

                // keep focus on input so user can continue typing
                input.focus();
            });

            // Optional: allow toggling with keyboard (Space/Enter)
            btn.addEventListener('keydown', (e) => {
                if (e.key === ' ' || e.key === 'Enter') {
                    e.preventDefault();
                    btn.click();
                }
            });
        });
    });
</script>

</body>
</html>
