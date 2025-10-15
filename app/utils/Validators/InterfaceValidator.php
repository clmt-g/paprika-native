<?php

namespace Paprika\utils\Validators;

interface InterfaceValidator
{

    public function validate(string $data): bool;
}