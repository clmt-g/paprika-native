<?php

namespace Paprika\Utils;

/** Class SingletonConfigReader
 * Is used to read the data in config.ini
 *
 * @author Clément
 */

class SingletonConfigReader
{
    private static $instance;
    private $data = [];

    private function __construct()
    {
        $chemin = __DIR__ . "/../../config.ini";
        if (!file_exists($chemin)) {
            throw new \Exception("Le fichier de configuration n'existe pas ou n'est pas trouvé");
        }
        $this->data = parse_ini_file($chemin, true);
        if ($this->data === false) {
            throw new \Exception("Il y a des erreurs dans le fichier de configuration");
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
        if($section === null) {
        return $this->data[$key] ?? null;
        }
        return $this->data[$section][$key] ?? null;
    }
}
