<?php

namespace Paprika\utils;

use PDO;
use Paprika\utils\LoggedPDO;
use Paprika\utils\SingletonConfigReader;

class SingletonDataBaseMariaDB
{
    private static ?self $instance = null;
    private PDO $pdo;
    private LoggedPDO $loggedPDO;

    private function __construct()
    {
        $config = SingletonConfigReader::getInstance();

        $dsn = $config->getValue("dsn", "mariadb");
        $username = $config->getValue("user", "mariadb");
        $password = $config->getValue("password", "mariadb");

        // PDO normal
        $this->pdo = new PDO($dsn, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // PDO loggé
        $this->loggedPDO = new LoggedPDO($dsn, $username, $password);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    public function getLoggedPDO(): LoggedPDO
    {
        return $this->loggedPDO;
    }
}