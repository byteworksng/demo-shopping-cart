<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 27/06/2018
 * Time: 7:20 PM
 */


use App\Di\FactoryDefault;
use App\App;

error_reporting(E_ALL);

defined('BASE_PATH') ?: define('BASE_PATH', dirname(__DIR__));
defined('APP_ROOT') ?: define('APP_ROOT', 'app');
defined('APP_PATH') ?: define('APP_PATH', BASE_PATH . DIRECTORY_SEPARATOR . APP_ROOT);

// let's get the config
$config = require_once('../config/config.php');


defined('APP_ENV') ?: define('APP_ENV', isset($config['environment'])
        ? $config['environment']
        : 'development');

if (APP_ENV == 'production')
{
    error_reporting(0);
}


// let's autoload our classes
require('../config/loader.php');


// load all dependencies at once
$di = new FactoryDefault();

$app = new App($di);
$app->handle();

