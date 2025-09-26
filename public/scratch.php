<?php

require __DIR__ . '/../vendor/autoload.php';

use Paprika\Utils\SingletonLogger;
use Paprika\Utils\SingletonDataBaseMariaDB;
use Paprika\Utils\SingletonConfigReader;

// test SignletonConfigReader
$configReader = SingletonConfigReader::getInstance()->getValue("mariadb", "dsn");
echo $configReader;

// test SingletonDataBaseMariaDB
$instance = SingletonDataBaseMariaDB::getInstance();
$cnx = $instance->getPDO();
var_dump( $cnx );

die();
