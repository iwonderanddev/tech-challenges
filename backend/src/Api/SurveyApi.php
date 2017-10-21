<?php

namespace IWD\JOBINTERVIEW\Api;

use IWD\JOBINTERVIEW\Services\JsonFetcher;
use IWD\JOBINTERVIEW\Services\SurveyManager;

class SurveyApi
{
    public function __construct(){
        $this->jsonFetcher = new JsonFetcher();
    }

    /**
     * return available surveys
     * @return Array
     *
     */
    public function getSurveys(){
        $data = $this->jsonFetcher->getAllJsonData();
        $surveyData = [];
        foreach ($data as $item){
            if(strlen($item) > 0){
                $surveyData[] = json_decode($item,true)["survey"];
            }
        }

        // get unique values and strip index from array
        $result = array_values(array_map("unserialize", array_unique(array_map("serialize", $surveyData))));

        return $result;
    }

    /**
     * return the data of a survey
     * @return Array
     */
    public function getSurveyById($id){
        $data = $this->getSurveysById($id);
        $surveyData = [];

        $surveyData["date"] = $this->getSurveyDates($data);
        $surveyData["productsCount"] = $this->getAveragePoductsCount($data);

        return $surveyData;
    }

    protected function getSurveyDates($data){
        $surveyData = [];
        foreach ($data as $item){
            if(strlen($item) > 0){
                $survey = new SurveyManager($item);
                $surveyData[] = $survey->getVisitDate();
            }
        }
        return $surveyData;
    }

    protected function getAveragePoductsCount($data){
        $surveyData = [];
        foreach ($data as $item){
            if(strlen($item) > 0){
                $survey = new SurveyManager($item);
                $surveyData[] = $survey->getProductsCount();
            }
        }

        // return average
        return round(array_sum($surveyData) / count($surveyData));
    }

    protected function getAvailableProducts($data){
        $surveyData = [];
        foreach ($data as $item){
            if(strlen($item) > 0){
                $survey = new SurveyManager($item);
                $surveyData[] = $survey->getQCMData();
            }
        }

        // return average
        return round(array_sum($surveyData) / count($surveyData));
    }

    /**
     * get json data by survey id
     * @param $id
     * @return mixed
     */
    protected function getSurveysById($id){
        $data = $this->jsonFetcher->getAllJsonData();
        $surveys = [];
        foreach ($data as $item){
            if(strlen($item) > 0){
                $survey = new SurveyManager($item);
                if($survey->getCode() === $id){
                    $surveys[] = $item;
                }
            }
        }

        return $surveys;

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