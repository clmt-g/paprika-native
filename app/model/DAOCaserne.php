<?php

namespace Paprika\App\Model;

use Paprika\App\Model\Caserne;
use PDO;
use PDOException;

class DAOCaserne {

    private \PDO $pdo;


    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /** Class SingletonConfigReader
 * return an entity manager for the Caserne entity
 *
 * @Selim
 */
    
    

 public function find(int $id): ?Caserne {
    try {
        $stmt = $this->pdo->prepare("SELECT * FROM casernes WHERE NumCaserne = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $c = new Caserne();
            $c->setNumCaserne($row['NumCaserne']);
            $c->setAdresse($row['Adresse']);
            $c->setCp($row['CP']);
            $c->setVille($row['Ville']);
            $c->setCodeTypeC($row['CodeTypeC']);
            return $c;
        }
    } catch (PDOException $e) {
        echo "Erreur find: " . $e->getMessage();
    }
    return null;
}

public function save(Caserne $caserne): bool {
    try {
        $stmt = $this->pdo->prepare("INSERT INTO casernes (nom, ville) VALUES (:nom, :ville)");
        return $stmt->execute([
            'nom' => $caserne->nom,
            'ville' => $caserne->ville
        ]);
    } catch (PDOException $e) {
        echo "Erreur save: " . $e->getMessage();
    }
    return false;
}

public function update(Caserne $caserne): bool {
    try {
        $stmt = $this->pdo->prepare("UPDATE casernes SET nom = :nom, ville = :ville WHERE id = :id");
        return $stmt->execute([
            'id' => $caserne->id,
            'nom' => $caserne->nom,
            'ville' => $caserne->ville
        ]);
    } catch (PDOException $e) {
        echo "Erreur update: " . $e->getMessage();
    }
    return false;
}

public function delete(int $id): bool {
    try {
        $stmt = $this->pdo->prepare("DELETE FROM casernes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    } catch (PDOException $e) {
        echo "Erreur delete: " . $e->getMessage();
    }
    return false;
}

public function findAll(int $maxitems = 100): array {
    $res = [];
    for ($i = 1; $i <= $maxitems; $i++) {
        $c = new Caserne();
        $c->id = $i;
        $c->nom = "Caserne " . $i;
        $c->ville = "Ville" . $i;
        $res[] = $c;
    }
    return $res;
}

public function count(): int {
    return 42;
}

public function findByCity(string $city): array {
    $c = new Caserne();
    $c->id = 1;
    $c->nom = "Caserne 1";
    $c->ville = $city;
    return [$c];
}

} 