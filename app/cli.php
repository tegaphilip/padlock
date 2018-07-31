<?php

use Phalcon\CLI\Console as ConsoleApp;
use Phalcon\Di\FactoryDefault\Cli;
use Phalcon\Loader;

$di = new Cli();

defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__)));


date_default_timezone_set('UTC');
/**
 * Register the autoloader and tell it to register the tasks directory
 */
$loader = new Loader();

$loader->registerDirs([
    APPLICATION_PATH . '/tasks',
    APPLICATION_PATH . '/data',
    APPLICATION_PATH . '/models',
    APPLICATION_PATH . '/repositories',
    APPLICATION_PATH . '/interfaces',
])->register();

$loader->registerNamespaces([
    'App\Model' => APPLICATION_PATH . '/models',
    'App\Library' => APPLICATION_PATH . '/library',
    'App\V1\Model' => APPLICATION_PATH . '/models/' . 'v1/',
    'App\V1\Validation' => APPLICATION_PATH . '/models/' . 'v1/',
    'App\Exception' => APPLICATION_PATH . '/exceptions',
    'App\Repositories' => APPLICATION_PATH . '/repositories',
    'App\CInterface' => APPLICATION_PATH . '/interfaces',
])->register();


/**
 * Process the console arguments
 */
$arguments = array();
foreach ($argv as $k => $arg) {
    if ($k == 1) {
        $arguments['task'] = $arg;
    } elseif ($k == 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

if (is_readable(APPLICATION_PATH . '/config/config.php')) {
    $config = include APPLICATION_PATH . '/config/config.php';
    $di->set('config', $config);
}

include APPLICATION_PATH. "/../vendor/autoload.php";

/**
 * Read services
 */
include APPLICATION_PATH . "/config/services_cli.php";

$console = new ConsoleApp();

$di->set('console', function () use ($console) {
    return $console;
});

$console->setDI($di);

define('CURRENT_TASK', (isset($argv[1]) ? $argv[1] : null));
define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

try {
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    echo $e->getMessage();
    exit(255);
}