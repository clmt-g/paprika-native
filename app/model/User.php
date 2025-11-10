<?php

namespace Paprika\model;

class User
{
    private int $id;
    private string $login;
    private string $passwordHash;
    private string $nom;
    private string $prenom;
    private string $role;
    private bool $actif;

    public function __construct($id, $login, $passwordHash, $nom, $prenom, $role, $actif = true) {
        $this->id = $id;
        $this->login = $login;
        $this->passwordHash = $passwordHash;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
        $this->actif = $actif;
    }

    public function getId() { return $this->id; }
    public function getLogin() { return $this->login; }
    public function getPasswordHash() { return $this->passwordHash; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getRole() { return $this->role; }
    public function isActif() { return $this->actif; }
}