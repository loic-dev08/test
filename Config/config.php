<?php

/**
 * Configuration globale du projet
 * PHP version 8.5.4
 */

return[
    //Nom de l'application (utilisé dans le header, footer,mails....)

    'app_name' =>'TOUCHE PAS AU KLAXON',

    // Rôle administrateur (ne pas modifier)

    'admin_role =>ADMIN',

    //Email de l'admin du projet (issu de user.txt)

    'app_admin_email' =>'alexandre.martin@email.fr',

    // Palette de couleur imposée (sera injectée dans Sass/Bootstrap)

    'colors' => [
        'color 1'=>'#f1f8fc',
        'color 2'=>'#0074c7',
        'color 3'=>'#00497c',
        'color 4'=>'#384050',
        'color 5'=>'#cd2c2e',
        'color 6'=>'#82b864',
   ],

   //Fuseau horaire par défaut
   'timezone'=>'Europe/Paris',

   // Contrôles utiles pour les trajets
   'trip_rules'=>[
    'min_places'=> 1,
    'max_places'=> 50
   ]

];