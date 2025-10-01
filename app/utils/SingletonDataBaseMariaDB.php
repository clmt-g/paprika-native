<?php

namespace Paprika\utils;

use Monolog\Logger;
use \Paprika\utils\SingletonConfigReader;
use \PDO;
use \Paprika\utils\LoggedPDO;

/** Class SingletonDataBaseMariaDB
 * Is used to create a single connection to the database
 *
 * @author Selim
 */

class SingletonDataBaseMariaDB
{
    // typage possible grace a php 8...

    private static $instance;
    private PDO $pdo;
    private Logger $loggedPDO;

    private function __construct(){
        $config = SingletonConfigReader::getInstance();

        $dsn = $config->getValue("dsn", "mariadb");
        $username = $config->getValue("user", "mariadb");
        $password = $config->getValue("password", "mariadb");


        $this->pdo = new PDO($dsn,$username,$password); //version propre
        // $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() : SingletonDataBaseMariaDB {
        if (is_null(self::$instance)){
            self::$instance = new SingletonDataBaseMariaDB();
        }
        return self::$instance;
    }

    public function getPDO() : PDO {
        return $this->pdo;
    }
    public function getLoggedPDO(): LoggedPDO {
        return $this->loggedPDO;
    }
}
