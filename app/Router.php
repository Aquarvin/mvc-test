<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\NoConfigurationException;

class Router
{
    /**
     * @var \App\Session
     */
    protected Session $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function __invoke(RouteCollection $routes)
    {
        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());

        $matcher = new UrlMatcher($routes, $context);
        try {
            $arrayUri = explode('?', $_SERVER['REQUEST_URI']);
            $matcher = $matcher->match($arrayUri[0]);

            array_walk($matcher, function (&$param) {
                if (is_numeric($param)) {
                    $param = (int)$param;
                }
            });

            $className = '\\App\\Controller\\' . $matcher['controller'];
            $classInstance = new $className();

            $params = array_merge(array_slice($matcher, 2, -1), ['routes' => $routes]);

            call_user_func_array([$classInstance, $matcher['method']], $params);

        } catch (MethodNotAllowedException $e) {
            echo 'Route method is not allowed.';
        } catch (NoConfigurationException $e) {
            echo 'Configuration does not exists.';
        } catch (ResourceNotFoundException $e) {
            echo 'Route does not exists.';
        }
    }
}

// Invoke
$router = new Router();
$router($routes);
