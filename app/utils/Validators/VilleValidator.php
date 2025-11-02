<?php

namespace Paprika\validators;

class VilleValidator implements InterfaceValidator
{
    public function validate($value): bool
    {
        if (empty($value) || !is_string($value)) {
            return false;
        }

        $trimmed = trim($value);
        $length = strlen($trimmed);

        if ($length === 0 || $length > 20) {
            return false;
        }

        return preg_match('/^[a-zA-ZÀ-ÿ\s\-\']+$/u', $trimmed) === 1;
    }

    public function getErrorMessage(): string
    {
        return "La ville doit contenir maximum 20 caractères (lettres uniquement)";
    }
}