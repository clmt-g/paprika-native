<?php

class SingletonLogger
{
    private static $instance;

    private $sqllogger;

    private $authlogger;

    private function __construct()
    {

        $SQLLoggerLevel = "WARNING" ;
        $AuthLoggerLevel = "DEBUG" ;

    }

    public static function getInstance(): SingletonLogger
    {
        if (is_null(self::$instance)) { 
            self::$instance = new SingletonLogger();
        }
        return self::$instance;
    }

    public function getAuthLogger()
    {
        
    }

    public function getSQLLogger()
    {
        
    }
}