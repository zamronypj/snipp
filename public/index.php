<?php

use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use \Exception;

define('BASE_PATH', dirname(__DIR__) . '/');
define('APP_PATH', BASE_PATH . 'app/');
define('INIT_PATH', APP_PATH . 'init/');

try {
    $di = new FactoryDefault();
    //run service registrations
    require INIT_PATH . 'services.php';
    //load namespaces
    require INIT_PATH . 'loader.php';

    echo (new Application($di))->handle()->getContent();
} catch (Exception $e) {
    $message = get_class($e) . ":\n" .
        'File: ' . $e->getFile() . "\n" .
        'Line: ' . $e->getLine() . "\n" .
        'Message: ' . $e->getMessage() . "\n" .
        $e->getTraceAsString();

    $di->get('logger')->critical($message);
}