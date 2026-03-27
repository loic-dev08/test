<?php

/**
 * Définition de toutes les routes de l'application
 * 
 * PHP version 8.5.4
 */

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\TripController;
use App\Controllers\AdminController;

return [

    /*
    |-----------------------------------------
    | ROUTES GET PUBLIQUES
    |-----------------------------------------
    */
    'get' => [

        // Page d'accueil
        '/' => [HomeController::class, 'index'],

        // Formulaire de connexion
        '/login' => [AuthController::class, 'loginForm'],

        // Page de création d'un trajet
        '/trip/create' => [TripController::class, 'create'],

        // Page de modification d'un trajet
        '/trip/edit' => [TripController::class, 'edit'],

        /*
        |-----------------------------------------
        | ROUTES ADMIN
        |-----------------------------------------
        */

        // Tableau de bord admin
        '/admin' => [AdminController::class, 'dashboard'],

        // Liste des utilisateurs
        '/admin/users' => [AdminController::class, 'listUsers'],

        // Liste des agences
        '/admin/agencies' => [AdminController::class, 'listAgencies'],

        // Page d'édition d'une agence
        '/admin/agency/edit' => [AdminController::class, 'editAgency'],

        // Liste des trajets
        '/admin/trips' => [AdminController::class, 'listTrips'],
    ],

    /*
    |-----------------------------------------
    | ROUTES POST
    |-----------------------------------------
    */
    'post' => [

        // Tentative de connexion
        '/login' => [AuthController::class, 'login'],

        // Création d'un trajet
        '/trips/create' => [TripController::class, 'store'],

        // Mise à jour d'un trajet
        '/trips/update' => [TripController::class, 'update'],

        // Suppression d'un trajet
        '/trip/delete' => [TripController::class, 'delete'],

        // CRUD ADMIN : agences
        '/admin/agency/create' => [AdminController::class, 'createAgency'],
        '/admin/agency/update' => [AdminController::class, 'updateAgency'],
        '/admin/agency/delete' => [AdminController::class, 'deleteAgency'],
    ],

];
