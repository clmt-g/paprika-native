<?php
namespace Paprika\utils;

use Paprika\model\User;
use Paprika\model\DAOUser;

class Auth
{
    private DAOUser $DAOUser;

    private static array $rights = [
        'default' => [
            'pompier_show', 'caserne_show'
        ],
        'secretaire' => [
            'pompier_show', 'caserne_show',
            'pompier_save',
            'pompier_delete',
            'pompier_update'
        ],
        'admin' => [
            'pompier_show', 'caserne_show',
            'pompier_save', 'caserne_save',
            'pompier_delete', 'caserne_delete',
            'pompier_update', 'caserne_update',
            'user_show',
            'user_save',
            'user_delete',
            'user_update'
        ]
    ];

    public function __construct()
    {
        $this->DAOUser = new DAOUser(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
        // Démarrer la session si pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Tente de connecter un utilisateur
     * @param string $log Le login
     * @param string $password Le mot de passe en clair
     * @return User|null L'utilisateur connecté ou null si échec
     */
    public function login(string $log, string $password): ?User
    {
        // Récupérer l'utilisateur par login
        $user = $this->DAOUser->checkUserExist($log, $password);

        // Vérifier si l'utilisateur existe
        if (!$user) {
            return null;
        }

        // Créer la session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['auth'] = [
            'id' => $user->getId(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'login' => $user->getLogin(),
            'role' => $user->getRole()
        ];

        // Logger l'action (optionnel) FIXME
        error_log("User {$user->getLogin()} logged in successfully");

        return $user;
    }

    /**
     * Déconnecte l'utilisateur actuel
     */
    public static function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Logger avant de déconnecter FIXME
        if (isset($_SESSION['auth']['login'])) {
            error_log("User {$_SESSION['auth']['login']} logged out");
        }

        // Supprimer les données d'authentification
        unset($_SESSION['auth']);

        // Rediriger vers la page de login
        header('Location: /auth/login');
        exit;
    }

    /**
     * Vérifie si un utilisateur est connecté
     * @return bool
     */
    public static function isLogged(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['auth']) && !empty($_SESSION['auth']['id']);
    }

    /**
     * Vérifie si l'utilisateur connecté a un rôle spécifique
     * @param string $role Le rôle à vérifier (default, secretaire, admin)
     * @return bool
     */
    public static function has(string $role): bool
    {
        if (!self::isLogged()) {
            return false;
        }

        return $_SESSION['auth']['role'] === $role;
    }

    /**
     * Vérifie si l'utilisateur connecté a la permission pour une action
     * @param string $perm La permission à vérifier (ex: 'pompier_save')
     * @return bool
     */
    public static function can(string $perm): bool
    {
        if (!self::isLogged()) {
            return false;
        }

        $userRole = $_SESSION['auth']['role'];

        // Vérifier si le rôle existe dans les droits
        if (!isset(self::$rights[$userRole])) {
            return false;
        }

        // Vérifier si la permission est dans la liste des droits du rôle
        return in_array($perm, self::$rights[$userRole]);
    }
}