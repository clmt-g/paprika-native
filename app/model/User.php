<?php

namespace Paprika\model;

// User (1) -- (1) Role (n) -- (1) Permission

/* Role (à coder en dur)
 * default : pompier (show) + caserne (show) + accès a son profil
 * secretaire : pompier (show, save, update, delete) + caserne (show)
 * admin : secretaire + créer des comptes...
 * */

class User
{
    // propriétés
    private ?int $id;
    private string $nom;
    private string $prenom;
    private string $login;
    private string $passwd;
    private string $role;
    private bool $deleted;

    // constructeur
    public function __construct(
        string $nom,
        string $prenom,
        string $login,
        string $passwd,
        string $role = 'default',
        bool $deleted = false,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->login = $login;
        $this->passwd = $passwd;
        $this->role = $role;
        $this->deleted = $deleted;
    }

    // getter / setter

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }
    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }
    /**
     * @param string $login
     * @return User
     */
    public function setLogin(string $login): User
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswd(): string {
        return $this->passwd;
    }
    /**
     * @param string $passwd
     * @return User
     */
    public function setPasswd(string $passwd): User
    {
        $this->passwd = $passwd;
        return $this;
    }
    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     * @return User
     */
    public function setDeleted(bool $deleted): User
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return User
     */
    public function setNom(string $nom): User
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     * @return User
     */
    public function setPrenom(string $prenom): User
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return User
     */
    public function setRole(string $role): User
    {
        $this->role = $role;
        return $this;
    }

}