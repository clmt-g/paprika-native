<?php

namespace Paprika\utils;

class SingletonConfigReader
{
    private static $instance;

    private $date = [];

    private function __construct()
    {
        // to do implementation a finir 
    }

    /**
     * return the singleton instance
     * @return SingletonConfigReader
     */ 
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new SingletonConfigReader();
        }

        return self::$instance;
    }

    /**
     * return a value associated to the key in one section
     * @return ?string
     */ 
    public function getValue(string $key, string $section = null): ?string
    {
        return null;
    }
}