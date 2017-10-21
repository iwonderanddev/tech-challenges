<?php

namespace IWD\JOBINTERVIEW\Api;

use IWD\JOBINTERVIEW\Services\JsonFetcher;

class JsonApi
{
    public function __construct(){
        $this->jsonFetcher = new JsonFetcher();
    }
    public function getSurveys(){
        $data = $this->jsonFetcher->getAllJsonData();
        $surveyData = [];
        foreach ($data as $item){
            if(strlen($item) > 0){
                array_push($surveyData,json_encode(json_decode($item)->survey));
            }
        }
        $surveyData = array_unique($surveyData);
        return join($surveyData,'<br>');
    }
}