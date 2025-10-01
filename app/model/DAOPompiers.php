<?php

namespace Paprika\model;

use Exception;
use Paprika\utils\SingletonDataBaseMariaDB;
use Paprika\utils\SingletonLogger;
use Paprika\model\Pompiers;

/**
 * Classe DAOPompiers, qui met à disposition un CRUD pour la classe Pompiers
 * @author Clément
 */

class DAOPompiers
{
    private \PDO $pdo;
    private string $user = "clement";

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Return an entity according to the key $id
     * @param string $id
     * @return ?Pompiers
     */
    public function find(string $id): ?Pompiers {
        $cnx = SingletonDataBaseMariaDB::getInstance()->getPDO();

        $sql = "SELECT * FROM pompiers WHERE Matricule=:id AND deleted = 0";
        $preparedStatement = $cnx->prepare("$sql");
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
     * Return True when the key $pompier was successfuly added to the database
     * @param \Paprika\model\Pompiers $pompier
     * @return bool
     */
    // FIXME : Save or update --> pas de exists()
    public function save(Pompiers $pompier): bool {
        try {
        // récupération des données
        $prenom = $pompier->getPrenom();
        $nom = $pompier->getNom();
        $chefAgret = $pompier->getChefAgret();
        $dateNaissance = $pompier->getDateNaissance();
        $numCaserne = $pompier->getNumCaserne();
        $codeGrade = $pompier->getCodeGrade();
        $matriculeRespo = $pompier->getMatriculeRespo();

        // vérifier si le pompier existe déjà
        if ($this->exists($dateNaissance, $prenom, $nom) == true) {
            throw new Exception("Le pompier existe déjà");
        }

        // FIXME : en faire une méthode
        // calcule du matricule
        $cnx = SingletonDataBaseMariaDB::getInstance()->getPDO();
        $sql = "SELECT MAX(matricule) FROM pompiers;";
        $preparedStatement = $cnx->prepare("$sql");
        $preparedStatement->execute();
        $matricule = $preparedStatement->fetchColumn();

        if ($matricule === false || $matricule === null || $matricule === "") {
            throw new Exception("Impossible de récuperer le matricule maximum");
        }
        // incrémenter de 1
        $matricule = substr($matricule, 1);
        $matricule = (int) $matricule;
        $matricule++;
        $matricule = str_pad($matricule, 6, "0", STR_PAD_LEFT);
        $matricule = "P" . $matricule;

        // modifier le matricule du pompier
        $pompier->setMatricule($matricule);

        // requete
        $sql = "INSERT INTO pompiers VALUES (:matricule, :prenom, :nom, :chefAgret, :dateNaissance, :numCaserne, :codeGrade, :matriculeRespo, 0)";
        $preparedStatement = $cnx->prepare("$sql");
        $preparedStatement->bindValue("matricule", $matricule);
        $preparedStatement->bindValue("prenom", $prenom);
        $preparedStatement->bindValue("nom", $nom);
        $preparedStatement->bindValue("chefAgret", $chefAgret);
        $preparedStatement->bindValue("dateNaissance", $dateNaissance);
        $preparedStatement->bindValue("numCaserne", $numCaserne);
        $preparedStatement->bindValue("codeGrade", $codeGrade);
        $preparedStatement->bindValue("matriculeRespo", $matriculeRespo);

        $preparedStatement->execute();

        return true;
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    /**
     * update the informations about a firemen according to the key $pompier
     * @param \Paprika\model\Pompiers $pompier
     * @return bool
     */
    // FIXME : est ce que exists() est vraiment utile ici ?
    public function update(Pompiers $pompier): bool {
    try {
        // Vérifier si le pompier existe et n’est pas supprimé
        $prenom = $pompier->getPrenom();
        $nom = $pompier->getNom();
        $dateNaissance = $pompier->getDateNaissance();
        $deleted = $pompier->getDeleted();

        if (!$this->exists($dateNaissance, $prenom, $nom) === false || $deleted === true) {
            throw new Exception("Le pompier n'existe pas ou a été supprimé");
        }

        // si il existe ...
        $cnx = SingletonDataBaseMariaDB::getInstance()->getPDO();
        $sql = "UPDATE pompiers SET Prenom = :prenom, Nom = :nom, ChefAgret = :chefAgret, DateNaissance = :dateNaissance, NumCaserne = :numCaserne, CodeGrade = :codeGrade, MatriculeRespo = :matriculeRespo, deleted = 0
                WHERE Matricule = :matricule";

        $preparedStatement = $cnx->prepare($sql);
        $preparedStatement->bindValue("prenom", $prenom);
        $preparedStatement->bindValue("nom", $nom);
        $preparedStatement->bindValue("chefAgret", $pompier->getChefAgret());
        $preparedStatement->bindValue("dateNaissance", $dateNaissance);
        $preparedStatement->bindValue("numCaserne", $pompier->getNumCaserne());
        $preparedStatement->bindValue("codeGrade", $pompier->getCodeGrade());
        $preparedStatement->bindValue("matriculeRespo", $pompier->getMatriculeRespo());
        $preparedStatement->bindValue("matricule", $pompier->getMatricule());

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
    // FIXME : est ce que exists est vraiment utile ici ?
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

            if (!$this->exists($dateNaissance, $prenom, $nom) || $deleted) {
                throw new Exception("Le pompier n'existe pas ou a été supprimé");
            }

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

    public function exists(string $dateNaissance, string $prenom, string $nom): bool {
    $cnx = SingletonDataBaseMariaDB::getInstance()->getPDO();

    $sql = "SELECT 1 FROM pompiers WHERE Prenom = :prenom AND Nom = :nom AND DateNaissance = :dateNaissance LIMIT 1";
    $preparedStatement = $cnx->prepare($sql);
    $preparedStatement->bindValue("prenom", $prenom);
    $preparedStatement->bindValue("nom", $nom);
    $preparedStatement->bindValue("dateNaissance", $dateNaissance);
    $preparedStatement->execute();

    $row = $preparedStatement->fetch(\PDO::FETCH_ASSOC);

    return $row !== false;
    }

}
