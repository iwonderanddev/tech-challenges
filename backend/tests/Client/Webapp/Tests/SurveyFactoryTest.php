<?php

namespace Client\Webapp\Tests;

use IWD\JOBINTERVIEW\Client\Webapp\Survey\Date;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\Factory as SurveyFactory;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\Numeric;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\Qcm;
use IWD\JOBINTERVIEW\Client\Webapp\Survey\SurveyException;
use Silex\WebTestCase;

Class SurveyFactoryTest extends WebTestCase
{

    public function createApplication()
    {
        return require ROOT_PATH . '/src/Client/Webapp/app.php';
    }

    /**
     *  @dataProvider surveyFactoryDataProvider
     *  @param String $surveyType
     *  @param String $surveyClassname
     */
    public function testSurveyFactory(string $surveyType, string $surveyClassname)
    {
        $survey = SurveyFactory::factory($surveyType);
        $this->assertInstanceOf($surveyClassname, $survey);
    }

    /**
     *  @return array
     */
    public function surveyFactoryDataProvider(): array
    {
        return [
            [
                'surveyType' => SurveyFactory::QCM,
                'surveyClassname' => Qcm::class,
            ],
            [
                'surveyType' => SurveyFactory::NUMERIC,
                'surveyClassname' => Numeric::class,
            ],
            [
                'surveyType' => SurveyFactory::DATE,
                'surveyClassname' => Date::class,
            ],
        ];
    }

    /**
     * @expectedException SurveyException
     */
    public function testSurveyFactoryException()
    {
        $this->expectException(SurveyException::class);
        SurveyFactory::factory('thisSurveyDoesntExist');
    }
}