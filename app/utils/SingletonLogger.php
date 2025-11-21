<?php

namespace Paprika\utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

class SingletonLogger
{
    private static $instance;

    private Logger $sqlLogger;
    private Logger $errorLogger;
    private Logger $authlogger;

    private function __construct()
    {
        $config = SingletonConfigReader::getInstance();

        //insert
        // Fonction simple pour convertir texte en niveau Monolog
        $getLevel = function(?string $value, int $default): int {
            if (!$value) { return $default; }

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

        //  la config
        $sqlLevel   = $getLevel($config->getValue("sql", "logs"), Logger::WARNING);
        $errorLevel = $getLevel($config->getValue("error", "logs"), Logger::ERROR);

        //  logger SQL
        $this->sqlLogger = new Logger("sql");
        $this->sqlLogger->pushHandler(new StreamHandler(__DIR__ . "/../../storage/sqll.log", $sqlLevel));

        //  logger Error
        $this->errorLogger = new Logger("error");
        $this->errorLogger->pushHandler(new StreamHandler(__DIR__ . "/../../storage/errorr.log", $errorLevel));

        // Auth logger
        $AUTHLoggerLevel = Level::Debug;
        $authhandler = new StreamHandler('../../paprika/storage/auth.log', $AUTHLoggerLevel);
        $this->authlogger = new Logger("AuthLogger"); // création d'un nouveau Logger pour Auth
        $this->authlogger->pushHandler($authhandler);

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

    public function getAuthLogger()
    {
        return $this->authlogger;
    }
}