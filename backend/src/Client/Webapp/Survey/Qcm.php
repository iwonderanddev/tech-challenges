<?php

namespace IWD\JOBINTERVIEW\Client\Webapp\Survey;

use IWD\JOBINTERVIEW\Client\Webapp\Survey\AbstractSurvey;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\SurveyInterface;

Class Qcm extends AbstractSurvey implements SurveyInterface
{

    /**
     *  @param array $data
     *  @return void
     */
    public function aggregate($data): void
    {
        $qcmResponses = [];

        foreach ($data as $qcmQuestion) {

            if (empty($this->label)) {
                $this->label = $qcmQuestion['label'];
            }

            foreach ($qcmQuestion['options'] as $optionKey => $label) {

                if (empty($qcmResponses[$label])) {
                    $qcmResponses[$label] = 0;
                }

                if ($qcmQuestion['answer'][$optionKey]) {
                    $qcmResponses[$label]++;
                }
            }
        }

        $this->answers = $qcmResponses;
    }
}