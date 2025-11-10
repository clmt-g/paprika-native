<?php
namespace Paprika\controller;

use Paprika\utils\Auth;
use Paprika\utils\CSRFTokenSession;
use Paprika\utils\Renderer;
use Paprika\utils\SingletonLogger;

class AuthController
{
    private SingletonLogger $logger;

    public function __construct()
    {
        $this->logger = SingletonLogger::getInstance();
    }

    // Affiche le formulaire de connexion
    public function loginForm()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        echo Renderer::render('auth/login');
    }

    // Traitement de la connexion
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!CSRFTokenSession::check($_POST['_csrf'] ?? '')) {
            $this->logger->getErrorLogger()->error("Erreur CSRF sur login.");
            die("Erreur CSRF");
        }

        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';

        if (Auth::login($login, $password)) {
            $this->logger->getSQLLogger()->info("Utilisateur connecté : $login");
            header('Location: /dashboard');
            exit;
        } else {
            $this->logger->getErrorLogger()->warning("Échec de connexion pour $login");
            echo Renderer::render('auth/login', ['error' => "Identifiants invalides"]);
        }
    }

    // Déconnexion
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        Auth::logout();
        $this->logger->getSQLLogger()->info("Utilisateur déconnecté");
        header('Location: /login');
        exit;
    }
}