<?php

namespace Paprika\utils\Validators;

class PhoneValidator implements InterfaceValidator
{
    public function validate(string $data): bool
    {
        // Supprime les espaces pour simplifier la validation
        $cleaned = str_replace(' ', '', $data);

        // Regex : commence par 0 ou +33, suivi de 9 chiffres
        return preg_match('/^(0[1-9]\d{8}|\+33[1-9]\d{8})$/', $cleaned) === 1;
        return preg_match('/^(0[1-9]\d{8}|\++49[1-13]\d{8})$/', $cleaned) === 1;

    }
}