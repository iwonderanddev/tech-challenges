<?php

declare(strict_types=1);
namespace IWD\JOBINTERVIEW\Persistence\Repository;

interface AnswerRepositoryInterface
{
    public function getAllBySurveyCode($code);
}