<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerDirs([
    $config->application->modelsDir,
    $config->application->controllersDir,
    $config->application->libsDir,
    $config->application->interfacesDir,
    $config->application->repositoriesDir,
]);

$loader->registerNamespaces([
    'App\Models' => $config->application->modelsDir,
    'App\Controllers' => $config->application->controllersDir,
    'App\Library' => $config->application->libsDir,
    'App\CInterface' => $config->application->interfacesDir,
    'App\Repositories' => $config->application->repositoriesDir,
    'App\Validations' => $config->application->validationsDir,
])->register();
