<?php

namespace Paprika\utils;

use Paprika\model\UserDAO;
use Paprika\model\User;
use Paprika\utils\SingletonLogger;

class Auth
{
    private static array $permissions = [
        "default" => ["pompier_show","caserne_show"],
        "secretaire" => ["pompier_show","caserne_show","pompier_update","pompier_delete","pompier_create"],
        "admin" => ["pompier_show","caserne_show","pompier_update","pompier_delete","pompier_create","user_manage"]
    ];

    // Login
    public static function login(string $login, string $password): ?User {
        $dao = new UserDAO();
        $user = $dao->checkUserExists($login);

        if ($user && password_verify($password, $user->getPasswordHash()) && $user->isActif()) {
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'login' => $user->getLogin(),
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'role' => $user->getRole()
            ];

            SingletonLogger::getInstance()->getSQLLogger()->info("Connexion réussie : {$user->getLogin()}");
            return $user;
        }

        return null;
    }

    // Logout
    public static function logout(): void {
        if (isset($_SESSION['user']['login'])) {
            SingletonLogger::getInstance()->getSQLLogger()->info("Déconnexion : {$_SESSION['user']['login']}");
        }
        unset($_SESSION['user']);
        session_destroy();
    }

    // Vérifie si connecté
    public static function is_logged(): bool {
        return isset($_SESSION['user']);
    }

    // Vérifie rôle exact
    public static function has(string $role): bool {
        return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === $role;
    }

    // Vérifie permission
    public static function can(string $perm): bool {
        $role = $_SESSION['user']['role'] ?? 'default';
        return in_array($perm, self::$permissions[$role] ?? []);
    }
}