<?php

declare(strict_types=1);

namespace App\Entities;

/**
 * Class Agency
 *
 * Représente une agence (ville) dans laquelle un trajet peut commencer ou se terminer.
 * Les agences sont gérées uniquement par l'administrateur.
 *
 * @package App\Entities
 */
class Agency
{
    /** @var int|null Identifiant unique de l'agence */
    private ?int $id;

    /** @var string Nom de la ville (unique) */
    private string $name;

    /**
     * Constructeur
     *
     * @param int|null $id
     * @param string $name
     */
    public function __construct(?int $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    //--------------------------------------------
    // GETTERS
    //--------------------------------------------

    /**
     * Retourne l'identifiant unique
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le nom de la ville
     */
    public function getName(): string
    {
        return $this->name;
    }

    //--------------------------------------------
    // SETTERS
    //--------------------------------------------

    /**
     * Définit le nom de la ville
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        // On peut ajouter ici une règle si nécessaire (ex : pas de caractères spéciaux)
        $this->name = $name;
    }
}
