<?php

use Phalcon\Loader;

define('COMPOSER_AUTOLOAD', BASE_PATH . 'vendor/autoload.php');
if (file_exists(COMPOSER_AUTOLOAD)) {
    require COMPOSER_AUTOLOAD;
}

define('CONTROLLERS_PATH', APP_PATH . 'controllers/');
define('MODELS_PATH', APP_PATH . 'models/');
define('LIB_PATH', APP_PATH . 'lib/');

// Register an autoloader
$loader = new Loader();
$loader->registerDirs([
    CONTROLLERS_PATH,
    MODELS_PATH,
    LIB_PATH
]);
$loader->registerNamespaces([
    'Snippet\Controllers' => CONTROLLERS_PATH,
    'Snippet\Controllers\Homepage' => CONTROLLERS_PATH . 'homepage/',
    'Snippet\Controllers\Admin' => CONTROLLERS_PATH . 'admin/',
    'Snippet\Models' => MODELS_PATH,
    'Snippet\Security' => LIB_PATH . 'Security/',
    'Snippet\Utility' => LIB_PATH . 'Utility/',
    'Snippet\Validation' => LIB_PATH . 'Validation/',
    'Snippet\Sanitation' => LIB_PATH . 'Sanitation/',
    'Snippet\Task' => LIB_PATH . 'Task/',
    'Snippet\Task\Users' => LIB_PATH . 'Task/Users/',
    'Snippet\Task\Snippets' => LIB_PATH . 'Task/Snippets/',
    'Snippet\Task\Categories' => LIB_PATH . 'Task/Categories/',
    'Snippet\Exception' => LIB_PATH . 'Exception/',
    'Snippet\Exception\User' => LIB_PATH . 'Exception/User'
]);

$loader->register();
