<?php

namespace IWD\JOBINTERVIEW\Client\Webapp\Survey;

use IWD\JOBINTERVIEW\Client\Webapp\Survey\AbstractSurvey;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\SurveyInterface;

Class Date extends AbstractSurvey implements SurveyInterface
{

    /**
     *  @param array $data
     *  @return void
     */
    public function aggregate($data): void
    {
        $dates = [];

        foreach ($data as $dateList) {

            if (empty($this->label)) {
                $this->label = $dateList['label'];
            }

            $dates[] = $dateList['answer'];
        }

        $this->answers = $dates;
    }
}