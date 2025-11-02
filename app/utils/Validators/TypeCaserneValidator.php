<?php

namespace Paprika\validators;

class TypeCaserneValidator implements InterfaceValidator
{
    public function validate($value): bool
    {
        if (empty($value)) {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_INT) !== false && (int)$value > 0;
    }

    public function getErrorMessage(): string
    {
        return "Le type de caserne doit être un nombre entier valide";
    }
}