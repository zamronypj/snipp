<?php

use Phalcon\Mvc\Router;

//Create the router without default routing (false)
//so we will only match routes that we defined
$router = new Router(false);

$routeDir = ROUTER_PATH . 'routes/';
$iterator = new DirectoryIterator($routeDir);

foreach ($iterator as $route) {
    $isDotFile = strpos($route->getFilename(), '.') === 0;

    if (!$isDotFile && !$route->isDir()) {
        require $routeDir . $route->getFilename();
    }
}

return $router;
