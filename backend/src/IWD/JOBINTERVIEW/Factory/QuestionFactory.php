<?php
declare(strict_types=1);

namespace IWD\JOBINTERVIEW\Factory;

use IWD\JOBINTERVIEW\Domain\Model\Question\AbstractQuestion;
use IWD\JOBINTERVIEW\Domain\Model\Question\DateQuestion;
use IWD\JOBINTERVIEW\Domain\Model\Question\NumericQuestion;
use IWD\JOBINTERVIEW\Domain\Model\Question\QcmQuestion;
use Symfony\Component\Serializer\SerializerInterface;

class QuestionFactory
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param $type
     * @param $jsonQuestion
     * @return null|AbstractQuestion
     */
    public function createQuestion($type, $jsonQuestion)
    {
        $question = null;

        if (QcmQuestion::QUESTION_TYPE === $type) {
            $question = $this->serializer->deserialize($jsonQuestion, QcmQuestion::class, 'json');
        } elseif (NumericQuestion::QUESTION_TYPE === $type) {
            $question = $this->serializer->deserialize($jsonQuestion, NumericQuestion::class, 'json');
        } elseif (DateQuestion::QUESTION_TYPE === $type) {
            $question = $this->serializer->deserialize($jsonQuestion, DateQuestion::class, 'json');
        }

        return $question;
    }
}