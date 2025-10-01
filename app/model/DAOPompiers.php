<?php

namespace Paprika\model;

use Exception;
use Paprika\utils\SingletonDataBaseMariaDB;
use Paprika\utils\SingletonLogger;
use Paprika\model\Pompiers;
use PDO;

/**
 * Classe DAOPompiers, qui met à disposition un CRUD pour la classe Pompiers
 * @author Clément
 */

class DAOPompiers
{
    private \PDO $pdo;
    private string $user = "user";

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Return an entity according to the key $id
     * @param string $id
     * @return ?Pompiers
     */
    public function find(string $id): ?Pompiers {
        $pdo = SingletonDataBaseMariaDB::getInstance()->getPDO();

        $sql = "SELECT * FROM pompiers WHERE Matricule=:id AND deleted = 0";
        $preparedStatement = $pdo->prepare("$sql");
        $preparedStatement->bindValue("id", $id);
        $preparedStatement->execute();

        if ($row = $preparedStatement->fetch(\PDO::FETCH_ASSOC)) {
            $pompier = new Pompiers(
                $row['Prenom'],
                $row['Nom'],
                $row['ChefAgret'],
                $row['DateNaissance'],
                (int)$row['NumCaserne'],
                $row['CodeGrade'],
                $row['MatriculeRespo'],
                $row["Matricule"]
            );
        } else {
            return null;
        }
        return $pompier;
        // FIXME : log des requêtes
    }

    /**
     * Return True when the key $pompier was successfuly added to the database, false if an error was encountered, and get updated if the $pompier already have a matricule
     * @param \Paprika\model\Pompiers $pompier
     * @return bool
     */
    public function save(Pompiers $pompier): bool {
        $matricule = $pompier->getMatricule();
        if ($matricule === "") {
            try {
                // calcule du matricule et modification du matricule du pompier
                $matricule = $this->keyGenerator();
                $pompier->setMatricule($matricule);

                // requete
                $pdo = SingletonDataBaseMariaDB::getInstance()->getPDO();
                $sql = "INSERT INTO pompiers (Matricule, Prenom, Nom, ChefAgret, DateNaissance, NumCaserne, CodeGrade, MatriculeRespo) 
                        VALUES (:matricule, :prenom, :nom, :chefAgret, :dateNaissance, :numCaserne, :codeGrade, :matriculeRespo, 0)";
                $preparedStatement = $pdo->prepare("$sql");
                $preparedStatement->bindValue("matricule", $pompier->getMatricule(), PDO::PARAM_STR);
                $preparedStatement->bindValue("prenom", $pompier->getPrenom(), PDO::PARAM_STR);
                $preparedStatement->bindValue("nom", $pompier->getNom(), PDO::PARAM_STR);
                $preparedStatement->bindValue("chefAgret", $pompier->getChefAgret(), PDO::PARAM_STR);
                $preparedStatement->bindValue("dateNaissance", $pompier->getDateNaissance(), PDO::PARAM_STR);
                $preparedStatement->bindValue("numCaserne", $pompier->getNumCaserne(), PDO::PARAM_INT);
                $preparedStatement->bindValue("codeGrade", $pompier->getCodeGrade(), PDO::PARAM_STR);
                $preparedStatement->bindValue("matriculeRespo", $pompier->getMatriculeRespo(), PDO::PARAM_STR);

                $preparedStatement->execute();

                return true;
            } catch (Exception $e) {
                // FIXME : logger
                echo $e->getMessage();
                return false;
            }
        } else {
            $this->update($pompier);
            return true;
        }
    }

    /**
     * update the data about a firemen according to the key $pompier
     * @param \Paprika\model\Pompiers $pompier
     * @return bool
     */
    public function update(Pompiers $pompier): bool {
    try {
        $pdo = SingletonDataBaseMariaDB::getInstance()->getPDO();
        $sql = "UPDATE pompiers SET Prenom = :prenom, Nom = :nom, ChefAgret = :chefAgret, DateNaissance = :dateNaissance, NumCaserne = :numCaserne, CodeGrade = :codeGrade, MatriculeRespo = :matriculeRespo, deleted = 0
                WHERE Matricule = :matricule AND Deleted = 0";

        $preparedStatement = $pdo->prepare($sql);
        $preparedStatement->bindValue("prenom", $pompier->getPrenom(), PDO::PARAM_STR);
        $preparedStatement->bindValue("nom", $pompier->getNom(), PDO::PARAM_STR);
        $preparedStatement->bindValue("chefAgret", $pompier->getChefAgret(), PDO::PARAM_STR);
        $preparedStatement->bindValue("dateNaissance", $pompier->getDateNaissance(), PDO::PARAM_STR);
        $preparedStatement->bindValue("numCaserne", $pompier->getNumCaserne(), PDO::PARAM_INT);
        $preparedStatement->bindValue("codeGrade", $pompier->getCodeGrade(), PDO::PARAM_STR);
        $preparedStatement->bindValue("matriculeRespo", $pompier->getMatriculeRespo(), PDO::PARAM_STR);
        $preparedStatement->bindValue("matricule", $pompier->getMatricule(), PDO::PARAM_STR);
        $preparedStatement->execute();

        return true;
    } catch (Exception $e) {
        return false;
    }
}


