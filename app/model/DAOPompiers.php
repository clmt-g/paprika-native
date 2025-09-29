<?php

namespace Paprika\model;

use Paprika\Utils\SingletonDataBaseMariaDB;
use Paprika\model\Pompiers;

/**
 * Classe DAOPompiers, qui met à disposition un CRUD pour la classe Pompiers
 * @author Clément
 */

class DAOPompiers
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Return an entity according to the key $id
     * @param string $id
     * @return ?Pompiers
     */
    public function find(string $id): ?Pompiers {
        $instanceMariaDB = SingletonDataBaseMariaDB::getInstance();
        $cnx = $instanceMariaDB->getPDO();

        $SQL = "SELECT * FROM pompiers WHERE Matricule=:id";
        $preparedStatement = $cnx->prepare("$SQL");
        $preparedStatement->bindValue("id", $id);
        $preparedStatement->execute();
        $pompier = $preparedStatement->fetchObject(Pompiers::class);

        if ($pompier === false) {
            return null;
        }
        
        return $pompier;
        // FIXME : log des requêtes
    }

    /**
     * Return True when the key $pompier was successfuly added to the database
     * @param \Paprika\model\Pompiers $pompier
     * @return bool
     */
    public function save(Pompiers $pompier): bool {
        // attention au deleted
    }

    /**
     * Summary of update
     * @param \Paprika\model\Pompiers $pompier
     * @return bool
     */
    public function update(Pompiers $pompier): bool {
        // attention au deleted
    }

    /**
     * Summary of delete
     * @param \Paprika\model\Pompiers $pompier
     * @return bool
     */
    public function delete(Pompiers $pompier): bool {
        // ne pas supprimer, ajouter un champ DELETED
    }

    /**
     * Summary of findAll
     * @return array
     */
    public function findAll(int $maxItems = 100): array {
        // Attention au DELETED
    }

    /**
     * Summary of count
     * @return int
     */
    public function count(): int {
        // attention au DELETED
    }

    /**
     * Summary of findByGrade
     * @param string $grade
     * @return ?Pompiers
     */
    public function findByGrade(string $grade): ?Pompiers {
        // Attention au DELETED
    }

}
