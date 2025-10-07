<?php

namespace Paprika\controller;

use Paprika\model\DAOCaserne;
use Paprika\utils\SingletonConfigReader;

class CaserneController extends BaseController
{

    private DAOCaserne $daoCaserne;

    public function __construct(){
        parent::__construct();
        $this->daoCaserne = new DAOCaserne(SingletonConfigReader::getInstance()->getLoggedPDO());
    }


    public function create() : string {

        //Invocation du renderer qui renvoie la page avec le formulaire
        return ""; //FIXME :)
    }

    public  function do_create($data) {


    }

    public function update($id) {

    }

    public function do_update($id, $data) {



    }


}