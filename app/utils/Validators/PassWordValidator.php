<?php

namespace Paprika\utils\Validators;

class PassWordValidator implements InterfaceValidator
{

    public function validate(string $data): bool
    {
        return strlen($data) >= 12
            && preg_match('/[A-Z]/', $data)
            && preg_match('/[a-z]/', $data)
            && preg_match('/[0-9]/', $data)
            && preg_match('/[\W]/', $data);
    }
}