<?php

namespace Paprika\App\Model;

class Caserne extends \stdClass {

    private int $NumCaserne;
    private string $Adresse;
    private string $Cp;
    private string $Ville;  
    private ?int $CodeTypeC; 
    

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

    public function getCp(): string {
        return $this->Cp;

    }
    public function setCp(string $Cp): void {
        $this->Cp = $Cp;

    }

    public function getVille(): string {
        return $this->Ville;
    }   

    public function setVille(string $Ville): void {
        $this->Ville = $Ville;
    }

    public function getCodeTypeC(): ?int {
         return $this->CodeTypeC; 
        }


    public function setCodeTypeC(?int $CodeTypeC): void {
        $this->CodeTypeC = $CodeTypeC;

    }



    
}