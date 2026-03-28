<?php

declare(strict_types=1);

namespace App\Entities;

/**
 * Class User
 * Représente un employé de l'entreprise.
 * Les employés sont fournis par le système RH et ne peuvent PAS être créés ni supprimés dans ce projet.
 *
 * @package App\Entities
 */
class User
{
    /** @var int|null Identifiant unique */
    private ?int $id;

    /** @var string Prénom de l'utilisateur */
    private string $firstName;

    /** @var string Nom de famille */
    private string $lastName;

    /** @var string Adresse email professionnelle */
    private string $email;

    /** @var string Numéro de téléphone */
    private string $phone;

    /** @var string Rôle dans l'application (USER ou ADMIN) */
    private string $role = 'USER';

    /**
     * Constructeur
     */
    public function __construct(
        ?int $id,
        string $firstName,
        string $lastName,
        string $email,
        string $phone,
        string $role = 'USER'
    ) {
        $this->id        = $id;
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->email     = $email;
        $this->phone     = $phone;
        $this->role      = $role;
    }

    //--------------------------------------------------
    // GETTERS
    //--------------------------------------------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    //--------------------------------------------------
    // SETTERS
    //--------------------------------------------------

    public function setFirstName(string $value): void
    {
        $this->firstName = $value;
    }

    public function setLastName(string $value): void
    {
        $this->lastName = $value;
    }

    public function setEmail(string $value): void
    {
        $this->email = $value;
    }

    public function setPhone(string $value): void
    {
        $this->phone = $value;
    }

    public function setRole(string $value): void
    {
        $allowed = ['USER', 'ADMIN'];

        if (!in_array($value, $allowed, true)) {
            throw new \InvalidArgumentException("Rôle inconnu : $value");
        }

        $this->role = $value;
    }
}