    /**
     * update the deleted field in the database to 1
     * @param \Paprika\model\Pompiers $pompier
     * @return bool
     */
    public function delete(Pompiers $pompier): bool {
        try {
            // vérifier si le pompier à bien été save / qu'il a un matricule
            $matricule = $pompier->getMatricule();
            if (empty($matricule)) {
                throw new Exception("Matricule manquant dans l'objet pompier.");
            }

            // Vérifier si le pompier existe et n’est pas déjà supprimé
            $prenom = $pompier->getPrenom();
            $nom = $pompier->getNom();
            $dateNaissance = $pompier->getDateNaissance();
            $deleted = $pompier->getDeleted();

            // si il existe est n'est pas déjà supprimé
            $cnx = SingletonDataBaseMariaDB::getInstance()->getPDO();
            $sql = "UPDATE pompiers SET deleted = 1 WHERE Matricule = :matricule";
            
            $preparedStatement = $cnx->prepare("$sql");
            $preparedStatement->bindValue(":matricule", $pompier->getMatricule());
            $preparedStatement->execute();

            // mettre a jour le champ deleted de l'instance
            $pompier->setDeleted(true);

            return true;
        } catch(Exception $e) { // si il y a une erreur lors de l'éxécution de la requête
            echo "Error : ". $e->getMessage();
            return false;
        }
    }

    /**
     * Summary of findAll
     * @return array
     */
    public function findAll(int $maxItems = 100): array {
        try {
            $cnx = SingletonDataBaseMariaDB::getInstance()->getPDO();
            $sql = "SELECT * FROM pompiers WHERE deleted = 0 LIMIT :maxItems";
            $preparedStatement = $cnx->prepare("$sql");
            $preparedStatement->bindValue("maxItems", $maxItems, \PDO::PARAM_INT);
            $preparedStatement->execute();

            $pompiers = [];

            while ($row = $preparedStatement->fetch(\PDO::FETCH_ASSOC)) {
                $pompiers[] = new Pompiers(
                    $row['Prenom'],
                    $row['Nom'],
                    $row['ChefAgret'],
                    $row['DateNaissance'],
                    (int)$row['NumCaserne'],
                    $row['CodeGrade'],
                    $row['MatriculeRespo'],
                    $row['Matricule']
                );
            }
            return $pompiers;

        } catch (Exception $e) {
            echo "Error : ". $e->getMessage();
            return [];
        }
    }

    /**
     * count all the instances in the table pompier
     * @return int
     */
    public function count(): int {
        try {
        $cnx = SingletonDataBaseMariaDB::getInstance()->getPDO();
        $sql = "SELECT COUNT(*) FROM pompiers WHERE deleted = 0";
        $preparedStatement = $cnx->prepare("$sql");
        $preparedStatement->execute();

        $count = $preparedStatement->fetchColumn();
        return (int) $count;
        } catch (Exception $e) {
            echo "Error : ". $e->getMessage();
            return 0;
        }
    }

    /**
     * return a or serveral pompiers according to the value of the key $grade
     * @param string $grade
     * @return array
     */
    public function findByGrade(string $grade): ?array {
        try {
            // vérifier que le grade n'est pas vide ou null
            if ($grade == "" || $grade == null) {
                throw new Exception("le grade est pas remplie ou null");
            }

            // requête
            $cnx = SingletonDataBaseMariaDB::getInstance()->getPDO();

            $sql = "SELECT Matricule, Prenom, Nom, ChefAgret, DateNaissance, NumCaserne, CodeGrade, MatriculeRespo 
            FROM pompiers 
            WHERE CodeGrade = :codeGrade 
            AND deleted = 0";

            $preparedStatement = $cnx->prepare("$sql");
            $preparedStatement->bindValue("codeGrade", $grade, \PDO::PARAM_STR);
            $preparedStatement->execute();

            $pompiers = [];

            while ($row = $preparedStatement->fetch(\PDO::FETCH_ASSOC)) {
                $pompiers[] = new Pompiers(
                    $row['Prenom'],
                    $row['Nom'],
                    $row['ChefAgret'],
                    $row['DateNaissance'],
                    (int)$row['NumCaserne'],
                    $row['CodeGrade'],
                    $row['MatriculeRespo'],
                    $row['Matricule']
                );
            }
            return $pompiers;

        } catch (Exception $e) { // si problème lors de l'éxécution de la requête
            echo 'Error : ' .  $e->getMessage();
            return null;
        }
    }

    public function keyGenerator(): string {
        // calcule du matricule
        $pdo = SingletonDataBaseMariaDB::getInstance()->getPDO();
        $sql = "SELECT MAX(matricule) FROM pompiers;";
        $preparedStatement = $pdo->prepare("$sql");
        $preparedStatement->execute();
        $matricule = $preparedStatement->fetchColumn();

        // vérifier la validité du matricule
        if ($matricule === false || $matricule === null || $matricule === "") {
            throw new Exception("Impossible de récuperer le matricule maximum");
        }
        // incrémenter de 1
        $matricule = substr($matricule, 1);
        $matricule = (int) $matricule;
        $matricule++;
        $matricule = str_pad($matricule, 6, "0", STR_PAD_LEFT);
        $matricule = "P" . $matricule;

        return $matricule;
    }

}
