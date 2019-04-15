<?php

declare(strict_types=1);
namespace IWD\JOBINTERVIEW\Persistence\Repository\Json;

use IWD\JOBINTERVIEW\Persistence\Repository\SurveyRepositoryInterface;

class SurveyRepository extends BaseRepository implements SurveyRepositoryInterface
{
    public function getAll()
    {
        return $this->getSurveys();
    }
}
