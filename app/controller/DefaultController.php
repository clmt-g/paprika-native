<?php

namespace Paprika\controller;

use Paprika\model\DAOCaserne;
use Paprika\model\DAOPompiers;
use Paprika\utils\Renderer;
use Paprika\utils\SingletonDataBaseMariaDB;

class DefaultController extends BaseController
{
    private DAOPompiers $pompierDAO;
    private DAOCaserne $caserneDAO;

    public function __construct()
    {
        parent::__construct();
        $this->pompierDAO = new DAOPompiers(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
        $this->caserneDAO = new DAOCaserne(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
    }


    public function home(): void
    {
        $nbPompiers = $this->pompierDAO->count();
        $nbCasernes = $this->caserneDAO->count();
        echo Renderer::render('home', [
            'nbPompiers' => $nbPompiers,
            'nbCasernes' => $nbCasernes
        ]);
    }


    public function index(): void
    {
        $nbPompiers = $this->pompierDAO->count();
        $nbCasernes = $this->caserneDAO->count();
        echo Renderer::render('home', [
            'nbPompiers' => $nbPompiers,
            'nbCasernes' => $nbCasernes
        ]);
    }

    public function show(): void {}
    public function create(): void {}
    public function do_create($data): void {}
    public function update($id): void {}
    public function do_update($data): void {}
    public function delete($id): void {}
    public function do_delete($id): void {}
    public function detail($id): void {}
}