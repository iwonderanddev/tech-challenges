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
        return $this->surveyData['questions'];
    }

    /**
     * get the product count question
     * @return string
     */
    public function getProductsCountQuestion(){
        $data = $this->getDataByQuestionType(self::QUESTION_NUMERIC_TYPE);

        return $data['label'];
    }

    /**
     * get the product count
     * @return string
     */
    public function getProductsCountAnswer(){
        $data = $this->getDataByQuestionType(self::QUESTION_NUMERIC_TYPE);

        return $data['answer'];
    }

    /**
     * get the qcm answer
     * @return string
     */
    public function getQCMDataAnswer(){
        $result = [];
        $data = $this->getDataByQuestionType(self::QUESTION_QCM_TYPE);
        $answer = $data['answer'];
        $options = $data['options'];

        // combine arrays
        return array_combine($options, $answer);;
    }
    /**
     * get the qcm question
     * @return string
     */
    public function getQCMDataQuestion(){
        $data = $this->getDataByQuestionType(self::QUESTION_QCM_TYPE);

        return $data['label'];
    }

    /**
     * get the visit question
     * @return string
     */
    public function getVisitDateQuestion(){
        $data = $this->getDataByQuestionType(self::QUESTION_DATE_TYPE);

        return $data['label'];
    }

    /**
     * get the visit date value
     * @return string
     */
    public function getVisitDateAnswer(){
        $data = $this->getDataByQuestionType(self::QUESTION_DATE_TYPE);

        return $data['answer'];
    }

    /**
     * get answer of a question by given type
     * @return mixed
     */
    protected function getDataByQuestionType($type){
        $data = $this->getQuestionsData();
        foreach ($data as $item){
            if($item['type'] === $type){
                return $item;
            }
        }
    }
}