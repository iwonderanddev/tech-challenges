<?php
declare(strict_types=1);

namespace IWD\JOBINTERVIEW\Domain\Model\Question;

class DateQuestion extends AbstractQuestion
{
    const QUESTION_TYPE = 'date';

    public function __construct(string $label)
    {
        $this->type = self::QUESTION_TYPE;
        $this->label = $label;
    }

    /**
     * @param mixed $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = new \DateTime($answer);
    }
}