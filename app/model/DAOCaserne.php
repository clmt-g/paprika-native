<?php

namespace Paprika\model;

use PDO;
use Paprika\utils\SingletonLogger;

class DAOCaserne {
    private PDO $pdo;
    private string $user = "selim"; // user pour le logging

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function find($id): ?Caserne {
        $stmt = $this->pdo->prepare("
            SELECT NumCaserne, Adresse, CP AS Cp, Ville, CodeTypeC, deleted
            FROM casernes
            WHERE NumCaserne = :id AND deleted = 0
        ");
        $stmt->execute(['id' => $id]);

        // Récupérer le logger
        $logger = SingletonLogger::getInstance()->getSQLLogger();

        // Log SQL avec user
        ob_start();
        $stmt->debugDumpParams();
        $message = ob_get_contents();
        ob_end_clean();
        $logger->info("User: {$this->user} - find():\n$message");

        $c = $stmt->fetchObject(Caserne::class);
        return $c ?: null;
    }

    public function save(Caserne $c): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO casernes (NumCaserne, Adresse, CP, Ville, CodeTypeC, deleted)
            VALUES (:num, :adr, :cp, :ville, :ctc, :deleted)
        ");

        $result = $stmt->execute([
            'num' => $c->getNumCaserne(),
            'adr' => $c->getAdresse(),
            'cp' => $c->getCp(),
            'ville' => $c->getVille(),
            'ctc' => $c->getCodeTypeC(),
            'deleted' => (int)$c->isDeleted()
        ]);

        // Logger l'action
        $logger = SingletonLogger::getInstance()->getSQLLogger();
        $logger->info("User: {$this->user} - save(): NumCaserne={$c->getNumCaserne()}");

        return $result;
    }

    public function update(Caserne $c): bool {
        $stmt = $this->pdo->prepare("
            UPDATE casernes 
            SET Adresse=:adr, CP=:cp, Ville=:ville, CodeTypeC=:ctc
            WHERE NumCaserne=:num AND deleted = 0
        ");
        $result = $stmt->execute([
            'adr' => $c->getAdresse(),
            'cp' => $c->getCp(),
            'ville' => $c->getVille(),
            'ctc' => $c->getCodeTypeC(),
            'num' => $c->getNumCaserne()
        ]);

        // Logger l'action
        $logger = SingletonLogger::getInstance()->getSQLLogger();
        $logger->info("User: {$this->user} - update(): NumCaserne={$c->getNumCaserne()}");

        return $result;
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("
            UPDATE casernes SET deleted = 1 WHERE NumCaserne = :id
        ");
        $result = $stmt->execute(['id' => $id]);

        // Logger l'action
        $logger = SingletonLogger::getInstance()->getSQLLogger();
        $logger->info("User: {$this->user} - delete(): NumCaserne={$id}");

        return $result;
    }

    public function findAll(int $max = 100): array {
        $stmt = $this->pdo->prepare("
            SELECT NumCaserne, Adresse, CP AS Cp, Ville, CodeTypeC, deleted
            FROM casernes
            WHERE deleted = 0
            LIMIT :max
        ");
        $stmt->bindValue('max', $max, PDO::PARAM_INT);
        $stmt->execute();

        // Logger l'action
        $logger = SingletonLogger::getInstance()->getSQLLogger();
        $logger->info("User: {$this->user} - findAll(): max={$max}");

        return $stmt->fetchAll(PDO::FETCH_CLASS, Caserne::class);
    }

    public function count(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM casernes WHERE deleted = 0");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Logger l'action
        $logger = SingletonLogger::getInstance()->getSQLLogger();
        $logger->info("User: {$this->user} - count()");

        return $row ? (int)$row['total'] : 0;
    }

    public function findByCity(string $city): array {
        $stmt = $this->pdo->prepare("
            SELECT NumCaserne, Adresse, CP AS Cp, Ville, CodeTypeC, deleted
            FROM casernes
            WHERE Ville=:ville AND deleted = 0
        ");
        $stmt->execute(['ville' => $city]);

        // Logger l'action
        $logger = SingletonLogger::getInstance()->getSQLLogger();
        $logger->info("User: {$this->user} - findByCity(): Ville={$city}");

        return $stmt->fetchAll(PDO::FETCH_CLASS, Caserne::class);
    }

    public function generateNextId(): int {
        $stmt = $this->pdo->query("SELECT MAX(NumCaserne) AS maxId FROM casernes");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Logger l'action
        $logger = SingletonLogger::getInstance()->getSQLLogger();
        $logger->info("User: {$this->user} - generateNextId()");

        return ($row['maxId'] !== null) ? (int)$row['maxId'] + 1 : 1;
    }
}