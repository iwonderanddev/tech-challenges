<?php

declare(strict_types=1);

use IWD\JOBINTERVIEW\Api\ApiRoutesLoader;
use IWD\JOBINTERVIEW\Controller\SurveyApiController;
use Silex\Provider\ServiceControllerServiceProvider;


if (file_exists(ROOT_PATH.'/vendor/autoload.php') === false) {
    echo "run this command first: composer install";
    exit();
}
require_once ROOT_PATH.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

$app = new Application();

$app['debug'] = true;

$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
});

$app->register(new ServiceControllerServiceProvider());

$app->get('/', function () use ($app) {
    return 'Status OK';
});

$routesLoader = new IWD\JOBINTERVIEW\Api\ApiRoutesLoader($app);
$routesLoader->bindRoutesToControllers();

$app->run();
