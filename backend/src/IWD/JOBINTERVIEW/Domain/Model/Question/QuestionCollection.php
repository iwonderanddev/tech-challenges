<?php
declare(strict_types=1);

namespace IWD\JOBINTERVIEW\Domain\Model\Question;

class QuestionCollection
{
    /** @var string */
    private $surveyCode;
    /** @var AbstractQuestion[] $questions */
    private $questions;

    public function __construct(string $surveyCode)
    {
        $this->surveyCode = $surveyCode;
    }

    /**
     * @return string
     */
    public function getSurveyCode(): string
    {
        return $this->surveyCode;
    }

    /**
     * @param string $surveyCode
     */
    public function setSurveyCode(string $surveyCode)
    {
        $this->surveyCode = $surveyCode;
    }

    /**
     * @return AbstractQuestion[]
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    /**
     * @param AbstractQuestion[] $questions
     */
    public function setQuestions(array $questions)
    {
        $this->questions = $questions;
    }

    public function addQuestion(AbstractQuestion $question)
    {
        $this->questions[] = $question;
    }
}
