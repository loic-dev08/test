<?php

/**
 * Connexion PDO centralisée
 * 
 * PHP version 8.5.4
 */

declare(strict_types=1);

namespace Config;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    /**
     * Retourne une instance PDO
     *
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {

            // Paramètres à adapter selon votre environnement
            $host = 'localhost';
            $dbname = 'tpk_database'; // nom de la base
            $username = 'root';
            $password = ""; // mot de passe

            try {
                self::$pdo = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                    ]
                );

            } catch (PDOException $e) {
                // Gestion propre des erreurs
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
