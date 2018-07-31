<?php

use Phalcon\Mvc\Micro\Collection as RouteHandler;

//version routes
$router = new RouteHandler();
$router->setHandler('App\Controller\VersionController', true);
$router->get('/', 'index');
$app->mount($router);

//auth routes
$router = new RouteHandler();
$router->setHandler('App\Controller\AuthController', true);
$router->setPrefix('/api/v1/oauth');
$router->post('/token', 'token');
$router->post('/refresh', 'token');
$router->get('/authorize', 'authorize');
$router->post('/token/validate', 'validate');
$app->mount($router);
