<?php

namespace IWD\JOBINTERVIEW\Controller;

use IWD\JOBINTERVIEW\Api\JsonApi;



class ApiController
{
    public function __construct(){
        $this->api = new JsonApi();
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