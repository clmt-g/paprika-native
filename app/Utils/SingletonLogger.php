<?php

namespace Paprika\Utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class SingletonLogger
{
    private static $instance;

    private Logger $sqlLogger;
    private Logger $errorLogger;

    private function __construct()
    {
        $config = SingletonConfigReader::getInstance();

        // Lecture [log] dans config.ini
        $sqlLevel   = $this->mapLevel($config->getValue("logs", "sql") ?? "WARNING");
        $errorLevel = $this->mapLevel($config->getValue("logs", "error") ?? "ERROR");

        // Création logger SQL
        $this->sqlLogger = new Logger("sql");
        $this->sqlLogger->pushHandler(
            new StreamHandler(__DIR__ . "/../../sql.log", $sqlLevel)
        );

        // Création logger Error
        $this->errorLogger = new Logger("error");
        $this->errorLogger->pushHandler(
            new StreamHandler(__DIR__ . "/../../error.log", $errorLevel)
        );
    }

    public static function getInstance(): SingletonLogger
    {
        if (is_null(self::$instance)) {
            self::$instance = new SingletonLogger();
        }
        return self::$instance;
    }

    public function getSQLLogger(): Logger
    {
        return $this->sqlLogger;
    }

    public function getErrorLogger(): Logger
    {
        return $this->errorLogger;
    }

    
    
}