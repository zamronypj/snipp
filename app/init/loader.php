<?php

use Phalcon\Loader;

define('COMPOSER_AUTOLOAD', BASE_PATH . 'vendor/autoload.php');
if (file_exists(COMPOSER_AUTOLOAD)) {
    require COMPOSER_AUTOLOAD;
}

define('CONTROLLERS_PATH', APP_PATH . 'controllers/');
define('MODELS_PATH', APP_PATH . 'models/');

// Register an autoloader
$loader = new Loader();
$loader->registerDirs([
    CONTROLLERS_PATH,
    MODELS_PATH
]);
$loader->registerNamespaces(array(
    'Snippet\Controllers' => CONTROLLERS_PATH,
    'Snippet\Controllers\Homepage' => CONTROLLERS_PATH . 'homepage/',
    'Snippet\Controllers\Admin' => CONTROLLERS_PATH . 'admin/',
    'Snippet\Models' => MODELS_PATH
));

$loader->register();