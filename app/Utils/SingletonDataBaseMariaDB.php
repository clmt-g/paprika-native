<?php

namespace Paprika\utils;

class SingletonDataBaseMariaDB

{

    // typage possible grace a php 8...

    private static $instance;
    private PDO $pdo;

    private function __construct(){
        // TODO : read values from config.ini using SinglutonConfigReader
        $dsn="mysql:host=localhost;dbname=worlddb25;charset=utf8mb4";
        $username="worlddbuser25";
        $password="User@dmin!";

        $this->pdo =new \PDO($dsn,$username,$password);       //version propre  
     // $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ajouter "attribute ,value"
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ajouter "attribute ,value"

        
    }

    public static function getInstance() : SingletonDataBaseMariaDB {
        if (is_null(self::$instance)){ 
            self::$instance = new SingletonDataBaseMariaDB();
        }
        return self::$instance;
    }


    public function getPDO() : \PDO{

        return $this->pdo;

    }

    
} 