<?php

namespace Paprika\model;

class Caserne
{
    private int $NumCaserne;
    private string $Adresse;
    private string $Cp;
    private string $Ville;
    private int $CodeTypeC;
    private int $deleted = 0; // default 0

    public function getNumCaserne(): int
    {
        return $this->NumCaserne;
    }

    public function setNumCaserne(int $num): self
    {
        $this->NumCaserne = $num;
        return $this;
    }

    public function getAdresse(): string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $adr): self
    {
        $this->Adresse = $adr;
        return $this;
    }

    public function getCp(): string
    {
        return $this->Cp;
    }

    public function setCp(string $cp): self
    {
        $this->Cp = $cp;
        return $this;
    }

    public function getVille(): string
    {
        return $this->Ville;
    }

    public function setVille(string $ville): self
    {
        $this->Ville = $ville;
        return $this;
    }

    public function getCodeTypeC(): int
    {
        return $this->CodeTypeC;
    }

    public function setCodeTypeC(int $code): self
    {
        $this->CodeTypeC = $code;
        return $this;
    }

    public function setDeleted(int $deleted): self
    {
        $this->deleted = $deleted;
        return $this;
    }

    public function isDeleted(): int
    {
        return $this->deleted ?? 0;
    }
}
