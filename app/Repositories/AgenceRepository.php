<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Agency;
use Config\Database;
use PDO;

/**
 * Class AgencyRepository
 * 
 * Gère l'accès aux données des agences (CRUD complet).
 * Seul l'administrateur peut créer, modifier ou supprimer une agence.
 * 
 * @package App\Repositories
 */
class AgencyRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    /**
     * Construit un objet Agency depuis un tableau SQL.
     * 
     * @param array $row
     * @return Agency
     */
    private function mapToAgency(array $row): Agency
    {
        return new Agency(
            id: (int) $row['id'],
            name: $row['name']
        );
    }

    /**
     * Retourne toutes les agences par ordre alphabétique.
     * 
     * @return Agency[]
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM agencies ORDER BY name ASC");
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => $this->mapToAgency($row), $rows);
    }

    /**
     * Trouve une agence par son ID.
     * 
     * @param int $id
     * @return Agency|null
     */
    public function findById(int $id): ?Agency
    {
        $stmt = $this->pdo->prepare("SELECT * FROM agencies WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();

        return $row ? $this->mapToAgency($row) : null;
    }

    /**
     * Crée une nouvelle agence.
     * 
     * @param string $name
     * @return Agency|null
     */
    public function create(string $name): ?Agency
    {
        $stmt = $this->pdo->prepare("INSERT INTO agencies (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);

        $id = (int) $this->pdo->lastInsertId();

        return $this->findById($id);
    }

    /**
     * Met à jour une agence existante.
     * 
     * @param int $id
     * @param string $name
     * @return bool
     */
    public function update(int $id, string $name): bool
    {
        $stmt = $this->pdo->prepare("UPDATE agencies SET name = :name WHERE id = :id");

        return $stmt->execute([
            'id' => $id,
            'name' => $name
        ]);
    }

    /**
     * Supprime une agence.
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM agencies WHERE id = :id");

        return $stmt->execute(['id' => $id]);
    }
}
