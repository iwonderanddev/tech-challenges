<?php

namespace IWD\JOBINTERVIEW\Client\Webapp\Survey;

use IWD\JOBINTERVIEW\Client\Webapp\Survey\AbstractSurvey;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\SurveyInterface;

Class Numeric extends AbstractSurvey implements SurveyInterface
{

    /**
     *  @param array $data
     *  @return void
     */
    public function aggregate($data): void
    {
        $totalOfProduct = 0;

        foreach ($data as $numberOfProduct) {

            if (empty($this->label)) {
                $this->label = $numberOfProduct['label'];
            }

            $totalOfProduct += $numberOfProduct['answer'];
        }

        $average = $totalOfProduct / count($data);

        $this->answers = round($average);
    }
}