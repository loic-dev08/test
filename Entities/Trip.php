<?php

declare(strict_types=1);

namespace App\Entities;

use DateTimeImmutable;

/**
 * Class Trip
 *
 * Représente un trajet prévu entre deux agences.
 * Le trajet est proposé par un utilisateur (personne à contacter).
 *
 * @package App\Entities
 */
class Trip
{
    /** @var int|null Identifiant unique du trajet */
    private ?int $id;

    /** @var Agency Agence de départ */
    private Agency $departureAgency;

    /** @var Agency Agence d'arrivée */
    private Agency $arrivalAgency;

    /** @var DateTimeImmutable Date et heure de départ */
    private DateTimeImmutable $departureDateTime;

    /** @var DateTimeImmutable Date et heure d'arrivée */
    private DateTimeImmutable $arrivalDateTime;

    /** @var int Nombre total de places */
    private int $totalSeats;

    /** @var int Nombre de places disponibles */
    private int $availableSeats;

    /** @var User Personne à contacter (auteur du trajet) */
    private User $contactPerson;

    /**
     * Constructeur
     */
    public function __construct(
        ?int $id,
        Agency $departureAgency,
        Agency $arrivalAgency,
        DateTimeImmutable $departureDateTime,
        DateTimeImmutable $arrivalDateTime,
        int $totalSeats,
        int $availableSeats,
        User $contactPerson
    ) {
        $this->id                = $id;
        $this->departureAgency   = $departureAgency;
        $this->arrivalAgency     = $arrivalAgency;
        $this->departureDateTime = $departureDateTime;
        $this->arrivalDateTime   = $arrivalDateTime;
        $this->totalSeats        = $totalSeats;
        $this->availableSeats    = $availableSeats;
        $this->contactPerson     = $contactPerson;
    }

    //-----------------------------------------
    // GETTERS
    //-----------------------------------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartureAgency(): Agency
    {
        return $this->departureAgency;
    }

    public function getArrivalAgency(): Agency
    {
        return $this->arrivalAgency;
    }

    public function getDepartureDateTime(): DateTimeImmutable
    {
        return $this->departureDateTime;
    }

    public function getArrivalDateTime(): DateTimeImmutable
    {
        return $this->arrivalDateTime;
    }

    public function getTotalSeats(): int
    {
        return $this->totalSeats;
    }

    public function getAvailableSeats(): int
    {
        return $this->availableSeats;
    }

    public function getContactPerson(): User
    {
        return $this->contactPerson;
    }

    //-----------------------------------------
    // SETTERS
    //-----------------------------------------

    public function setDepartureAgency(Agency $agency): void
    {
        $this->departureAgency = $agency;
    }

    public function setArrivalAgency(Agency $agency): void
    {
        $this->arrivalAgency = $agency;
    }

    public function setDepartureDateTime(DateTimeImmutable $date): void
    {
        $this->departureDateTime = $date;
    }

    public function setArrivalDateTime(DateTimeImmutable $date): void
    {
        $this->arrivalDateTime = $date;
    }

    public function setTotalSeats(int $value): void
    {
        $this->totalSeats = $value;
    }

    public function setAvailableSeats(int $value): void
    {
        $this->availableSeats = $value;
    }

    public function setContactPerson(User $person): void
    {
        $this->contactPerson = $person;
    }
}
