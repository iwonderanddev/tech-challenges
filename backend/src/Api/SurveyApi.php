<?php

namespace IWD\JOBINTERVIEW\Api;

use IWD\JOBINTERVIEW\Services\JsonFetcher;
use IWD\JOBINTERVIEW\Services\SurveyManager;

class SurveyApi
{
    public function __construct(){
        $this->jsonFetcher = $this->getJsonFetcher();
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
    public function getSurveyResult($id){

        $data = $this->getSurveysById($id);
        $surveyInfos = json_decode($data[0],true);
        $surveyData = [];
        $surveyData["survey"] = $surveyInfos["survey"];
        $surveyData["qcm"] = $this->getBestSellers($data);
        $surveyData["date"] = $this->getSurveyDates($data);
        $surveyData["numeric"] = $this->getAveragePoductsCount($data);

        return $surveyData;
    }

    protected function getBestSellers($data){
        $surveyData = [];
        $result = [];

        foreach ($data as $item){
            if(strlen($item) > 0){
                $survey = new SurveyManager($item);
                $surveyData[] = $survey->getQCMDataAnswer();
            }
        }
        foreach ($surveyData as $k=>$answer) {
            foreach ($answer as $id=>$value) {
                array_key_exists( $id, $result ) ? $result[$id] += $value : $result[$id] = $value;
            }
        }

        return ['question'=>$survey->getQCMDataQuestion(), 'answer'=>$result];
    }

    protected function getSurveyDates($data){
        $dates = [];
        foreach ($data as $item){
            if(strlen($item) > 0){
                $survey = new SurveyManager($item);
                $dates[] = $survey->getVisitDateAnswer();
            }
        }
        return ['question'=>$survey->getVisitDateQuestion(), 'answer'=>$dates];
    }

    protected function getAveragePoductsCount($data){
        $surveyData = [];
        foreach ($data as $item){
            if(strlen($item) > 0){
                $survey = new SurveyManager($item);
                $surveyData[] = $survey->getProductsCountAnswer();
            }
        }
        $roundedCount = round(array_sum($surveyData) / count($surveyData));
        return [
            'question'=>$survey->getProductsCountQuestion(),
            'answer'=> $roundedCount
        ];
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

    protected function getJsonFetcher(){
        return new JsonFetcher();
    }
}