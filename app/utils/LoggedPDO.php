<?php

namespace Paprika\utils;

use PDO;

class LoggedPDO extends PDO
{
    public function __construct(string $dsn, string $username = "", string $password = "", array $options = [])
    {
        parent::__construct($dsn, $username, $password, $options);

        // Définir la classe de statement personnalisée
        $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, [
            LoggedPDOStatement::class,
            [SingletonLogger::getInstance()->getSQLLogger(), "selim"]
        ]);

        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}