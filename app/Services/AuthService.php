<?php

declare (strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;
use App\Core\Session;
use App\Entities\User;

/**
 * Class AuthService
 * 
 * Gère l'authentification et la gestion de session utilisateur
 * Dans ce projet, les utilisateurs sont fournis via le fichier RH
 * et les mots de passe sont supposés préenregistrés dans la base.
 * 
 *  @package App\Services
 */
class AuthService
{
    private UserRepository $userRepository;

    public function __construct()
    {
      $this->userRepository = new UserRepository();  
    }

    /**
     * Tentative de connexion
     * 
     *  @param string $email
     *  @return bool
     */

    public function login(string $email, string $password): bool
    {
        $user = $this->userRepository->findByEmail($email);

        if($user===null) {
            return false;
        }

        //Mot de passe en clair dans cet exercice

        $storedPassword = $this->getStoredPasswordForUser($user->getId());

        if ($storedPassword !==$password) {
            return false;
        }

        // Connexion réussie
        Session::set('user_id',$user->getId());
        Session::set('user_role',$user->getRole());

        return true;
     }

     /**
      * Cette méthode sert uniquement parce que l'exercice ne fournit pas de gestion
      * des mots de passe. On la simule ici.
      *
      * @param int $userId
      * @return string|null
      */
     private function getStoredPasswordForUser(int $userId): ?string
     {
        // Dans un vrai projet on utiliserait un hash en base.
        // Ici on stockera les mots de passe dans la table users (colonne password).
        $pdo = \Config\Database::getConnection();

        $stm =$pdo->prepare("SELECT password FROM users WHERE id =:id LIMIT 1");
        $stm->execute(['id'=>$userId]);

        $row = $stm->fetch();

        return $row['password'] ?? null;
     }

     /**
      * Déconnecte l'utilisateur
      *
      *  @return void
      */
     public function logout(): void
     {
        Session::destroy();
     }
}
