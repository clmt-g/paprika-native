<?php

namespace Paprika\middleware;

use Paprika\utils\Auth;

class AuthMiddleware
{
    public static function requireLogin(): void {
        // Démarre la session uniquement si nécessaire
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!Auth::is_logged() && !str_contains($_SERVER['REQUEST_URI'], 'login')) {
            header('Location: /login');
            exit;
        }
    }

    public static function requireRole(string $role): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!Auth::is_logged() || !Auth::has($role)) {
            http_response_code(403);
            echo "⛔ Accès interdit.";
            exit;
        }
    }
}