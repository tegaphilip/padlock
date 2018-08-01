<?php
date_default_timezone_set('UTC');

use App\Library\HttpStatusCodes;
use App\Library\ResponseCodes;
use App\Library\ResponseMessages;
use Phalcon\Mvc\Micro;

error_reporting(E_ALL);

include __DIR__ . "/../vendor/autoload.php";

// we do not want to use .env files on production
if (getenv('APPLICATION_ENV') !== 'production') {
    $envFile = ((getenv('APPLICATION_ENV') === 'testing') ? '.env.test' : '.env');
    $dotEnv = new Dotenv\Dotenv(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app/env', $envFile);
    $dotEnv->load();
}

$env = getenv('APPLICATION_ENV');

include __DIR__ . "/../app/config/constants.php";

//setup config
if (!$env) {
    echo "Application environment not set";
    exit;
} else {
    $config = include __DIR__ . "/../app/config/config.php";
}

//include Phalcon Loader
include __DIR__ . "/../app/config/loader.php";

//include application services
include __DIR__ . "/../app/config/services.php";

$app = new Micro($di);

//include application services
include __DIR__ . "/../app/config/routes.php";

// add request logger
//if ($env !== 'production') {
//    $app->before(function () use ($app, $config) {
//        /** @var \Phalcon\Http\Request $request */
//        $request = $app->getService('request');
//        $logger = new Phalcon\Logger\Adapter\File($config->application->logsDir . "requests.log");
//        $logger->log('Request URL:' . $request->getURI(), Logger::INFO);
//        if ($request->isPost() || $request->isPut()) {
//            $rawBody = $request->getRawBody();
//            $logger->log('Request Body: ' . $rawBody, Logger::INFO);
//        }
//    });
//}

//handle invalid routes
$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, HttpStatusCodes::getMessage(404))->sendHeaders();
    $app->response->setContentType('application/json');
    $app->response->setJsonContent([
        'status' => 'error',
        'message' => ResponseMessages::getMessageFromCode(ResponseCodes::METHOD_NOT_IMPLEMENTED),
        'code' => ResponseCodes::METHOD_NOT_IMPLEMENTED
    ]);
    $app->response->send();
});

$app->error(function (Exception $exception) use ($app) {
    $app->response->setContentType('application/json');
    $app->response->setStatusCode(500, HttpStatusCodes::getMessage(500))->sendHeaders();
    $app->response->setJsonContent([
        'status' => 'error',
        'message' => ResponseMessages::getMessageFromCode(ResponseCodes::UNEXPECTED_ERROR),
        'code' => ResponseCodes::UNEXPECTED_ERROR, 'ex' => $exception->getMessage()
    ]);
    $app->response->send();
});

$app->handle();
