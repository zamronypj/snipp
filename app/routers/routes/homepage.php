<?php

$router->addGet('/', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'home',
    'action' => 'index'
])->setName('home');


$router->addGet('/list', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'snippet-list',
    'action' => 'index'
])->setName('snippet-list');

$router->addGet('/list/{username:[a-zA-Z0-9]{1,16}}', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'snippet-list',
    'action' => 'listPublicSnippetsByUser'
])->setName('snippet-list-by-user');

$router->addGet('/your-snippets', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'snippet-list',
    'action' => 'listCurrentUserSnippets'
])->setName('snippet-list-by-current-user');

$router->addGet('/list/tag/{categoryName:[a-zA-Z0-9\-]+}', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'snippet-list-by-category',
    'action' => 'index'
])->setName('snippet-list-by-category');

$router->addPost('/create', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'snippet-create',
    'action' => 'index'
])->setName('snippet-create');

$router->addGet('/s/{snippetId:[a-zA-Z0-9]{7}}', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'snippet-detail',
    'action'     => 'index',
    'snippetId'      => 1
])->setName('snippet-detail');

$router->addGet('/categories', [
    'namespace' => 'Snippet\Controllers\Homepage',
    'controller' => 'category-list',
    'action' => 'list'
])->setName('category-list');

// Set 404 paths
$router->notFound([
    'namespace' => 'Snippet\Controllers',
    'controller' => 'error',
    'action'     => 'error404'
]);
