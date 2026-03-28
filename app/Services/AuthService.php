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
 *  @param App\Services
 */

