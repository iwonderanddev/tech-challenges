<?php
namespace IWD\JOBINTERVIEW\Tests\Factory;

use IWD\JOBINTERVIEW\Domain\Model\Question\NumericQuestion;
use IWD\JOBINTERVIEW\Domain\Model\Survey;
use IWD\JOBINTERVIEW\Factory\QuestionFactory;
use IWD\JOBINTERVIEW\Persistence\Repository\Json\SurveyRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

class SurveyRepositoryTest extends TestCase
{
    /** @var MockObject $serializer */
    protected $serializer;

    /** @var MockObject $factory */
    protected $factory;

    /** @var string $storagePath */
    protected $storagePath = __DIR__ .'/data';

    /** @var SurveyRepository $baseRepository */
    protected $repository;

    public function setUp()
    {
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->factory = $this->createMock(QuestionFactory::class);

    }

    public function testGetAll()
    {
        $this->serializer->expects($this->any())
            ->method('deserialize')
            ->willReturn($this->getSurvey());

        $this->factory->expects($this->any())
            ->method('createQuestion')
            ->willReturn($this->getNumericQuestion());

        $this->repository = new SurveyRepository($this->serializer, $this->factory, $this->storagePath);
        $surveys = $this->repository->getAll();

        $this->assertArrayHasKey('XX1', $surveys);
        $this->assertArrayHasKey('XX2', $surveys);
        $this->assertArrayHasKey('XX3', $surveys);

        $this->assertEquals($this->getSurvey(), $surveys['XX1']);
        $this->assertEquals($this->getSurvey(), $surveys['XX2']);
        $this->assertEquals($this->getSurvey(), $surveys['XX3']);


    }

    private function getSurvey()
    {
        return new Survey('survey_name', 'XX1');
    }

    private function getNumericQuestion()
    {
        $question = new NumericQuestion();
        $question->setLabel('a question ?');
        $question->setAnswer(10);

        return $question;
    }
}
