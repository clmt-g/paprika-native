<?php

namespace Paprika\controller;

/* use to display the infos of the user */

use Paprika\model\DAOUser;
use Paprika\utils\CSRFToken;
use Paprika\utils\CSRFTokenSession;
use Paprika\utils\Renderer;
use Paprika\utils\SingletonDataBaseMariaDB;
use Random\RandomException;

class UserController extends BaseController
{
    private DAOUser $userDAO;
    private static CSRFToken $csrftoken;

    public function __construct() {
        $this->userDAO = new DAOUser(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
        self::$csrftoken = new CSRFTokenSession();
    }

    /** display the show page
     * @throws RandomException
     */
    public function show(): void
    {
        $users = $this->userDAO->findAll();
        if (!$users) {
            header("location: /404.php");
            exit;
        }
        $compteur = 1;
        echo Renderer::render('users/show', ['users' => $users, 'compteur' => $compteur]);
    }

    public function detail($id): void
    {
        // TODO: Implement detail() method.
    }

    public function create(): void
    {
        // TODO: Implement create() method.
    }

    public function do_create($data): void
    {
        // TODO: Implement do_create() method.
    }

    public function update($id): void
    {
        // TODO: Implement update() method.
    }

    public function do_update($data): void
    {
        // TODO: Implement do_update() method.
    }

    public function delete($id): void
    {
        // TODO: Implement delete() method.
    }

    public function do_delete($id): void
    {
        // TODO: Implement do_delete() method.
    }

    public function resetPasswd($id): void {

    }
}