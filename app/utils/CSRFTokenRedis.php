<?php

namespace Paprika\utils;

use Paprika\utils\CSRFToken;
use Random\RandomException;

class CSRFTokenRedis extends CSRFToken
{

    /**
     * @inheritDoc
     */
    public static function generateToken(): string
    {
        // TODO: Implement generateToken() method.
    }

    /**
     * @inheritDoc
     */
    public static function check(string $token): bool
    {
        // TODO: Implement check() method.
    }
}