<?php

namespace Paprika\model;

use Paprika\utils\SingletonDataBaseMariaDB;
use PDOException;
use PHPUnit\Exception;

class DAOUser
{

    private \PDO $pdo;
    private string $user = "clement";

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    /** return a user according to the key $id
     * @param $id
     * @return User|null
     * @throws \Exception
     */
    public function find($id) : ?User {
        try {
            $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
            $sql = "SELECT * FROM user WHERE id = :id AND deleted = 0";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
            $stmt->execute();

            if ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $user = new User(
                    $row['nom'],
                    $row['prenom'],
                    $row['login'],
                    $row['passwd'],
                    $row['role'],
                    $row['deleted'],
                    $row['id']
                );
            } else {
                return null;
            }
            return $user;
        } catch (Exception $e) {
            error_log("Erreur find user: " . $e->getMessage());
            return null;
        }
    }

    /** insert a new user to the database
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function save(User $user) : bool
    {
        try {
            if ($user->getId() == null) {
                // défense contre les injection
                $user = $this->cleanUser($user);

                // générer id
                $id = $this->generateId();
                $user->setId($id);

                $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
                $sql = "INSERT INTO user (id, nom, prenom, login, passwd, role, deleted) VALUES (:id, :nom, :prenom, :login, :passwd, :role, FALSE)";
                $stmt = $pdo->prepare($sql);


                $stmt->bindValue(":id", $user->getId(), \PDO::PARAM_INT);
                $stmt->bindValue(":nom", $user->getNom(), \PDO::PARAM_STR);
                $stmt->bindValue(":prenom", $user->getPrenom(), \PDO::PARAM_STR);
                $stmt->bindValue(":login", $user->getLogin(), \PDO::PARAM_STR);
                $stmt->bindValue(":passwd", $user->getPasswd(), \PDO::PARAM_STR);
                $stmt->bindValue(":role", $user->getRole(), \PDO::PARAM_STR);
                return $stmt->execute();
            } else {
                return $this->update($user);
            }
        } catch (Exception $e) {
            error_log("Erreur save user: " . $e->getMessage());
            return false;
        }
    }

    /** update a user in the database
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function update(User $user) : bool {
        try {
            // défense contre les injections
            $user = $this->cleanUser($user);

            $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
            $sql = "UPDATE user SET nom = :nom, prenom = :prenom, login = :login, passwd = :passwd, role = :role WHERE id = :id AND deleted = 0";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id", $user->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(":nom", $user->getNom(), \PDO::PARAM_STR);
            $stmt->bindValue(":prenom", $user->getPrenom(), \PDO::PARAM_STR);
            $stmt->bindValue(":login", $user->getLogin(), \PDO::PARAM_STR);
            $stmt->bindValue(":passwd", $user->getPasswd(), \PDO::PARAM_STR);
            $stmt->bindValue(":role", $user->getRole(), \PDO::PARAM_STR);

            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $user->setNom($user->getNom());
                $user->setPrenom($user->getPrenom());
                $user->setLogin($user->getLogin());
                $user->setPasswd($user->getPasswd());
                $user->setRole($user->getRole());
                return true;
            }
            return false;
        } catch (Exception $e) {
            error_log("Erreur update user: " . $e->getMessage());
            return false;
        }
    }

    /** delete a user (soft delete : deleted = 1)
     * @param User $user
     * @return bool
     */
    public function delete(User $user) : bool {
        try {
            $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
            $sql = "UPDATE user SET deleted = 1 WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id", $user->getId(), \PDO::PARAM_INT);
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $user->setDeleted(true);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            error_log("Erreur delete user: " . $e->getMessage());
            return false;
        }
    }

    /** return all the users from the database that are not deleted
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function findAll(int $offset = 0, int $limit = 10): array {
        try {
            $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
            $sql = "SELECT * FROM user WHERE deleted = 0 LIMIT :limit OFFSET :offset";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":limit", $limit, \PDO::PARAM_INT);
            $stmt->bindValue(":offset", $offset, \PDO::PARAM_INT);
            $stmt->execute(); // ← IMPORTANT : manquait !

            $users = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $users[] = new User(
                    $row['nom'],
                    $row['prenom'],
                    $row['login'],
                    $row['passwd'],
                    $row['role'],
                    (bool)$row['deleted'],
                    (int)$row['id']
                );
            }
            return $users;
        } catch (\PDOException $e) {
            error_log("Erreur findAll user: " . $e->getMessage());
            return [];
        }
    }

    /** count the number of users in the database
     * @return int
     */
    public function count() : int {
        try {
            $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
            $sql = "SELECT COUNT(id) FROM user WHERE deleted = 0";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\Exception $e) {
            error_log("Erreur count: " . $e->getMessage());
            return 0;
        }
    }

    /** check if a user exist
     * @param string $login
     * @param string $hashedPassword
     * @return User|null
     */
    public function checkUserExist(string $login, string $hashedPassword): ?User {
        try {
            $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
            $sql = "SELECT * FROM user WHERE login = :login AND passwd = :passwd AND deleted = 0";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":login", $login, \PDO::PARAM_STR);
            $stmt->bindValue(":passwd", $hashedPassword, \PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($row) {
                return new User(
                    $row['nom'],
                    $row['prenom'],
                    $row['login'],
                    $row['passwd'],
                    $row['role'],
                    (bool)$row['deleted'],
                    (int)$row['id']
                );
            }

            return null;
        } catch (\PDOException $e) {
            error_log("Erreur checkUserExist: " . $e->getMessage());
            return null;
        }
    }

    /** generate an id based on the last inserted in the database
     * @return int
     */
    private function generateId() : int {
        $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
        $sql = "SELECT MAX(id) FROM user";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        return $id ? $id + 1 : 1;
    }

    /** is used to prevent injections
     * @param User $user
     * @return User
     */
    private function cleanUser(User $user) : User {
        $user->setNom(htmlspecialchars($user->getNom(), ENT_QUOTES));
        $user->setPrenom(htmlspecialchars($user->getPrenom(), ENT_QUOTES));
        $user->setLogin(htmlspecialchars($user->getLogin(), ENT_QUOTES));
        $user->setRole(htmlspecialchars($user->getRole(), ENT_QUOTES));
        return $user;
    }

    /** update a user password
     * @param int $id
     * @param string $password
     * @return bool
     */
    public function updatePassword(int $id, string $password) : bool {
        try {
            $pdo = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
            $sql = "UPDATE user SET passwd = :passwd WHERE id = :id AND deleted = 0";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':passwd', $password, \PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\Exception $e) {
            error_log("Erreur resetPassword: " . $e->getMessage());
            return false;
        }
    }
}