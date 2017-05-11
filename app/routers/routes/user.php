<?php

$router->addGet('/signin', [
    'namespace' => 'Snippet\\Controllers\Homepage',
    'controller' => 'sign-in',
    'action' => 'index'
]);

$router->addPost('/auth', [
    'namespace' => 'Snippet\\Controllers\Homepage',
    'controller' => 'sign-in',
    'action' => 'auth'
]);

$router->addGet('/signup', [
    'namespace' => 'Snippet\\Controllers\Homepage',
    'controller' => 'sign-up',
    'action' => 'index'
]);

$router->addPost('/register', [
    'namespace' => 'Snippet\\Controllers\Homepage',
    'controller' => 'sign-up',
    'action' => 'register'
]);