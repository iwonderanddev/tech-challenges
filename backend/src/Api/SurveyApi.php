<?php

namespace IWD\JOBINTERVIEW\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

use IWD\JOBINTERVIEW\Services\JsonFetcher;
use IWD\JOBINTERVIEW\Services\SurveyManager;

class SurveyApi
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

//        $surveyData['dates'] =
//            [
//                'question' => $data[0]['questions'],
//                'answer' =>$this->getSurveyDates($id)
//            ]
        $surveyData['date'] = $this->getSurveyDates($id);
        $surveyData['productsCount'] = $this->getAveragePoductsCount($id);
        $surveyData['products'] = $this->getAvailableProducts($id);

        return new JsonResponse($surveyData);
    }

    protected function getSurveyDates($id){
        $data = $this->getSurveysById($id);
        $surveyData = [];
        foreach ($data as $item){
            if(strlen($item) > 0){
                $survey = new SurveyManager($item);
                $surveyData[] = $survey->getVisitDate();
            }
        }
        return $surveyData;
    }

    protected function getAveragePoductsCount($id){
        $data = $this->getSurveysById($id);
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

    protected function getAvailableProducts($id){
        $data = $this->getSurveysById($id);
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