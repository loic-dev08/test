<?php

declare(strict_types= 1);

namespace App\Repositories;

use App\Entities\User;
use Config\Database;
use PDO;

/**
 * Class UserRepository
 * 
 * Gère l'accès aux données des utilisateurs.
 * Les utilisateurs sont fournis par le système RH et ne sont pas modifiables
 * via l'application (lecture seule).
 * 
 * @package App\Repositories
 */
class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
      $this->pdo = Database::getConnection();  
    }

    /**
     * Construit un objet User à partir d'une ligne SQL
     * 
     *  @param array $row
     *  @return User
     */
    private function mapToUser(array $row): User
    {
        return new User(
            id:(int)$row['id'],
            firstName:$row['first_name'],
            lastName:$row['last_name'],
            email:$row['email'],
            phone:$row['phne'],
            role:$row['role'] 
        );
    }

    /**
     * Retourne tous les utilisateurs
     * 
     *  @return User[]
     */

    public function findAll():array
    {
        $stmt =$this->pdo->query("SELECT * FROM users ORDER BY last_name ASC,first_name ASC");
        $rows = $stmt->fetchAll();

        return array_map(fn($row)=>$this->mapToUser($row),$rows);
    }

    /**
     * Trouve un utilisateur par son ID
     * 
     *  @param int $id
     *  @return User|null
     */

    public function findById(int $id): ?User
    {
        $stmt = $this->pdo->prepare("SELECT*FROM users WHERE id =:id LIMIT 1");
        $stmt->execute(['id'=>$id]);
        $row = $stmt->fetch();

        return $row ? $this->mapToUser($row):null;
    }

    /**
     * Trouve un utilisateur via son adresse mail
     * 
     *  @param string $email
     *  @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        $stmt =$this->pdo->prepare("SELECT*FROM users WHERE email =:email LIMIT 1");
        $stmt->execute(['email'=>$email]);
        $row = $stmt->fetch();
        return $row ? $this->mapToUser($row): null;
    }

    /**
     * Retourne les administrateurs
     * 
     *  @return User[]
     */
    public function getAdmins(): array
    {
        $stmt =$this->pdo->query("SELECT*FROM users WHERE role ='ADMIN'");
        $rows = $stmt->fetchAll();

        return array_map(fn($row) =>$this->mapToUser($row),$rows );
    }
        
}