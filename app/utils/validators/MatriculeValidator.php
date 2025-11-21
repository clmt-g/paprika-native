<?php

namespace Paprika\utils\validators;

class MatriculeValidator implements \Paprika\utils\validators\InterfaceValidator
{
    /** ensure that a Matricule has the right format
     * @param string $data
     * @return bool
     */
    public function validate(string $data): bool
    {
        // Vérifier que la chaîne n'est pas vide
        if (empty($data)) {
            return false;
        }

        // Vérifier le format exact : P suivi de 6 chiffres
        return preg_match('/^P\d{6}$/', $data) === 1;
    }
}