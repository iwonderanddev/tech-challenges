<?php

namespace IWD\JOBINTERVIEW\Services;


class SurveyManager
{
    const QUESTION_NUMERIC_TYPE = 'numeric';
    const QUESTION_QCM_TYPE = 'qcm';
    const QUESTION_DATE_TYPE = 'date';

    public function __construct($data){
        $this->surveyData = json_decode($data,true);
    }

    /**
     * get name of the survey
     * @return string
     */
    public function getName(){
        return $this->surveyData['survey']['name'];
    }

    /**
     * get code of the survey
     * @return string
     */
    public function getCode(){
        return $this->surveyData['survey']['code'];
    }

    /**
     * get questions data of the survey
     * @return array
     */
    public function getQuestionsData(){
        return $this->surveyData['survey']['questions'];
    }

    /**
     * get the visit date value
     * @return string
     */
    public function getProductsCount(){
        return $this->getDataByQuestionType(QUESTION_NUMERIC_TYPE);
    }

    /**
     * get the visit date value
     * @return string
     */
    public function getQCMData(){
        return $this->getDataByQuestionType(QUESTION_QCM_TYPE);
    }

    /**
     * get the visit date value
     * @return string
     */
    public function getVisitDate(){
        return $this->getDataByQuestionType(QUESTION_DATE_TYPE);
    }

    /**
     * get answer of a question by given type
     * @return mixed
     */
    public function getDataByQuestionType($type){
        $data = $this->getQuestionsData();
        foreach ($data as $item){
            var_dump($item);
            if($item['type'] === $type){
                return $item["answer"];
            }
        }
    }
}