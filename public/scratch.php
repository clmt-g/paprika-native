<?php

require __DIR__ . '/../vendor/autoload.php';

use Paprika\Utils\SingletonLogger;
use Paprika\Utils\SingletonDataBaseMariaDB;
use Paprika\Utils\SingletonConfigReader;

// --- Test SingletonConfigReader ---
$configReader = SingletonConfigReader::getInstance()->getValue("mariadb", "dsn");
echo $configReader . "\n";

// --- Test SingletonDataBaseMariaDB ---
$instance = SingletonDataBaseMariaDB::getInstance();
$cnx = $instance->getPDO();
var_dump($cnx);

// --- Test SingletonLogger ---
$logger = SingletonLogger::getInstance();

// Log SQL simulé
$logger->getSQLLogger()->info("Test SQL : connexion réussie");

// Log d'erreur simulé
try {
    throw new Exception("Test Error : fichier introuvable");
} catch (Exception $e) {
    $logger->getErrorLogger()->error($e->getMessage());
}

echo "Logs écrits dans sql.log et error.log\n";