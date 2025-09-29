<?php

namespace Paprika\App\Model;

class Caserne extends \stdClass {

    private int $NumCaserne;
    private string $Adresse;

// fixme coder les autres proprietes et definir les getters/setters


    public function getNumCaserne(): int {
        return $this->NumCaserne;
    }

    public function setNumCaserne(int $NumCaserne): void {
        $this->NumCaserne = $NumCaserne;
    }

    public function getAdresse(): string {
        return $this->Adresse;
    }
    
    public function setAdresse(string $Adresse): void {
        $this->Adresse = $Adresse;
    }



    
}