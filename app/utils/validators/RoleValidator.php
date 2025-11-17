<?php

namespace Paprika\utils\validators;

use Paprika\utils\validators\InterfaceValidator;

class RoleValidator implements InterfaceValidator
{
    /**
    * Liste des codes de grades role
    */
    private const array VALID_ROLE = [
        'default',
        'secretaire',
        'admin'
    ];

    /** vérifie que le rôle est valide
     * @param string $data
     * @return bool
     */
    public function validate(string $data): bool
    {
        // Vérifier que la chaîne n'est pas vide
        if (empty($data)) {
            return false;
        }

        // Vérifier si le code grade existe dans la liste
        return in_array($data, self::VALID_ROLE, true);
    }
}