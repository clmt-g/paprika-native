<?php

namespace Paprika\utils;

use PDO;
use PDOStatement;

class LoggedPDOStatement extends PDOStatement

    // il est possibe de modifier la classe PDOStatement renvoyer : $pdo->setAttribute(PDO::ATTR_STATEMENT_CLASS, [Custom::class]);
    // cf https://stackoverflow.com/questions/3431305/extending-pdo-statement-class
    //https://stackoverflow.com/questions/2411182/how-to-debug-pdo-database-queries
    //Sinon utilisation d'un decorator comme ici
{
    private PDOStatement $statement;

    {
        $this->statement = $statement;
    }

    public function execute($params = null): bool
    {
        echo "LOGGIN------------------------------------------------------------------\n";
        $result = $this->statement->execute($params);
        if ($this->statement->errorCode() != PDO::ERR_NONE) {
            $errors = $this->statement->errorInfo();
        }
        ob_start();
        $this->statement->debugDumpParams();
        $message = ob_get_contents();
        ob_end_clean();
        echo $message;
        //log $error content
        //log $message content
        return $result;
    }

    public function bindValue(int|string $param, mixed $value, int $type = PDO::PARAM_STR): bool
    {
        return $this->statement->bindValue($param, $value, $type);
    }

    public function fetchAll(int $mode = PDO::FETCH_DEFAULT, ...$args): array
    {
        // operateur splat : '...' cf https://dev.to/kiranparajuli589/splat-operator-in-php-3ija
        return $this->statement->fetchAll($mode, ...$args);
    }

    public function fetch(int $mode = PDO::FETCH_DEFAULT, int $cursorOrientation = PDO::FETCH_ORI_NEXT, int $cursorOffset = 0): mixed
    {
        // operateur splat : '...' cf https://dev.to/kiranparajuli589/splat-operator-in-php-3ija
        return $this->statement->fetch($mode, $cursorOrientation, $cursorOffset);
    }

    public function fetchObject(?string $class = "stdClass", array $constructorArgs = []): object|false
    {
        return $this->statement->fetchObject($class, $constructorArgs);
    }

    public function setFetchMode($mode = PDO::FETCH_DEFAULT, ...$args) : true
    {
         $this->statement->setFetchMode($mode, ...$args);
    }

}
