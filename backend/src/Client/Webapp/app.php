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

$app = new Application();
$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
});
$app->get('/', function () use ($app) {
    return 'Status OK';
});

$app->get('/survey', function (Request $request) {
    $data = $request->get('code');

    return new Response($data, 200);
});

// Stage 1

$app->post('/surveys', function () {
    $reply = storage(0);
    return new Response(json_encode($reply), 200);
});

//Stage 2

function storage($value){
    $surveys = [];
    $uniqueSurveys = [];
    $dir ='data';
    $surveyFiles = array_diff(scandir($dir, 1), array('..', '.'));

    foreach($surveyFiles as $independentSurvey){
        $surveyJsonObject = json_decode( file_get_contents($dir.'/'.$independentSurvey));
        array_push($surveys, $surveyJsonObject);
        if(!in_array($surveyJsonObject->survey, $uniqueSurveys) && $surveyJsonObject !=null){
            array_push($uniqueSurveys, $surveyJsonObject->survey);
        }
    }
    if($value == 1){
        return $surveys;
    }return $uniqueSurveys;
}

function groupSurveys(){

    $surveys = storage(1);
    foreach($surveys as $independentSurvey){

    }
}
$app->run();
return $app;
