<?php

namespace IWD\JOBINTERVIEW\Client\Webapp\Survey;

interface SurveyInterface
{

    /**
     *  @param array $data
     *  @return void
     */
    public function aggregate(array $data): void;
}