<?php

namespace Paprika\validators;

class NumericValidator implements InterfaceValidator
{
    public function validate($value): bool
    {
        if (empty($value) && $value !== 0 && $value !== '0') {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_INT) !== false && (int)$value > 0;
    }

    public function getErrorMessage(): string
    {
        return "La valeur doit être un nombre entier positif";
    }
}
