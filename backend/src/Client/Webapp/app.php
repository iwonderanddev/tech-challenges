<?php
declare(strict_types=1);

if (file_exists(ROOT_PATH.'/vendor/autoload.php') === false) {
    echo "run this command first: composer install";
    exit();
}
require_once ROOT_PATH.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use IWD\JOBINTERVIEW\Persistence\Repository\Json\SurveyRepository;
use IWD\JOBINTERVIEW\Persistence\Repository\Json\AnswerRepository;
use IWD\JOBINTERVIEW\Factory\QuestionFactory;

$app = new Application();
$app->register(new Silex\Provider\SerializerServiceProvider());

// Dependency injections
$app['serializer.normalizers'] = function () use ($app) {
    $propertyInfo = new \Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor();
    return [
        new \Symfony\Component\Serializer\Normalizer\ArrayDenormalizer(),
        new \Symfony\Component\Serializer\Normalizer\ObjectNormalizer(null, null, null, $propertyInfo),
    ];
};

$app['question.factory'] = function () use ($app) {
    return new QuestionFactory($app['serializer']);
};

$app['survey.repository'] = function () use ($app) {
    return new SurveyRepository($app['serializer'], $app['question.factory']);
};

$app['answer.repository'] = function () use ($app) {
    return new AnswerRepository($app['serializer'], $app['question.factory']);
};

// Api routes
$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Content-Type', 'application/json');
});
$app->get('/', function () use ($app) {
    return 'Status OK';
});

$app->get('/surveys', function () use ($app) {

    $surveys = $app['serializer']->serialize($app['survey.repository']->getAll(), 'json');

    return new Response($surveys);
});

$app->get('surveys/{code}/answers', function ($code) use ($app) {

    $answers = $app['serializer']->serialize($app['answer.repository']->getAllBySurveyCode($code), 'json');

    return new Response($answers);
});

$app->run();

return $app;
