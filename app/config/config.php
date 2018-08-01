<?php

use Phalcon\Config;

try {
    $oneMonthInterval = new \DateInterval('P1M');
    $oneHourInterval = new \DateInterval('PT1H');
    $tenMinutesInterval = new \DateInterval('PT10M');
} catch (Exception $e) {
}

$config = [
    'application' => [
        'modelsDir' => __DIR__ . '/../models/',
        'controllersDir' => __DIR__ . '/../controllers/',
        'libsDir' => __DIR__ . '/../library/',
        'interfacesDir' => __DIR__ . '/../interfaces/',
        'validationsDir' => __DIR__ . '/../validations/',
        'logsDir' => __DIR__ . '/../logs/',
        'repositoriesDir' => __DIR__ . '/../repositories/',
    ],

    'appParams' => [
        'appNamespace' => 'App',
        'appName' => 'Padlock! The Phalcon Authentication Server',
        'appVersion' => '0.1'
    ],

    'database' => [
        'adapter' => 'Mysql',
        'host' => getenv('DB_HOST'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'port' => getenv('DB_PORT') ?: '3306',
        'dbname' => getenv('DB_NAME')
    ],

    'oauth' => [
        'refresh_token_lifespan' => $oneMonthInterval,
        'access_token_lifespan' => $oneHourInterval,
        'auth_code_lifespan' => $tenMinutesInterval,
        'always_include_client_scopes' => true,
    ],

    'debug' => getenv('DEBUG') === 'true',
];

return new Config($config);
