<?php

use App\Library\Response;
use App\Repositories\AccessTokenRepository;
use App\Repositories\AuthCodeRepository;
use App\Repositories\ClientRepository;
use App\Repositories\RefreshTokenRepository;
use App\Repositories\ScopeRepository;
use App\Repositories\UserRepository;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Logger;

$di = new FactoryDefault();

/**
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 * @return DbAdapter
 */
$di->setShared('db', function () use ($config) {
    $connection = new DbAdapter([
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname,
        'port' => $config->database->port
    ]);

    if ($config->debug) {
        $eventsManager = new Phalcon\Events\Manager();
        $logger = new Phalcon\Logger\Adapter\File($config->application->logsDir . "sql_debug.log");

        $eventsManager->attach('db', function ($event, $connection) use ($logger) {
            if ($event->getType() == 'beforeQuery') {
                /** @var DbAdapter $connection */
                $logger->log($connection->getSQLStatement(), Logger::DEBUG);
            }
        });

        $connection->setEventsManager($eventsManager);
    }

    return $connection;
});

/**
 * Add models manager
 */
$di->setShared('modelsManager', function () {
    return new Phalcon\Mvc\Model\Manager();
});

/**
 * Add security
 */
$di->setShared('security', function () {
    $security = new \Phalcon\Security();
    $security->setWorkFactor(12);
    return $security;
});

/**
 * Add config
 */
$di->setShared('config', $config);

/**
 * Response Handler
 */
$di['response'] = function () {
    return new Response();
};

$di->setShared('oauth2Server', function () use ($config) {
    $clientRepository = new ClientRepository();
    $scopeRepository = new ScopeRepository();
    $accessTokenRepository = new AccessTokenRepository();
    $userRepository = new UserRepository();
    $refreshTokenRepository = new RefreshTokenRepository();
    $authCodeRepository = new AuthCodeRepository();

    // Setup the authorization server
    $server = new \League\OAuth2\Server\AuthorizationServer(
        $clientRepository,
        $accessTokenRepository,
        $scopeRepository,
        new \League\OAuth2\Server\CryptKey(getenv('PRIVATE_KEY_PATH'), null, false),
        getenv('ENCRYPTION_KEY')
    );

    $passwordGrant = new \League\OAuth2\Server\Grant\PasswordGrant($userRepository, $refreshTokenRepository);
    $passwordGrant->setRefreshTokenTTL($config->oauth->refresh_token_lifespan);

    $authCodeGrant = new AuthCodeGrant(
        $authCodeRepository,
        $refreshTokenRepository,
        $config->oauth->auth_code_lifespan
    );

    $refreshTokenGrant = new \League\OAuth2\Server\Grant\RefreshTokenGrant($refreshTokenRepository);
    $refreshTokenGrant->setRefreshTokenTTL($config->oauth->refresh_token_lifespan);

    // Enable the refresh token grant on the server
    $server->enableGrantType($refreshTokenGrant, $config->oauth->access_token_lifespan);
    $authCodeGrant->setRefreshTokenTTL($config->oauth->refresh_token_lifespan);

    // Enable the authentication code grant on the server
    $server->enableGrantType($authCodeGrant, $config->oauth->access_token_lifespan);

    // Enable the password grant on the server
    $server->enableGrantType($passwordGrant, $config->oauth->access_token_lifespan);

    // Enable the client credentials grant on the server
    $server->enableGrantType(new ClientCredentialsGrant(), $config->oauth->access_token_lifespan);

    // Enable the implicit grant on the server
    $server->enableGrantType(
        new \League\OAuth2\Server\Grant\ImplicitGrant($config->oauth->access_token_lifespan),
        $config->oauth->access_token_lifespan
    );

    return $server;
});

/**
 * Logger
 */
$di->set('logger', function () use ($config) {
    $logger = new Phalcon\Logger\Adapter\File($config->application->logsDir . "general.log");
    return $logger;
});
