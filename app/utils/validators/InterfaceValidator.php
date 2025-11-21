<?php

namespace Paprika\utils\validators;

interface InterfaceValidator
{
    public function validate(string $data) : bool;
}
