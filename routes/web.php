<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();
$routes->add(
    'homepage',
    new Route(constant('URL_SUBFOLDER') . '/', ['controller' => 'PageController', 'method' => 'indexAction'], [])
);
$routes->add(
    'user',
    new Route(constant('URL_SUBFOLDER') . '/user', ['controller' => 'UserController', 'method' => 'indexAction'], [])
);
$routes->add(
    'createUser',
    new Route(constant('URL_SUBFOLDER') . '/userPost', ['controller' => 'UserController', 'method' => 'postAction'], [])
);
$routes->add(
    'loginFrom',
    new Route(constant('URL_SUBFOLDER') . '/login', ['controller' => 'LoginController', 'method' => 'indexAction'], [])
);
$routes->add(
    'loginPost',
    new Route(constant('URL_SUBFOLDER') . '/loginPost', ['controller' => 'LoginController', 'method' => 'loginPostAction'], [])
);
$routes->add(
    'logoutPost',
    new Route(constant('URL_SUBFOLDER') . '/logoutPost', ['controller' => 'LoginController', 'method' => 'logoutPostAction'], [])
);
