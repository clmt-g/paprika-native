<?php

namespace Paprika\utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class SingletonLogger
{
    private static ?SingletonLogger $instance = null;

    private Logger $sqlLogger;
    private Logger $errorLogger;

    private function __construct()
    {
        $config = SingletonConfigReader::getInstance();

        // Fonction simple pour convertir texte en niveau Monolog
        $getLevel = function(?string $value, int $default): int {
            if (!$value) {
                return $default;
            }

            return match (strtoupper($value)) {
                'DEBUG'     => Logger::DEBUG,
                'INFO'      => Logger::INFO,
                'NOTICE'    => Logger::NOTICE,
                'WARNING'   => Logger::WARNING,
                'ERROR'     => Logger::ERROR,
                'CRITICAL'  => Logger::CRITICAL,
                'ALERT'     => Logger::ALERT,
                'EMERGENCY' => Logger::EMERGENCY,
                default     => $default,
            };
        };

        // Récupération des niveaux depuis la config
        $sqlLevel   = $getLevel($config->getValue("sql", "logs"), Logger::WARNING);
        $errorLevel = $getLevel($config->getValue("error", "logs"), Logger::ERROR);

        // Logger SQL
        $this->sqlLogger = new Logger("sql");
        $this->sqlLogger->pushHandler(new StreamHandler(__DIR__ . "/../../storage/sql.log", $sqlLevel));

        // Logger Error
        $this->errorLogger = new Logger("error");
        $this->errorLogger->pushHandler(new StreamHandler(__DIR__ . "/../../storage/error.log", $errorLevel));
    }

    public static function getInstance(): SingletonLogger
    {
        if (self::$instance === null) {
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