<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\RouteCollection;

class PageController
{
    public function indexAction(RouteCollection $routes): void
    {
        require_once APP_ROOT . '/app/view/home.php';
    }
}
