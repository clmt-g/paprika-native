<?php

namespace Paprika\utils\validators;

class GradeValidator
{
    /**
     * Liste des codes de grades valides (en dur comme autorisé)
     */
    private const array VALID_GRADES = [
        '1C', // 1ere classe
        'AC', // Adjudent chef
        'Ad', // Adjudent
        'Ca', // Caporal
        'CC', // Capo. Chef
        'Ct', // Capitaine
        'In', // Infirmier
        'Lt', // Lieutenant
        'Ma', // Major
        'SC', // Sgt Chef
        'Sg', // Sergent
        'Sp'  // Sapeur
    ];
    /** Valide un code grade
     * @param string $data Le code grade à valider
     * @return bool True si valide, False sinon
     */
    public function validate(string $data): bool
    {
        // Vérifier que la chaîne n'est pas vide
        if (empty($data)) {
            return false;
        }

        // Vérifier si le code grade existe dans la liste
        return in_array($data, self::VALID_GRADES, true);
    }
}