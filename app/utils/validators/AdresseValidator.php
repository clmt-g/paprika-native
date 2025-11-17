<?php

namespace Paprika\utils\validators;

use Paprika\utils\validators\InterfaceValidator;

class AdresseValidator implements InterfaceValidator
{
    public function validate($value): bool
    {
        if (empty($value)) return false;
        $length = strlen(trim($value));
        return $length >= 5 && $length <= 255;
    }

    public function getErrorMessage(): string
    {
        return "Adresse invalide (5-255 caractères requis)";
    }

}
