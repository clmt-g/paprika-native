<?php

namespace Paprika\model;

class Grade
{
    private string $CodeGrade;
    private string $NomGrade;
    private int $CoefIdem;

    public function __construct(string $codeGrade, string $nomGrade, int $coefIdem)
    {
        $this->CodeGrade = $codeGrade;
        $this->NomGrade = $nomGrade;
        $this->CoefIdem = $coefIdem;
    }


    // -- getters / setters --
    public function getCodeGrade(): string
    {
        return $this->CodeGrade;
    }

    public function setCodeGrade(string $CodeGrade): Grade
    {
        $this->CodeGrade = $CodeGrade;
        return $this;
    }

    public function getNomGrade(): string
    {
        return $this->NomGrade;
    }

    public function setNomGrade(string $NomGrade): Grade
    {
        $this->NomGrade = $NomGrade;
        return $this;
    }

    public function getCoefIdem(): int
    {
        return $this->CoefIdem;
    }

    public function setCoefIdem(int $CoefIdem): Grade
    {
        $this->CoefIdem = $CoefIdem;
        return $this;
    }


}