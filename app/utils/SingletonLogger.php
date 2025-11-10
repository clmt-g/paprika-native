<?php
namespace Paprika\utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class SingletonLogger
{
    private static ?SingletonLogger $instance = null;
    private ?Logger $sqlLogger = null;
    private ?Logger $errorLogger = null;

    private function __construct()
    {
        $this->sqlLogger = new Logger("sql");
        $this->sqlLogger->pushHandler(new StreamHandler(__DIR__ . "/../../storage/sql.log", Logger::INFO));

        $this->errorLogger = new Logger("error");
        $this->errorLogger->pushHandler(new StreamHandler(__DIR__ . "/../../storage/error.log", Logger::ERROR));
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