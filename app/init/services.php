<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Http\Request;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Config;
use Phalcon\Session\Adapter\Files as SessionFiles;

define('CONFIG_PATH', APP_PATH . 'config/');
define('ROUTER_PATH', APP_PATH . 'routers/');
define('VIEWS_PATH', APP_PATH . 'views/');
define('STORAGES_PATH', BASE_PATH . 'storages/');
define('LOGS_PATH', STORAGES_PATH . 'logs/');

/*
|--------------------------------------------------------------------------
| Register url utility
|--------------------------------------------------------------------------
*/
$di->set('url', function () {
    $url = new UrlProvider();
    $url->setBaseUri('/');
    return $url;
});

/*
|--------------------------------------------------------------------------
| Application Configuration
|--------------------------------------------------------------------------
|
| register config
|
*/
$di->set('config', function () {
    $configData = require(CONFIG_PATH. 'app.php');
    return new Config($configData);
});

$di->set('logger', function () {
    return new FileAdapter(LOGS_PATH . 'app.log');
});


// Setup the database service
$di->set('db', function () use ($di) {
    $config = $di->get('config');
    return new DbAdapter([
                  'host' => $config->db->host,
                  'dbname' => $config->db->dbname,
                  'username' => $config->db->username,
                  'password' => $config->db->password
                  ]);

    //uncomment this to log SQL generated by model
    // $connection = new DbAdapter([
    //               'host' => $config->db->host,
    //               'dbname' => $config->db->dbname,
    //               'username' => $config->db->username,
    //               'password' => $config->db->password
    //               ]);
    // $logger = $di->get('logger');
    // $eventsManager = new \Phalcon\Events\Manager();
    // $eventsManager->attach('db', function($event, $connection) use ($logger) {
    //     if ($event->getType() == 'beforeQuery') $logger->log($connection->getSQLStatement().' '.join(', ', $connection->getSQLVariables()));
    // });
    // $connection->setEventsManager($eventsManager);
    // return $connection;

});

//setup session shared service (singleton)
$di->setShared('session', function () {
    $session = new SessionFiles();
    $session->start();
    return $session;
});

/*
|--------------------------------------------------------------------------
| Add routing capabilities
|--------------------------------------------------------------------------
|
| register all routes from app/config/routes.php
|
*/
$di->set('router', function () {
    $router = require(ROUTER_PATH . 'router.php');
    return $router;
});

/*
|--------------------------------------------------------------------------
| Initialize view
|--------------------------------------------------------------------------
|
| register view directories
|
*/
$di->set('view', function () {
    $view = new View();
    $view->setViewsDir(VIEWS_PATH);
    return $view;
});

$di->set('tokenGenerator', function () use ($di) {
    $securityObj = $di->get('security');
    return new Snippet\Security\CsrfTokenGenerator($securityObj);
});

$di->set('responseGenerator', function () {
    return new Snippet\Utility\JsonResponseGenerator();
});

$di->set('randomStr', function () {
    return new Snippet\Utility\BasicRandomStringGenerator();
});

$di->set('dateSvc', function () {
    return new Snippet\Utility\CarbonDateService();
});
