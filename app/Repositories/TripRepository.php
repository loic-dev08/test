<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Trip;
use App\Entities\Agency;
use Config\Database;
use DateTimeImmutable;
use PDO;

class TripRepository
{
    private PDO $pdo;
    private AgencyRepository $agencyRepo;
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->agencyRepo = new AgencyRepository();
        $this->userRepo = new UserRepository();
    }

    /**
     * Construit un objet Trip complet depuis une ligne SQL
     */
    private function mapToTrip(array $row): Trip
    {
        $departureAgency = $this->agencyRepo->findById((int)$row['departure_agency_id']);
        $arrivalAgency = $this->agencyRepo->findById((int)$row['arrival_agency_id']);
        $contactPerson = $this->userRepo->findById((int)$row['contact_user_id']);

        return new Trip(
            id: (int)$row['id'],
            departureAgency: $departureAgency,
            arrivalAgency: $arrivalAgency,
            departureDateTime: new DateTimeImmutable($row['departure_datetime']),
            arrivalDateTime: new DateTimeImmutable($row['arrival_datetime']),
            totalSeats: (int)$row['total_seats'],
            availableSeats: (int)$row['available_seats'],
            contactPerson: $contactPerson
        );
    }

    /**
     * Retourne tous les trajets futurs avec places disponibles
     */
    public function findAllAvailableFutureTrips(): array
    {
        $query = "
            SELECT * 
            FROM trips 
            WHERE available_seats > 0 
              AND departure_datetime > NOW()
            ORDER BY departure_datetime ASC
        ";

        $stmt = $this->pdo->query($query);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => $this->mapToTrip($row), $rows);
    }

    /**
     * Trouve un trajet par son ID
     */
    public function findById(int $id): ?Trip
    {
        $stmt = $this->pdo->prepare("SELECT * FROM trips WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();
        return $row ? $this->mapToTrip($row) : null;
    }

    /**
     * Liste tous les trajets proposés par un utilisateur
     */
    public function findByAuthorId(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * 
            FROM trips 
            WHERE contact_user_id = :uid 
            ORDER BY departure_datetime ASC
        ");

        $stmt->execute(['uid' => $userId]);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => $this->mapToTrip($row), $rows);
    }

    /**
     * Crée un nouveau trajet
     */
    public function create(Trip $trip): ?Trip
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO trips (
                departure_agency_id,
                arrival_agency_id,
                departure_datetime,
                arrival_datetime,
                total_seats,
                available_seats,
                contact_user_id
            ) VALUES (
                :dep_agency,
                :arr_agency,
                :dep_dt,
                :arr_dt,
                :total,
                :available,
                :contact
            )
        ");

        $stmt->execute([
            'dep_agency' => $trip->getDepartureAgency()->getId(),
            'arr_agency' => $trip->getArrivalAgency()->getId(),
            'dep_dt' => $trip->getDepartureDateTime()->format('Y-m-d H:i:s'),
            'arr_dt' => $trip->getArrivalDateTime()->format('Y-m-d H:i:s'),
            'total' => $trip->getTotalSeats(),
            'available' => $trip->getAvailableSeats(),
            'contact' => $trip->getContactPerson()->getId()
        ]);

        $id = (int)$this->pdo->lastInsertId();
        return $this->findById($id);
    }

    /**
     * Supprime un trajet
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM trips WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Retourne tous les trajets (Admin uniquement)
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM trips ORDER BY departure_datetime ASC");
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => $this->mapToTrip($row), $rows);
    }

    /**
     * Met à jour un trajet
     */
    public function update(Trip $trip): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE trips 
            SET 
                departure_agency_id = :dep_agency,
                arrival_agency_id = :arr_agency,
                departure_datetime = :dep_dt,
                arrival_datetime = :arr_dt,
                total_seats = :total,
                available_seats = :available
            WHERE id = :id
        ");

        return $stmt->execute([
            'dep_agency' => $trip->getDepartureAgency()->getId(),
            'arr_agency' => $trip->getArrivalAgency()->getId(),
            'dep_dt' => $trip->getDepartureDateTime()->format('Y-m-d H:i:s'),
            'arr_dt' => $trip->getArrivalDateTime()->format('Y-m-d H:i:s'),
            'total' => $trip->getTotalSeats(),
            'available' => $trip->getAvailableSeats(),
            'id' => $trip->getId(),
        ]);
    }
}
