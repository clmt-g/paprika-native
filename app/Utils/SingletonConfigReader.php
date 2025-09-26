<?php

namespace Paprika\Utils;

/** Class SingletonConfigReader
 * Is used to read the data in config.ini
 *
 * @Clément
 */

class SingletonConfigReader
{
    private static $instance;
    private $data = [];

    private function __construct()
    {
        $chemin = __DIR__ . "/../../config.ini";
        if (file_exists($chemin)) {
            $this->data = parse_ini_file($chemin, true) ?: [];
        } else {
            $this->data = [];
        }
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

    public function getValue(string $key, ?string $section = null): ?string
    {
        try {
            if($section === null) {
            return $this->data[$key] ?? null;
            }
            return $this->data[$section][$key] ?? null;
        }
        catch (\Exception $e) {
            return null;
        }
    }
}
