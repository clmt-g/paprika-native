<?php

namespace Paprika\utils\validators;

class PasswordValidator implements InterfaceValidator
{

    public function validate(string $data): bool
    {
        if (strlen($data) < 12) {
            return false;
        }
        if (!preg_match('/[a-z]/', $data)) {
            return false;
        }
        if (!preg_match('/[A-Z]/', $data)) {
            return false;
        }
        if (!preg_match('/[0-9]/', $data)) {
            return false;
        }
        if (!preg_match('/\W/', $data)) {
            return false;
        }
        return true;
    }
}