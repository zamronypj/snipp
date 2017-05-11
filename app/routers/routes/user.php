<?php

$router->addGet('/signin', [
    'namespace' => 'Snippet\\Controllers\Homepage',
    'controller' => 'sign-in',
    'action' => 'index'
]);

$router->addGet('/signup', [
    'namespace' => 'Snippet\\Controllers\Homepage',
    'controller' => 'sign-up',
    'action' => 'index'
]);

$router->addGet('/register', [
    'namespace' => 'Snippet\\Controllers\Homepage',
    'controller' => 'sign-up',
    'action' => 'register'
]);