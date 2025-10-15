<?php

namespace Paprika\utils\Validators;

class MailValidator implements InterfaceValidator
{

    public function validate(string $data): bool
    {
        return filter_var($data, FILTER_VALIDATE_EMAIL) !== false;
    }

    //il at faire en sorte que le mail soit possible avec le eleve.leschartreux.net

}