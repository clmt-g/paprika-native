<?php

namespace Paprika\model;

use Paprika\model\Pompiers;

/**
 *
 * @author Clément
 */

class DAOPompiers
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Summary of find
     * @param string $id
     * @return void
     */
    public function find(string $id): ?Pompiers {

    }

    /**
     * Summary of save
     * @param \Paprika\model\Pompiers $pompier
     * @return void
     */
    public function save(Pompiers $pompier): bool {

    }

    /**
     * Summary of update
     * @param \Paprika\model\Pompiers $pompier
     * @return void
     */
    public function update(Pompiers $pompier): bool {

    }

    /**
     * Summary of delete
     * @param \Paprika\model\Pompiers $pompier
     * @return void
     */
    public function delete(Pompiers $pompier): bool {

    }

    /**
     * Summary of findAll
     * @return void
     */
    public function findAll(int $maxItems = 100): array {

    }

    /**
     * Summary of count
     * @return void
     */
    public function count(): int {

    }

}
