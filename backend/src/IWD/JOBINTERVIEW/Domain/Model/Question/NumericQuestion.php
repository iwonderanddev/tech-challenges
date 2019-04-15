<?php
declare(strict_types=1);

namespace IWD\JOBINTERVIEW\Domain\Model\Question;

class NumericQuestion extends AbstractQuestion
{
    const QUESTION_TYPE = 'numeric';

    public function __construct()
    {
        $this->type = self::QUESTION_TYPE;
    }
}