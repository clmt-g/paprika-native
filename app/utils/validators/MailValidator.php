<?php

namespace Paprika\utils\validators;

class MailValidator implements InterfaceValidator
{
    public function validate(string $data): bool
    {
        return filter_var($data, FILTER_VALIDATE_EMAIL) !== false;
    }
}