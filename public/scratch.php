<?php


require_once __DIR__ . "/../app/utils/SingletonLogger.php";

use Paprika\utils\SingletonLogger;
use Paprika\utils\SingletonDataBaseMariaDB;

// Logger 
$logger = SingletonLogger::getInstance();
$authLogger = $logger->getAuthLogger();
$sqlLogger = $logger->getSQLLogger();

$authLogger("Test Auth : utilisateur connecte", "INFO");
$authLogger("Test Auth : echec connexion", "ERROR");
$sqlLogger("Test SQL : requete executee", "WARNING");
$sqlLogger("Test SQL : erreur connexion DB", "ERROR");


$pdo1 = SingletonDataBaseMariaDB::getInstance()->getPdo();
$pdo2 = SingletonDataBaseMariaDB::getInstance()->getPdo();
assert($pdo1 == $pdo2);


$configReader = \Paprika\Utils\SingletonConfigReader::getInstance()->getValue("mariadb", "dsn");
echo $configReader;

$db = \Paprika\Utils\SingletonDataBaseMariaDB::getInstance();
$cnx = $db->getPDO();

var_dump($cnx);

die();


die();


//echo "Hello world";

// $c = new \Paprika\Dummy();

// $c->greeting();

