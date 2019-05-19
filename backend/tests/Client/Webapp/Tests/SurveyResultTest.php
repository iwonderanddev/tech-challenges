<?php

namespace Client\Webapp\Tests;

use IWD\JOBINTERVIEW\Client\Webapp\Data\SurveyResult;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\Date;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\Numeric;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\Qcm;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\SurveyInterface;
use Silex\WebTestCase;

class SurveyResultTest extends WebTestCase
{

    public function createApplication()
    {
        return require ROOT_PATH . '/src/Client/Webapp/app.php';
    }

    /**
     *  @dataProvider getSurveyNamesDataProvider
     *
     *  @param array $surveyData
     *  @param array $surveyDataFormatted
     */
    public function testGetSurveyNames(array $surveyData, array $surveyDataFormatted)
    {
        $surveyResult = new SurveyResult();
        $surveys = $surveyResult->getSurveyNames($surveyData);

        $this->assertEquals($surveyDataFormatted, $surveys);
    }

    /**
     *  @return array
     */
    public function getSurveyNamesDataProvider(): array
    {
        return [
            [
                [
                    'XX1' => [
                        'name' => 'Paris',
                        'questions' => [],
                    ],
                    'XX2' => [
                        'name' => 'Chartres',
                        'questions' => [],
                    ],
                ],
                [
                    [
                        'name' => 'Paris',
                        'code' => 'XX1',
                    ],
                    [
                        'name' => 'Chartres',
                        'code' => 'XX2',
                    ],
                ],
            ],
        ];
    }

    /**
     *  @dataProvider aggregateResultsDataProvider
     *
     *  @param array $surveyData
     *  @param string $surveyClass
     *  @param string $label
     *  @param mixed int|array $answers
     */
    public function testAggregateResults(array $surveyData, string $surveyClass, string $label, $answers)
    {
        $surveyResult = new SurveyResult();
        $aggregatedSurvey = $surveyResult->aggregateResults($surveyData);

        $survey = $aggregatedSurvey[0];

        $this->assertInstanceOf($surveyClass, $survey);
        $this->assertEquals($label, $survey->label);
        $this->assertEquals($answers, $survey->answers);
    }

    /**
     *  @return array
     */
    public function aggregateResultsDataProvider(): array
    {
        return [
            [
                'aggregateQcm' => [
                    'qcm' => [
                        [
                            'type' => 'qcm',
                            'label' => 'this is a label',
                            'options' => [
                                'Product xxx',
                                'Product yyy',
                            ],
                            'answer' => [
                                true,
                                false,
                            ],
                        ],
                        [
                            'type' => 'qcm',
                            'label' => 'this is a label',
                            'options' => [
                                'Product xxx',
                                'Product yyy',
                            ],
                            'answer' => [
                                true,
                                true,
                            ],
                        ],
                    ],
                ],
                'surveyClass' => Qcm::class,
                'label' => 'this is a label',
                'answers' => [
                    'Product xxx' => 2,
                    'Product yyy' => 1,
                ],
            ],
            [
                'aggregateNumeric' => [
                    'numeric' => [
                        [
                            'type' => 'numeric',
                            'label' => 'this is a label',
                            'answer' => 100,
                        ],
                        [
                            'type' => 'numeric',
                            'label' => 'this is a label',
                            'answer' => 50,
                        ],
                    ],
                ],
                'surveyClass' => Numeric::class,
                'label' => 'this is a label',
                'answers' => 75,
            ],
            [
                'aggregateDate' => [
                    'date' => [
                        [
                            'type' => 'date',
                            'label' => 'this is a date label',
                            'answer' => '2017-09-14T09:45:00.000Z',
                        ],
                        [
                            'type' => 'numeric',
                            'label' => 'this is a date label',
                            'answer' => '2017-06-09T00:00:00.000Z',
                        ],
                    ],
                ],
                'surveyClass' => Date::class,
                'label' => 'this is a date label',
                'answers' => [
                    '2017-09-14T09:45:00.000Z',
                    '2017-06-09T00:00:00.000Z',
                ],
            ],
        ];
    }
}