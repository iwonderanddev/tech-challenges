<?php

namespace IWD\JOBINTERVIEW\Controller;

use IWD\JOBINTERVIEW\Api\SurveyApi;



class SurveyApiController
{
    public function __construct(){
        $this->api = new SurveyApi();
    }
    public function getSurveys(){
    }

    public function getSurvey($id){
        return $this->api->getSurveyById($id);
    }
    public function getRawData(){
        return $this->api->getRawData();
    }

}