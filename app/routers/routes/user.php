<?php

$router->addGet('/signout', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'sign-out',
    'action' => 'index'
])->setName('signout');

$router->addGet('/signin', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'sign-in',
    'action' => 'index'
])->setName('signin');

$router->addPost('/auth', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'sign-in',
    'action' => 'auth'
])->setName('auth');

$router->addGet('/signin/failed', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'sign-in',
    'action' => 'failed'
])->setName('signin-failed');

$router->addGet('/signup', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'sign-up',
    'action' => 'index'
])->setName('signup');

$router->addGet('/profile', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'user-profile',
    'action' => 'index'
])->setName('user-profile');

$router->addPost('/profile/update', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'update-user-profile',
    'action' => 'update'
])->setName('update-user-profile');

$router->addPost('/register', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'sign-up',
    'action' => 'register'
])->setName('register');
