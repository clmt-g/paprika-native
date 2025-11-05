<?php

namespace Paprika\utils;

abstract class CSRFToken
{
    protected static string $token_name = "csrf_token";

    /**
     * Generate and return the token, store the token with timestamp
     *
     * @return string
     */
    abstract public static function generateToken(): string;

    /**
     * Check if the provided token is valid
     *
     * @param string $token
     * @return bool
     */
    abstract public static function check(string $token): bool;
}