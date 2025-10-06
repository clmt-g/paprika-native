<?php

namespace Paprika\controller;

use Paprika\model\DAOPompiers;
use Paprika\utils\SingletonDataBaseMariaDB;

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

    public function do_create($data)
    {

    }

    public function update($matricule)
    {

    }

    public function do_update($matricule, $data)
    {

    }

}
