<?php

/**
     * returne Singleton Logger 
     * @return SingletonLogger
     */ 


namespace Paprika\utils;

class SingletonLogger
{
    private static $instance;

    private $sqllogger;

    private $authlogger;

    private function __construct()
    {
        $this->authlogger = function($message, $level = "DEBUG") {
            file_put_contents('auth.log', "[".date('Y-m-d H:i:s')."] [$level] $message\n", FILE_APPEND);
        };
    
        $this->sqllogger = function($message, $level = "WARNING") {
            file_put_contents('sql.log', "[".date('Y-m-d H:i:s')."] [$level] $message\n", FILE_APPEND);
        };

    }

    public static function getInstance(): SingletonLogger
    {
        if (is_null(self::$instance)) { 
            self::$instance = new SingletonLogger();
        }
        return self::$instance;
    }

    public function getAuthLogger(): callable
    {
        return $this->authlogger;
    }

        public function getSQLLogger(): callable // callable quelque chose qu’on peut appeler comme une fonction qui permet de renvoyer cette fonction pour que d’autres parties du code puissent l’utiliser sans savoir comment elle est définie à l’intérieur.
        {
        return $this->sqllogger;
    }
}




