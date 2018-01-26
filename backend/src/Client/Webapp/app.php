<?php
declare(strict_types=1);

if (file_exists(ROOT_PATH.'/vendor/autoload.php') === false) {
    echo "run this command first: composer install";
    exit();
}
require_once ROOT_PATH.'/vendor/autoload.php';

include 'routes/surveyController.php'
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

$app = new Application();
$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
});
$app->get('/', function () use ($app) {
    return 'Status OK';
});


$app->get('/api/v1/surveys', function () use($app) {
    return $app->storage(0);
});

$app->get('/api/v1/survey', function (Request $request) use($app) {
    $code = $request->get('code');   
    return $app->groupSurveys($code);
});


$app->run();
return $app;
