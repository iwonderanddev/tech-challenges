<?php

declare(strict_types=1);
namespace IWD\JOBINTERVIEW\Persistence\Repository\Json;

use IWD\JOBINTERVIEW\Domain\Model\Question\AbstractQuestion;
use IWD\JOBINTERVIEW\Domain\Model\Question\DateQuestion;
use IWD\JOBINTERVIEW\Domain\Model\Question\NumericQuestion;
use IWD\JOBINTERVIEW\Domain\Model\Question\QcmQuestion;
use IWD\JOBINTERVIEW\Persistence\Repository\AnswerRepositoryInterface;

class AnswerRepository extends BaseRepository implements AnswerRepositoryInterface
{
    /**
     * @param string $code
     * @return array
     */
    public function getAllBySurveyCode($code)
    {
        $result =  $this->getQuestionsBySurveyCode($code);

        $average = $this->calculateNumbersAverage($result);
        $dates = $this->getDates($result);
        $qcmResponses = $this->getQcmAverage($result);

        return [
            'qcm' => $qcmResponses,
            'number' => $average,
            'dates' => $dates,
        ];
    }

    /**
     * @param $questionList
     * @return float|int
     */
    private function calculateNumbersAverage($questionList)
    {
        $result = $this->getQuestionsByType(NumericQuestion::QUESTION_TYPE, $questionList);
        $nbResult = \count($result);

        $sum = array_sum(array_map(function (AbstractQuestion $question) {
            return $question->getAnswer();
        }, $result));

        return 0 === $nbResult ? 0 : $sum / $nbResult;
    }

    /**
     * @param $questionList
     * @return array
     */
    private function getDates($questionList)
    {
        $result = $this->getQuestionsByType(DateQuestion::QUESTION_TYPE, $questionList);

        return array_map(function (AbstractQuestion $question) {

            return ($question->getAnswer())->format('m/d/Y H:i:s');
        }, $result);
    }

    /**
     * @param $questionList
     * @return array
     */
    private function getQcmAverage($questionList)
    {
        $sum = [];
        $result = $this->getQuestionsByType(QcmQuestion::QUESTION_TYPE, $questionList);

        foreach ($result as $question) {
            $options = $question->getOptions();
            $answers = $question->getAnswer();

            foreach ($answers as $key => $answer) {
                if (!isset($sum[$options[$key]])) {
                    $sum[$options[$key]] = 0;
                }
                $sum[$options[$key]] += (int) $answer;
            }
        }

        return $sum;
    }

    /**
     * @param $type
     * @param $questions
     * @return array
     */
    private function getQuestionsByType($type, $questions)
    {
        $result = array_values(array_filter($questions, function(AbstractQuestion $item) use ($type) {

            return $item->isType($type) !== false;
        }));

        return $result;
    }

    /**
     * @param $code
     * @return array
     */
    private function getQuestionsBySurveyCode($code)
    {
        $questionList = [];

        foreach ($this->questions as $data) {

            if (strcasecmp($code, $data->getSurveyCode())) {
                $questionList = array_merge($questionList, $data->getQuestions());
            }
        }

        return $questionList;
    }
}
