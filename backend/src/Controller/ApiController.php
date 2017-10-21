<?php

namespace IWD\JOBINTERVIEW\Controller;

use IWD\JOBINTERVIEW\Api\JsonApi;



class ApiController
{
    public function __construct(){
        $this->api = new JsonApi();
    }
    public function getSurveys(){
        return $this->api->getSurveys();
    }

    public function getSurvey($id){
        return 'getting '.$id;
    }

}