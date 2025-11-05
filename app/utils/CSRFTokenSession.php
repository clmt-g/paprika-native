<?php

namespace Paprika\utils;

use Paprika\utils\CSRFToken;

class CSRFTokenSession extends CSRFToken
{
    /**
     * Generate and return the token, store the token with timestamp in session
     * @return string
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
        $_SESSION[self::$token_name] = [
            'token' => $token,
            'timestamp' => time()
        ];

        return $token;
    }

    /**
     * Check if the provided token is valid and not expired
     * @param string $token
     * @return bool
     */
    public static function check(string $token): bool
    {
        // Démarrer la session si elle n'est pas déjà active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier si le token existe en session
        if (!isset($_SESSION[self::$token_name])) {
            return false;
        }

        $sessionData = $_SESSION[self::$token_name];

        // Vérifier si le token fourni correspond au token stocke
        if (!hash_equals($sessionData['token'], $token)) {
            return false;
        }

        // Vérifier l'expiration du token 10min
        $tokenAge = time() - $sessionData['timestamp'];

        if ($tokenAge > 600 ) {
            unset($_SESSION[self::$token_name]);
            return false;
        }

        return true;
    }
}