<?php

namespace Paprika\utils\Validators;

class CodePostalValidator implements InterfaceValidator
{

    public function validate(string $data): bool
    {
        return preg_match('/^[0-9]{5}$/', $data) === 1;
    }
}