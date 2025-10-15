<?php

namespace Paprika\model;

use Paprika\utils\SingletonDataBaseMariaDB;
use PDO;

class DAOGrade
{

    private \PDO $pdo;
    private string $user = "clement";

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    /** return all CodeGrade and Name to be displayed
     * @return array|null
     */
    public function getAllCodeGrade() : ?array {
        $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
        $sql = "SELECT CodeGrade, NomGrade FROM grades GROUP BY CodeGrade";
        $preparedStatement = $pdo->prepare("$sql");
        $preparedStatement->execute();

        $codeGrades = [];
        while ($row = $preparedStatement->fetch(\PDO::FETCH_ASSOC)) {
            $codeGrades[] = $row;
        }
        if (empty($codeGrades)) {
            null;
        }
        return $codeGrades;
    }

    /** return a NomGrade according to the key id
     * @param $id
     * @return string|null
     */
    public function getCodeGradeNom($id) : ?string {
        $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
        $sql = "SELECT NomGrade FROM grades WHERE CodeGrade = :codeGrade";
        $preparedStatement = $pdo->prepare("$sql");
        $preparedStatement->bindValue("codeGrade", $id, \PDO::PARAM_STR);
        $preparedStatement->execute();
        $codeGrade = $preparedStatement->fetchColumn();
        if (empty($codeGrade)) {
            return null;
        }
        return $codeGrade;
    }
}