<?php
declare(strict_types=1);

namespace IWD\JOBINTERVIEW\Domain\Model\Question;

class QcmQuestion extends AbstractQuestion
{
    const QUESTION_TYPE = 'qcm';

    public function __construct()
    {
        $this->type = self::QUESTION_TYPE;
    }
}