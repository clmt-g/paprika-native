<?php

namespace Paprika\model;

use stdClass;

class Pompiers extends stdClass
{
    private string $Matricule;
    private string $Prenom;

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
