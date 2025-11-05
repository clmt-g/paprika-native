<?php

namespace Paprika\utils;

abstract class CRSFToken
{
    private static $token_name = "crsf_token";

    /** Generate and return the token, store the token with timestamp
     * @return string
     */
    public static abstract function generateToken(): string;

    /** Check the validity of the token and lifetime. Destroy the token if it matches (burn the token)
     * @param string $token
     * @return bool
     */
    public static abstract function check(string $token): bool;
}