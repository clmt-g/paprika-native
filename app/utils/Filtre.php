<?php

namespace Paprika\utils;

use Paprika\utils\Validators\InterfaceValidator;

class Filtre
{
    private array $validators = [];

    public function __construct()
    {
        // rien à initialiser ici pour l'instant
    }

    public function addValidator(string $key, InterfaceValidator $validator): void
    {
        $this->validators[$key] = $validator;
    }

    /**
     * Exécute tous les validateurs sur le tableau de données
     *
     * @param array $data Tableau associatif ['champ' => 'valeur']
     * @return array Tableau associatif ['champ' => true|false]
     */
    public function execute(array $data): array
    {
        $results = [];

        foreach ($this->validators as $key => $validator) {
            $value = $data[$key] ?? '';
            // double sécurité : htmlspecialchars avant validation (XSS)
            $safeValue = htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $results[$key] = $validator->validate($safeValue);
        }

        return $results;
    }
}