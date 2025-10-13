<?php

namespace Paprika\utils;

use Paprika\utils\validators\InterfaceValidator;

class Filtre
{
    public function __construct()  {

    }

    public function addValidator(string $key, InterfaceValidator $validator) : void {
        // TODO
    }

    /**
     * @param array $data Data to validate
     * @return array associative array with $key => true | false
     */
    public function execute(array $data) : array {
        // TODO : a finir
        return [];
    }
}
