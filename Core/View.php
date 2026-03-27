<?php

namespace App\Core;

Class View
{
    public static function render(string $view, array $params =[]): string
    {
        $viewFile = dirname(__DIR__, 2) ."ressources/views/$view.php";

        if(!file_exists($viewFile)) {
            return "Vue introuvable:$view";
        }

        // Extraction des variables pour la vue

        extract($params);

        ob_start();
        include $viewFile;
        return ob_get_clean();
    }
}