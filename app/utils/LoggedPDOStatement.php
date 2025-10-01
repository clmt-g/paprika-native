<?php

namespace Paprika\utils;

use PDOStatement;
use PDO;
use Monolog\Logger;

class LoggedPDOStatement extends PDOStatement
{
    protected Logger $logger;
    protected string $user;

    // Le constructeur est appelé par PDO via ATTR_STATEMENT_CLASS
    protected function __construct(Logger $logger, string $user)
    {
        $this->logger = $logger;
        $this->user = $user;
    }

    public function execute($params = null): bool
    {
        $result = parent::execute($params);

        // Debug SQL
        ob_start();
        $this->debugDumpParams();
        $message = ob_get_contents();
        ob_end_clean();

        // Log SQL + user
        $this->logger->info("User: {$this->user} - Executed SQL:\n$message");

        return $result;
    }
}