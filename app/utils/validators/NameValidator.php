<?php

namespace Paprika\utils\validators;

use Paprika\utils\validators\InterfaceValidator;

class NameValidator implements InterfaceValidator
{

    /** check if a name is correct
     * @param string $data
     * @return bool
     */
    public function validate(string $data): bool
    {
        // longueur
        if (strlen($data) < 3 || strlen($data) > 32) {
            return false;
        }
        // pas de nombre
        if (preg_match('/[0-9]/', $data)) {
            return false;
        }
        // Autoriser uniquement : lettres, espaces, tirets, apostrophes et accents
        // ^ = début, $ = fin, + = une ou plusieurs occurrences
        if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-\']+$/', $data)) {
            return false;
        }
        // pas vide ou uniquement des espaces
        if (empty(trim($data))) {
            return false;
        }

        return true;
    }
}