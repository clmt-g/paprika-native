<?php

namespace Paprika\model;

use stdClass;

class Pompiers extends stdClass
{
    // --- Propiétés ---
    private string $Matricule;
    private string $Prenom;
    private string $Nom;
    private string $ChefAgret;
    private string $DateNaissance;
    private int $NumCaserne;
    private string $CodeGrade;
    private string $MatriculeRespo;
    private bool $deleted;

    // exclure le champ deleted

    // --- constructeurs ---
    public function __construct(string $Matricule = "", string $Prenom, string $Nom, string $ChefAgret, string $DateNaissance, int $NumCaserne,
    string $CodeGrade, string $MatriculeRespo) {
    if (!empty($Matricule)) {
        $this->Matricule = $Matricule;
    } else {
        $this->Matricule = ""; // placeholder
    }

    $this->Prenom = $Prenom;
    $this->Nom = $Nom;
    $this->ChefAgret = $ChefAgret;
    $this->DateNaissance = $DateNaissance;
    $this->NumCaserne = $NumCaserne;
    $this->CodeGrade = $CodeGrade;
    $this->MatriculeRespo = $MatriculeRespo;
    $this->deleted = false;
    }

    // -- Getter setter ---
    public function getMatricule(): string
    {
        return $this->Matricule;
    }

    public function getPrenom(): string
    {
        return $this->Prenom;
    }

    public function getNom(): string
    {
        return $this->Nom;
    }

    public function getChefAgret(): string
    {
        return $this->ChefAgret;
    }

    public function getDateNaissance(): string
    {
        return $this->DateNaissance;
    }

    public function getNumCaserne(): int
    {
        return $this->NumCaserne;
    }

    public function getCodeGrade(): string
    {
        return $this->CodeGrade;
    }

    public function getMatriculeRespo(): string
    {
        return $this->MatriculeRespo;
    }
    public function getDeleted(): bool
    {
        return $this->deleted;
    }

    public function setMatricule(string $Matricule): Pompiers
    {
        $this->Matricule = $Matricule;
        return $this;
    }

    public function setPrenom(string $Prenom): Pompiers
    {
        $this->Prenom = $Prenom;
        return $this;
    }

    public function setNom(string $Nom): Pompiers
    {
        $this->Nom = $Nom;
        return $this;
    }

    public function setChefAgret(string $ChefAgret): Pompiers
    {
        $this->ChefAgret = $ChefAgret;
        return $this;
    }

    public function setDateNaissance(string $DateNaissance): Pompiers
    {
        $this->DateNaissance = $DateNaissance;
        return $this;
    }

    public function setNumCaserne(int $NumCaserne): Pompiers
    {
        $this->NumCaserne = $NumCaserne;
        return $this;
    }

    public function setCodeGrade(string $CodeGrade): Pompiers
    {
        $this->CodeGrade = $CodeGrade;
        return $this;
    }

    public function setMatriculeRespo(string $MatriculeRespo): Pompiers
    {
        $this->MatriculeRespo = $MatriculeRespo;
        return $this;
    }
    public function setDeleted(bool $deleted): Pompiers 
    {
        $this->deleted = $deleted;
        return $this;
    }
}
