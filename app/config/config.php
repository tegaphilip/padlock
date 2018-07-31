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
        'exceptionsDir' => __DIR__ . '/../exceptions/',
        'logsDir' => __DIR__ . '/../logs/',
        'repositoriesDir' => __DIR__ . '/../repositories/',
        'transformersDir' => __DIR__ . '/../transformers/',
        'serializersDir' => __DIR__ . '/../serializers/',
    ],

    'appParams' => [
        'appNamespace' => 'App',
        'appName' => 'Padlock! The Hocaboo Authentication App',
        'appVersion' => '0.1'
    ],

    'database' => [
        'adapter' => 'Mysql',
        'host' => getenv('DB_HOST'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'port' => getenv('DB_PORT') ?: '3306',
        'dbname' => getenv('APPLICATION_ENV') === 'testing' ? 'hocaboo_test_db' : getenv('DB_NAME')
    ],

    'oauth' => [
        'enabled' => (getenv('OAUTH_ENABLED') === 'false') ? false : true,
        'access_token_life_time' => 21600,
        'refresh_token_life_time' => 2419200,
        'always_issue_new_refresh_token' => true,
        'excluded_paths' => [
            '/api/v1/oauth'
        ],
        'refresh_token_lifespan' => $oneMonthInterval,
        'access_token_lifespan' => $oneHourInterval,
        'auth_code_lifespan' => $tenMinutesInterval,
        'always_include_client_scopes' => true,
    ],

    'debug' => getenv('DEBUG') === 'true',
];

return new Config($config);
