<?php
namespace Paprika\model;

use Paprika\model\User;
use Paprika\utils\SingletonDataBaseMariaDB;
use Paprika\utils\SingletonLogger;

class UserDAO
{
    private \PDO $conn;
    private string $user = "selim"; // pour le logging

    public function __construct() {
        // On récupère la connexion PDO depuis le singleton MariaDB
        $this->conn = SingletonDataBaseMariaDB::getInstance()->getLoggedPDO();
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    // Vérifie si l'utilisateur existe et retourne un objet User ou null
    public function checkUserExists(string $login): ?User {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE login = :login AND actif = 1");
        $stmt->execute(['login' => $login]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            return new User(
                $data['id'],
                $data['login'],
                $data['password_hash'],
                $data['nom'],
                $data['prenom'],
                $data['role'],
                $data['actif']
            );
        }
        return null;
    }

    // Récupère tous les utilisateurs
    public function getAllUsers(): array {
        $stmt = $this->conn->query("SELECT * FROM users");
        $users = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $users[] = new User(
                $data['id'],
                $data['login'],
                $data['password_hash'],
                $data['nom'],
                $data['prenom'],
                $data['role'],
                $data['actif']
            );
        }
        return $users;
    }

    // Crée un utilisateur
    public function createUser(User $user) {
        $stmt = $this->conn->prepare(
            "INSERT INTO users (login,password_hash,nom,prenom,role,actif) 
             VALUES (:login,:password,:nom,:prenom,:role,:actif)"
        );
        $stmt->execute([
            'login' => $user->getLogin(),
            'password' => $user->getPasswordHash(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'role' => $user->getRole(),
            'actif' => $user->isActif() ? 1 : 0
        ]);
    }
}