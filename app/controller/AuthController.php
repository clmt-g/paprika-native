<?php

namespace Paprika\controller;

// faire un RBAC

use Paprika\utils\Renderer;
use Paprika\utils\CSRFToken;
use Paprika\utils\CSRFTokenSession;
use Paprika\utils\Auth;

class AuthController extends BaseController
{
    private Auth $auth;
    private static CSRFToken $csrftoken;

    public function __construct() {
        $this->auth = new Auth();
        self::$csrftoken = new CSRFTokenSession();
    }

    public function login() {
        // token csrf
        $token = self::$csrftoken::generateToken();
        if (!$token) {
            $errors[] = "Erreur lors de la génération du token";
            echo Renderer::render('pompiers/error',
                ['errors' => $errors]
            );
            return;
        }
        echo Renderer::render("auth/login", ['token' => $token]);
    }
    public function do_login() {
        $errors = [];

        // récupérer le token pour vérifier sa validité
        $token = $_POST['token'] ?? null;
        if (!self::$csrftoken::check($token)) {
            $errors[] = "Le token est expiré ou invalide";
            echo Renderer::render('users/error',
                ['errors' => $errors]
            );
            return;
        }

        $login = $_POST['login'] ?? null;
        $passwd = $_POST['passwd'] ?? null;
        $user = $this->auth->login($login, $passwd);
        if(!$user) {
            $errors[] = "Login ou mot de passe incorrect";
            echo Renderer::render('users/error',
                ['errors' => $errors]
            );
            return;
        }
        header('Location: /');
        exit;
    }

    public function logout() {
        // token csrf
        $token = self::$csrftoken::generateToken();
        if (!$token) {
            $errors[] = "Erreur lors de la génération du token";
            echo Renderer::render('pompiers/error',
                ['errors' => $errors]
            );
            return;
        }
        echo Renderer::render('auth/logout', ['token' => $token]);
    }

    public function do_logout() {

    }

    // méthodes hérité a ne pas implémenter
    public function show(): void
    {}

    public function detail($id): void
    {}

    public function create(): void
    {}

    public function do_create($data): void
    {}

    public function update($id): void
    {}

    public function do_update($data): void
    {}

    public function delete($id): void
    {}

    public function do_delete($id): void
    {}
}