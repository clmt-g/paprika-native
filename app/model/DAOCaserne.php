<?php

namespace Paprika\App\Model;

use Paprika\App\Entity\Caserne;
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
        $stmt = $this->pdo->prepare("SELECT * FROM casernes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetchObject(Caserne::class);

        return $result ?: null;
    }
    public function save(Caserne $caserne): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO casernes (nom, ville, adresse)
            VALUES (:nom, :ville, :adresse)
        ");
        return $stmt->execute([
            'nom' => $caserne->nom,
            'ville' => $caserne->ville,
            'adresse' => $caserne->adresse
        ]);
    }

    public function update(Caserne $caserne): bool {
        //todo : a completer
        
        
    }

    public function delete(int $id): bool {
        //todo : a completer
        
        
    }

    public function findAll(int $maxitems = 100): array {
        //todo : a completer
        
    }

    public function count(): int {
        //todo : a completer
    }

    public function findByCity(string $city ): array {
        //todo : a completer
    }

} 