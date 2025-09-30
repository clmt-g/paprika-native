<?php

namespace Paprika\model;

use Exception;
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
        $cnx = SingletonDataBaseMariaDB::getInstance()->getPDO();

        $sql = "SELECT * FROM pompiers WHERE Matricule=:id";
        $preparedStatement = $cnx->prepare("$sql");
        $preparedStatement->bindValue("id", $id);
        $preparedStatement->execute();
        $row = $preparedStatement->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            $pompier = new Pompiers(
                $row["Matricule"],
                $row['Prenom'],
                $row['Nom'],
                $row['ChefAgret'],
                $row['DateNaissance'],
                (int)$row['NumCaserne'],
                $row['CodeGrade'],
                $row['MatriculeRespo']
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

        // set le matricule du pompier avec la vrai valeur si tous le reste a fonctionner
        $pompier->setMatricule($matricule);

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
    public function update(Pompiers $pompier): bool {
    try {
        $prenom = $pompier->getPrenom();
        $nom = $pompier->getNom();
        $dateNaissance = $pompier->getDateNaissance();
        $deleted = $pompier->getDeleted();

        // Vérifier si le pompier existe et n’est pas supprimé
        if (!$this->exists($dateNaissance, $prenom, $nom) || $deleted == true) {
            throw new Exception("Le pompier n'existe pas ou a été supprimé");
        }

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

        return $preparedStatement->execute();

    } catch (Exception $e) {
        return false;
    }
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
