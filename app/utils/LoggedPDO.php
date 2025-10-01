<?php

namespace Paprika\utils;

use PDOStatement;

class LoggedPDO extends \PDO
{
    /**
     * @return LoggedPDOStatement|false
     */
    public function prepare(string $query, array $options = []): PDOStatement|false
    {
        $statement = parent::prepare($query, $options);
        if ($statement == false) {
            return false;
        }
        //cf $pdo->setAttribute(PDO::ATTR_STATEMENT_CLASS, [Custom::class]);
    }
}
