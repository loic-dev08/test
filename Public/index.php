<?php

declare(strict_types=1);

use App\Core\Router;
use App\Core\Request;

require_once dirname(__DIR__).'/vendor/autoload.php';

session_start();


//Chargement des routes

$routes = require dirname(__DIR__). '/config/routes.php';

// Création de la requête à partir de l'environnement PHP

$request = new Request();

//Router

$router = new Router($routes);
$router ->dispatch($request);
