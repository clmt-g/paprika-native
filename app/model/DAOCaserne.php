<?php

namespace Paprika\model;
//a
use PDO;
use Paprika\utils\SingletonLogger;

class DAOCaserne {
    private PDO $pdo;
    private string $user = "selim"; // user

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

        return $stmt->fetchObject(Caserne::class) ?: null;
    }

    public function save(Caserne $c): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO casernes (NumCaserne, Adresse, CP, Ville, CodeTypeC, deleted)
            VALUES (:num, :adr, :cp, :ville, :ctc, :deleted)
        ");
        return $stmt->execute([
            'num' => $c->getNumCaserne(),
            'adr' => $c->getAdresse(),
            'cp' => $c->getCp(),
            'ville' => $c->getVille(),
            'ctc' => $c->getCodeTypeC(),
            'deleted' => (int)$c->isDeleted()
        ]);
    }

    public function update(Caserne $c): bool {
        $stmt = $this->pdo->prepare("
            UPDATE casernes 
            SET Adresse=:adr, CP=:cp, Ville=:ville, CodeTypeC=:ctc
            WHERE NumCaserne=:num AND deleted = 0
        ");
        return $stmt->execute([
            'adr' => $c->getAdresse(),
            'cp' => $c->getCp(),
            'ville' => $c->getVille(),
            'ctc' => $c->getCodeTypeC(),
            'num' => $c->getNumCaserne()
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("
            UPDATE casernes SET deleted = 1 WHERE NumCaserne = :id
        ");
        return $stmt->execute(['id' => $id]);
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
        return $stmt->fetchAll(PDO::FETCH_CLASS, Caserne::class);
    }

    public function count(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM casernes WHERE deleted = 0");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['total'] : 0;
    }

    public function findByCity(string $city): array {
        $stmt = $this->pdo->prepare("
            SELECT NumCaserne, Adresse, CP AS Cp, Ville, CodeTypeC, deleted
            FROM casernes
            WHERE Ville=:ville AND deleted = 0
        ");
        $stmt->execute(['ville' => $city]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Caserne::class);
    }

    public function generateNextId(): int {
        $stmt = $this->pdo->query("SELECT MAX(NumCaserne) AS maxId FROM casernes");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row['maxId'] !== null) ? (int)$row['maxId'] + 1 : 1;
    }
}