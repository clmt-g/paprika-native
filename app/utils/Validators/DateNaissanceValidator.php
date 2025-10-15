<?php

namespace Paprika\utils\Validators;

class DateNaissanceValidator implements InterfaceValidator
{
    public function validate(string $data): bool
    {
        // Utilisation de \DateTime pour référencer la classe globale
        $date = \DateTime::createFromFormat('Y-m-d', $data);
        if (!$date || $date->format('Y-m-d') !== $data) {
            return false;
        }

        $age = (new \DateTime())->diff($date)->y;
        return $age >= 18 && $age <= 120; // exemple : 18 à 120 ans
    }
}