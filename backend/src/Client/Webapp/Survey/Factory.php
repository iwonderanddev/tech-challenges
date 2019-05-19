<?php

namespace IWD\JOBINTERVIEW\Client\Webapp\Survey;

use IWD\JOBINTERVIEW\Client\Webapp\Survey\Date;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\Numeric;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\Qcm;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\SurveyException;

Class Factory
{

    /**
     *  Qcm Survey Type
     *  @param String QCM
     */
    const QCM = 'qcm';

    /**
     *  Numeric Survey Type
     *  @param String NUMERIC
     */
    const NUMERIC = 'numeric';

    /**
     *  Date Survey Type
     *  @param String DATE
     */
    const DATE = 'date';

    /**
     *  @param array $surveyResults
     *  @return array $data
     *  @throws SurveyException
     */
    public static function factory($type): SurveyInterface
    {
        switch ($type) {
            case Factory::QCM:
                $question = new Qcm();
                break;

            case Factory::NUMERIC:
                $question = new Numeric();
                break;

            case Factory::DATE:
                $question = new Date();
                break;

            default:
                throw new SurveyException(sprintf('Unknown Survey type: %s', $type));
        }

        return $question;
    }
}