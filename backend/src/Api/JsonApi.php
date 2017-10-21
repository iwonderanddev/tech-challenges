<?php

namespace IWD\JOBINTERVIEW\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

use IWD\JOBINTERVIEW\Services\JsonFetcher;
use IWD\JOBINTERVIEW\Services\SurveyManager;

class JsonApi
{
    public function __construct(){
        $this->jsonFetcher = new JsonFetcher();
    }

    /**
     * return available surveys
     * @return JsonResponse
     *
     */
    public function getSurveys(){
        $data = $this->jsonFetcher->getAllJsonData();
        $surveyData = [];
        foreach ($data as $item){
            if(strlen($item) > 0){
                $surveyData[] = json_decode($item,true)['survey'];
            }
        }

        // get unique values and strip index from array
        $result = array_values(array_map("unserialize", array_unique(array_map("serialize", $surveyData))));

        return new JsonResponse($result);
    }

    /**
     * return the data of a survey
     * @return JsonResponse
     */
    public function getSurveyById($id){
        $data = $this->jsonFetcher->getAllJsonData();
        $surveyData = [];

        $surveyData['dates'] = $this->getSurveyDates($id);

        return new JsonResponse($surveyData);
    }

    public function getSurveyDates($id){
        $data = $this->jsonFetcher->getAllJsonData();
        $surveyData = [];
        foreach ($data as $item){
            if(strlen($item) > 0){
                $survey = new SurveyManager($item);
                $surveyData[] = $survey->getVisitDate();
            }
        }
        return $surveyData;
    }

    /**
     * @return string
     * used for debug
     */
    public function getRawData(){
        $data = $this->jsonFetcher->getAllJsonData();

        return join($data,'<br>');
    }
}