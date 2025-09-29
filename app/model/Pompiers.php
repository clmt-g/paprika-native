<?php

namespace Paprika\model;

use DateTime;
use stdClass;

class Pompiers extends stdClass
{
    private string $Matricule;
    private string $Prenom;
    private string $Nom;
    private string $ChefAgret;
    private DateTime $DateNaissance;


    // FIXME : faire les autres propriétés et getter setter

    public function getMatricule(): string
    {
        return $this->Matricule;
    }

    public function getPrenom(): string
    {
        return $this->Prenom;
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
}
