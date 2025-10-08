<?php

namespace Paprika\controller;

use Paprika\model\DAOPompiers;
use Paprika\utils\SingletonDataBaseMariaDB;
use Paprika\utils\Renderer;

/**
 *
 */

class PompiersController extends BaseController
{
    private DAOPompiers $pompierDAO;

    public function __construct()
    {
        parent::__construct();
        $this->pompierDAO = new DAOPompiers(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
    }

    /**
     * @return string
     */
    public function create(): string
    {
        // invocation du renderer qui renvoie la page avec le formulaire
        return '';
    }
    
    public function show($id) : void {
        if (!$id) {
            header('Location: /');
            exit;
        }
        $pompier = $this->pompierDAO->find($id);

        if (!$pompier) {
            header("location: /404.php");
            exit;
        }
        Renderer::render('pompiers/show', ['pompier' => $pompier]);
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
}
