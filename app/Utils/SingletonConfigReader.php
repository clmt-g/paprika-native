<?php

namespace Paprika\utils;

class SingletonConfigReader
{
    private static $instance;
    private $data = [];

    private function __construct()
    {
        $this->data = parse_ini_file(__DIR__ . "/../../config.ini", true);
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
    public function getValue(string $section, string $key): ?string
    {
        return $this->data[$section][$key] ?? null;
    }
}
