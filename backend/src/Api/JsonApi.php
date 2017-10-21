<?php

namespace IWD\JOBINTERVIEW\Api;

use IWD\JOBINTERVIEW\Services\JsonFetcher;

class JsonApi
{
    public function __construct(){
        $this->jsonFetcher = new JsonFetcher();
    }
    public function getSurveys(){
        return $this->jsonFetcher->getAllJsonData();
    }
}