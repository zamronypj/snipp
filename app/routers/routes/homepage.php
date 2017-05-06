<?php

$router->add('/', array(
        'namespace' => 'Snippet\\Controllers\Homepage',
        'controller' => 'home',
        'action' => 'index'));

// Set 404 paths
$router->notFound(array(
            'namespace' => 'Snippet\\Controllers',
            'controller' => 'error',
            'action'     => 'error404'));