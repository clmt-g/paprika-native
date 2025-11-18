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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si un token existe déjà et n'est pas expiré, le réutiliser
        if (isset($_SESSION[self::$token_name])) {
            $data = $_SESSION[self::$token_name];
            if (time() - $data['timestamp'] <= 600) {
                return $data['token'];
            }
        }

        // Sinon, créer un nouveau token
        $token = bin2hex(random_bytes(32));
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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION[self::$token_name])) {
            return false;
        }

        $sessionData = $_SESSION[self::$token_name];

        // Vérification du token
        $isValid = hash_equals($sessionData['token'], $token) && (time() - $sessionData['timestamp'] <= 600);

        // Supprimer le token pour qu’il ne soit utilisé qu’une seule fois
        unset($_SESSION[self::$token_name]);

        return $isValid;
    }
}