<?php

namespace Paprika\controller;

use Paprika\dao\UserDAO;
use Paprika\middleware\AuthMiddleware;
use Paprika\utils\Auth;
use Renderer;

class UserController
{
    private UserDAO $dao;

    public function __construct() {
        $this->dao = new UserDAO();
    }

    public function list() {
        AuthMiddleware::requireLogin();
        $users = $this->dao->getAllUsers();
        Renderer::getInstance()->render('users/list.php', ['users'=>$users]);
    }

    public function addForm() {
        AuthMiddleware::requireRole('admin');
        Renderer::getInstance()->render('users/add.php', ['csrf'=>CSRFToken::getInstance()->generate()]);
    }

    public function add() {
        AuthMiddleware::requireRole('admin');
        if (!CSRFToken::getInstance()->verify($_POST['_csrf'])) die("Erreur CSRF");

        $user = new \Paprika\model\User(
            0,
            $_POST['login'],
            password_hash($_POST['password'], PASSWORD_BCRYPT),
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['role'],
            true
        );
        $this->dao->createUser($user);
        header('Location: /users');
    }
}