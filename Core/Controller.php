<?php

namespace App\Core;

use App\Core\View; // Assure-toi que la classe View est bien importée

class Controller
{
    protected function render(string $view, array $params = []): void
    {
        echo View::render($view, $params);
    }
}
