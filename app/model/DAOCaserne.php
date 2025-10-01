<?php

namespace Paprika\model;

use PDO;
use PDOException;

class DAOCaserne {
    private PDO $pdo;

    
    public function __construct(PDO $pdo) { 
        $this->pdo = $pdo; 
    }

    /** Class SingletonConfigReader
 * return an entity manager for the Caserne entity
 *
 * @Selim
 */



    public function find($id) {
        $stmt = $this->pdo->prepare("
        SELECT NumCaserne, Adresse, CP AS Cp, Ville, CodeTypeC
        FROM casernes
        WHERE NumCaserne = :id AND deleted = 0
    ");
        $stmt->execute(['id' => $id]);
        $c = $stmt->fetchObject(Caserne::class);
        return $c ? $c : null;
    }

    public function save(Caserne $c): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO casernes (NumCaserne, Adresse, CP, Ville, CodeTypeC, deleted)
             VALUES (:num, :adr, :cp, :ville, :ctc, 0)"
        );

        return $stmt->execute([
            'num' => $c->getNumCaserne(),
            'adr' => $c->getAdresse(),
            'cp' => $c->getCp(),
            'ville' => $c->getVille(),
            'ctc' => $c->getCodeTypeC()
        ]);
    }
 
public function update(Caserne $c): bool { 
    $stmt = $this->pdo->prepare(
        "UPDATE casernes 
         SET Adresse=:adr, CP=:cp, Ville=:ville, CodeTypeC=:ctc 
         WHERE NumCaserne=:num AND deleted = 0"
    );

    return $stmt->execute([
        'adr' => $c->getAdresse(),
        'cp' => $c->getCp(),
        'ville' => $c->getVille(),
        'ctc' => $c->getCodeTypeC(),
        'num' => $c->getNumCaserne()
    ]);
}

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE casernes SET deleted = 1 WHERE NumCaserne = :id"
        );
        return $stmt->execute(['id' => $id]);
    }


    public function findAll(int $max = 100): array {
        $stmt = $this->pdo->prepare("
        SELECT NumCaserne, Adresse, CP AS Cp, Ville, CodeTypeC
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
        SELECT NumCaserne, Adresse, CP AS Cp, Ville, CodeTypeC
        FROM casernes
        WHERE Ville=:ville AND deleted = 0
    ");
    $stmt->execute(['ville' => $city]);
    return $stmt->fetchAll(PDO::FETCH_CLASS, Caserne::class);
}

} 