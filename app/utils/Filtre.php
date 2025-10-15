<?php

namespace Paprika\utils;

use Paprika\utils\validators\InterfaceValidator;

class Filtre
{
    private array $validators;

    public function __construct()  {}

    /** enregistre un validateur pour un clé spécifique
     * @param string $key
     * @param InterfaceValidator $validator
     * @return void
     */
    public function addValidator(string $key, InterfaceValidator $validator) : void {
        $this->validators[$key] = $validator;
    }

    /** exécute les validateur et stock le resultat (True | false) dans le array $result
     * @param array $data Data to validate
     * @return array associative array with $key => true | false
     */
    public function execute(array $data) : array {
        $result = [];

        foreach ($this->validators as $key => $validator) {
            $value = $data[$key] ?? null;
            $result[$key] = $validator->validate($value);
        }
        return $result;
    }
}
