<?php

namespace Paprika\utils;

use PDO;
use Paprika\utils\SingletonLogger;

class LoggedPDO extends PDO
{
    private string $user;

    public function __construct(string $dsn, string $username = "", string $password = "", array $options = [])
    {
        parent::__construct($dsn, $username, $password, $options);

        // Récupérer l'utilisateur depuis la session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->user = $_SESSION['auth']['login'] ?? 'anonyme';

        // Définir la classe de statement personnalisée
        $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, [
            LoggedPDOStatement::class,
            [SingletonLogger::getInstance()->getSQLLogger(), $this->user]
        ]);

        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}