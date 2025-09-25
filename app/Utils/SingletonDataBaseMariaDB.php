<?php
/**
     * returne Singleton Database MariaDB
     * @return SingletonDataBaseMariaDB
     */ 

namespace Paprika\utils;

class SingletonDataBaseMariaDB
{
    private static $instance;
    private \PDO $pdo; // <-- bien avec le backslash

    private function __construct() {

        $config = SingletonConfigReader::getInstance();

        $dsn = $config->get ('mariadb','dns');
        $username = $config->get ('mariadb','user');
        $password = $config->get ('mariadb','password');

        $this->pdo = new \PDO($dsn, $username, $password); 
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(): SingletonDataBaseMariaDB {
        if (is_null(self::$instance)) {
            self::$instance = new SingletonDataBaseMariaDB();
        }
        return self::$instance;
    }

    public function getPDO(): \PDO {
        return $this->pdo;
    }
}