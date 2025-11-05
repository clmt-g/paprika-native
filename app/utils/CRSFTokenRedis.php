<?php

namespace Paprika\utils;

use Paprika\utils\CRSFToken;

class CRSFTokenRedis extends CRSFToken
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