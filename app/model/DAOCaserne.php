<?php

namespace Paprika\model;

use Paprika\utils\SingletonDataBaseMariaDB;
use PDO;
use Paprika\utils\SingletonLogger;

class DAOCaserne {
    private PDO $pdo;
    private string $user = "selim"; // user pour le logging

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        // Active le mode d’erreur PDO en exception
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Nettoie une valeur utilisateur pour prévenir les failles XSS.
     * @param mixed $value
     * @return mixed
     */
    private function sanitize($value) {
        if (is_string($value)) {
            return htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
        }
        return $value;
    }

    public function find($id): ?Caserne {
        try {
            $id = (int)$this->sanitize($id);
            $stmt = $this->pdo->prepare("
                SELECT NumCaserne, Adresse, CP AS Cp, Ville, CodeTypeC, deleted
                FROM casernes
                WHERE NumCaserne = :id AND deleted = 0
            ");
            $stmt->execute(['id' => $id]);
            return $stmt->fetchObject(Caserne::class) ?: null;
        } catch (\Throwable $e) {
            SingletonLogger::getInstance()->error("Erreur find caserne: " . $e->getMessage());
            return null;
        }
    }

    //crée methode detail

    public function save(Caserne $c): bool {
        try {
            $num = (int)$c->getNumCaserne();
            $adr = $this->sanitize($c->getAdresse());
            $cp = $this->sanitize($c->getCp());
            $ville = $this->sanitize($c->getVille());
            $ctc = $this->sanitize($c->getCodeTypeC());
            $deleted = (int)$c->isDeleted();

            $stmt = $this->pdo->prepare("
            INSERT INTO casernes (NumCaserne, Adresse, CP, Ville, CodeTypeC, deleted)
            VALUES (:num, :adr, :cp, :ville, :ctc, :deleted)
        ");
            return $stmt->execute([
                'num' => $num,
                'adr' => $adr,
                'cp' => $cp,
                'ville' => $ville,
                'ctc' => $ctc,
                'deleted' => $deleted
            ]);
        } catch (\Throwable $e) {
            SingletonLogger::getInstance()->error("Erreur save caserne: " . $e->getMessage());
            return false;
        }
    }


    public function update(Caserne $c): bool {
        try {
            $num = (int)$c->getNumCaserne();
            $adr = $this->sanitize($c->getAdresse());
            $cp = $this->sanitize($c->getCp());
            $ville = $this->sanitize($c->getVille());
            $ctc = $this->sanitize($c->getCodeTypeC());

            $stmt = $this->pdo->prepare("
            UPDATE casernes 
            SET Adresse=:adr, CP=:cp, Ville=:ville, CodeTypeC=:ctc
            WHERE NumCaserne=:num AND deleted = 0
        ");
            return $stmt->execute([
                'adr' => $adr,
                'cp' => $cp,
                'ville' => $ville,
                'ctc' => $ctc,
                'num' => $num
            ]);
        } catch (\Throwable $e) {
            SingletonLogger::getInstance()->error("Erreur update caserne: " . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool {
        try {
            $id = (int)$this->sanitize($id);
            $stmt = $this->pdo->prepare("
                UPDATE casernes SET deleted = 1 WHERE NumCaserne = :id
            ");
            return $stmt->execute(['id' => $id]);
        } catch (\Throwable $e) {
            SingletonLogger::getInstance()->error("Erreur delete caserne: " . $e->getMessage());
            return false;
        }
    }

    public function findAll(int $max = 100): array {
        try {
            $max = (int)$this->sanitize($max);
            $stmt = $this->pdo->prepare("
            SELECT 
                c.NumCaserne, 
                c.Adresse, 
                c.CP AS Cp, 
                c.Ville, 
                c.CodeTypeC, 
                c.deleted,
                COUNT(p.Matricule) AS nbPompiers
            FROM casernes c
            LEFT JOIN pompiers p ON p.NumCaserne = c.NumCaserne AND p.deleted = 0
            WHERE c.deleted = 0
            GROUP BY c.NumCaserne
            LIMIT :max
        ");
            $stmt->bindValue('max', $max, PDO::PARAM_INT);
            $stmt->execute();

            $casernes = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $c = new Caserne();
                $c->setNumCaserne($row['NumCaserne'])
                    ->setAdresse($row['Adresse'])   // <-- bien prendre l'adresse
                    ->setCp($row['Cp'])
                    ->setVille($row['Ville'])
                    ->setCodeTypeC($row['CodeTypeC'])
                    ->setNbPompiers((int)$row['nbPompiers']);
                $casernes[] = $c;
            }

            return $casernes;
        } catch (\Throwable $e) {
            SingletonLogger::getInstance()->error("Erreur findAll caserne: " . $e->getMessage());
            return [];
        }
    }

    public function count(): int {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM casernes WHERE deleted = 0");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? (int)$row['total'] : 0;
        } catch (\Throwable $e) {
            SingletonLogger::getInstance()->error("Erreur count caserne: " . $e->getMessage());
            return 0;
        }
    }

    public function findByCity(string $city): array {
        try {
            $ville = $this->sanitize($city);
            $stmt = $this->pdo->prepare("
                SELECT NumCaserne, Adresse, CP AS Cp, Ville, CodeTypeC, deleted
                FROM casernes
                WHERE Ville=:ville AND deleted = 0
            ");
            $stmt->execute(['ville' => $ville]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, Caserne::class);
        } catch (\Throwable $e) {
            SingletonLogger::getInstance()->error("Erreur findByCity caserne: " . $e->getMessage());
            return [];
        }
    }

    public function generateNextId(): int {
        try {
            $stmt = $this->pdo->query("SELECT MAX(NumCaserne) AS maxId FROM casernes");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($row['maxId'] !== null) ? (int)$row['maxId'] + 1 : 1;
        } catch (\Throwable $e) {
            SingletonLogger::getInstance()->error("Erreur generateNextId caserne: " . $e->getMessage());
            return 1;
        }
    }

    /** return the Ville field based on the key id (used to display the casernes in pompiers)
     * @param $id
     * @return string|null
     */
    public function findCaserneVille($id) : ?string {
        $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
        $sql = "SELECT Ville FROM casernes WHERE NumCaserne = :id AND deleted = 0";
        $preparedStatement = $pdo->prepare("$sql");
        $preparedStatement->bindValue("id", $id, \PDO::PARAM_INT);
        $preparedStatement->execute();
        $ville = $preparedStatement->fetchColumn();

        if ($ville === false || $ville === null || $ville === "") {
            return null;
        }

        return $ville;
    }

    /** return all NumCaserne and Ville fields in the database that are not deleted (used for pompier in update and create)
     * @return array
     */
    public function getAllVilles() : array {
        $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
        $sql = "SELECT NumCaserne, Ville FROM casernes WHERE deleted = 0";
        $preparedStatement = $pdo->prepare($sql);
        $preparedStatement->execute();

        $villes = [];
        while ($row = $preparedStatement->fetch(PDO::FETCH_ASSOC)) {
            $villes[] = $row;
        }
        if (empty($villes)) {
            return [];
        }
        return $villes;
    }
}
