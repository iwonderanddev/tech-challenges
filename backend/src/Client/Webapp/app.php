<?php
declare(strict_types=1);

if (file_exists(ROOT_PATH.'/vendor/autoload.php') === false) {
    echo "run this command first: composer install";
    exit();
}
require_once ROOT_PATH.'/vendor/autoload.php';

use IWD\JOBINTERVIEW\Client\Webapp\Data\Builder;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\SurveyException;
use IWD\JOBINTERVIEW\Client\Webapp\Data\SurveyResult;
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

$app->get('/read', function () use ($app) {

    $files = scandir(Builder::FILES_PATH);
    $data = Builder::extractData($files);

    $surveyResult = new SurveyResult();
    $surveys = $surveyResult->getSurveyNames($data);

    return json_encode($surveys);
});

$app->get('/aggregate/{surveyCode}', function (string $surveyCode) use ($app) {

    try {

        $files = scandir(Builder::FILES_PATH);
        $data = Builder::extractData($files);

        if (empty($data[$surveyCode])) {
            throw new SurveyException(sprintf('This survey doesnt exist: %s', $surveyCode));
        }

        $surveyResults = $data[$surveyCode]['questions'];

        $surveyResult = new SurveyResult();
        $aggregatedSurvey = $surveyResult->aggregateResults($surveyResults);
        $output = $surveyResult->output($aggregatedSurvey);

    } catch (\Exception $e) {
        $output = [$e->getMessage()];
    }

    return json_encode($output);
});

$app->run();

return $app;
