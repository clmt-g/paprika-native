<?php

namespace Paprika\utils;

use Paprika\utils\CSRFToken;
use Random\RandomException;

class CSRFTokenSession extends CSRFToken
{
    /**
     * @inheritDoc
     * @throws RandomException
     */
    public static function generateToken(): string
    {
        // Démarrer la session si elle n'est pas déjà active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Générer un token aléatoire sécurisé
        $token = bin2hex(random_bytes(32));

        // Stocker le token et son timestamp dans la session
        $_SESSION['csrf_token'] = [
            'token' => $token,
            'time' => time()
        ];

        return $token;
    }

    /**
     * @inheritDoc
     */
    public static function check(string $token): bool
    {
        // la session est ouverte ?
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // vérifier si le token et le time est définie en session
        if (isset($_SESSION['csrf_token']['token'], $_SESSION['csrf_token']['time'])) {
            // le nombre de seconde entre maintenant et quand le token à été créer
            $tokenAge = time() - $_SESSION['csrf_token']['time'];

            // vérifier que le token en session et celui en paramètre sont les meme, ainsi que le token à été créer il y a moins de 10 minutes
            if ($_SESSION['csrf_token']['token'] == $token && $tokenAge < 600) {
                return true;
            }
        }
        // suppression du contenu de la session
        unset($_SESSION['csrf_token']);
        return false;
    }
}