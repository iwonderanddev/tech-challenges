<?php

declare(strict_types=1);
namespace IWD\JOBINTERVIEW\Persistence\Repository\Json;

use IWD\JOBINTERVIEW\Domain\Model\Question\AbstractQuestion;
use IWD\JOBINTERVIEW\Domain\Model\Question\QuestionCollection;
use IWD\JOBINTERVIEW\Domain\Model\Survey;
use IWD\JOBINTERVIEW\Factory\QuestionFactory;
use Symfony\Component\Serializer\SerializerInterface;

class BaseRepository
{
    /** @var null|string */
    protected $storagePath;
    /** @var SerializerInterface $serializer */
    protected $serializer;
    /** @var QuestionFactory $questionFactory */
    protected $questionFactory;
    /** @var array $surveys */
    protected $surveys;
    /** @var array $questions */
    protected $questions;

    public function __construct(SerializerInterface $serializer, QuestionFactory $questionFactory, $storagePath = null)
    {
        $this->storagePath = isset($storagePath) ? $storagePath : ROOT_PATH . '/data';
        $this->serializer = $serializer;
        $this->questionFactory = $questionFactory;
        $this->surveys = [];
        $this->questions = [];

        $this->initialize();
    }

    public function initialize()
    {
        $collections = $this->readFile();

        foreach ($collections as $collection) {
            $surveyCode = $collection->survey->code;
            $survey = $this->serializer->deserialize(json_encode($collection->survey), Survey::class, 'json');

            $questionCollection = new QuestionCollection($surveyCode);

            foreach ($collection->questions as $item) {
                /** @var AbstractQuestion $question */
                $question = $this->questionFactory->createQuestion($item->type, json_encode($item));
                $questionCollection->addQuestion($question);
            }

            if (!isset($this->surveys[$surveyCode])) {
                $this->surveys[$surveyCode] = $survey;
            }

            $this->questions[] = $questionCollection;
        }
    }

    /**
     * @return array
     */
    private function readFile()
    {
        $content = [];

        if ($folder = opendir($this->storagePath)) {
            while (false !== ($file = readdir($folder))) {
                $filePath = sprintf('%s/%s', $this->storagePath, $file);

                if ($file !== '.' && $file !== '..') {
                    $json = file_get_contents($filePath);
                    $content[] = json_decode($json);
                }
            }
            closedir($folder);
        }

        return $content;
    }

    /**
     * @return array
     */
    public function getSurveys(): array
    {
        return $this->surveys;
    }

    /**
     * @return array
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    /**
     * @param array $surveys
     */
    public function setSurveys(array $surveys)
    {
        $this->surveys = $surveys;
    }

    /**
     * @param array $questions
     */
    public function setQuestions(array $questions)
    {
        $this->questions = $questions;
    }
}
