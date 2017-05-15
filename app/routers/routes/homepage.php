<?php

$router->addGet('/', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'home',
    'action' => 'index'
]);

$router->addGet('/list', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'snippet-list',
    'action' => 'index'
]);

$router->addGet('/your-snippets', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'snippet-list',
    'action' => 'listCurrentUserSnippets'
]);

$router->addPost('/create', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'snippet-create',
    'action' => 'index'
]);

$router->addGet('/s/{snippetId:[a-zA-Z0-9]{7}}', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'snippet-detail',
    'action'     => 'index',
    'snippetId'      => 1
]);

// Set 404 paths
$router->notFound([
    'namespace' => 'Snippet\Controllers',
    'controller' => 'error',
    'action'     => 'error404'
]);