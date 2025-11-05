<?php
namespace App\Utils;

class Filtre {
    private array $validators = [];

    public function addValidator(string $field, $validator): void {
        $this->validators[$field] = $validator;
    }

    public function execute(array $data): array {
        $results = [];
        foreach ($this->validators as $field => $validator) {
            $results[$field] = $validator->validate($data[$field] ?? null);
        }
        return $results;
    }
}