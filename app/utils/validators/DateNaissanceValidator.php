<?php

namespace Paprika\utils\validators;

use Paprika\utils\validators\InterfaceValidator;
use DateTime;

class DateNaissanceValidator implements InterfaceValidator
{
    /** check if a date is in the correct format
     * @param string $data
     * @return bool
     * @throws \DateMalformedStringException
     */
    public function validate(string $data): bool
    {
        // vérifier le format
        $dateObj = DateTime::createFromFormat('Y-m-d', $data);
        if (!$dateObj || $dateObj->format('Y-m-d') !== $data) {
            return false;
        }
        // vérifier l'age (entre 16 et 65)
        $age = (new DateTime())->diff(new DateTime($data))->y;
        if ($age < 16 || $age > 65) {
            return false;
        }
        return true;
    }
}