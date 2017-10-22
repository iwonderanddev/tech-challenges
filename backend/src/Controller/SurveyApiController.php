<?php

namespace IWD\JOBINTERVIEW\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use IWD\JOBINTERVIEW\Api\SurveyApi;



class SurveyApiController
{
    public function __construct(){
        $this->api = new SurveyApi();
    }
    public function getSurveys(){
        $result = $this->api->getSurveys();

        return new JsonResponse($result);
    }

    public function getSurvey($id){
        $result = $this->api->getSurveyResult($id);

        return new JsonResponse($result);
    }
    public function getRawData(){
        $result = $this->api->getRawData();

        return new JsonResponse($result);
    }

}