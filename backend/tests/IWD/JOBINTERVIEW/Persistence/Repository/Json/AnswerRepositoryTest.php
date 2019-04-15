<?php
namespace IWD\JOBINTERVIEW\Tests\Factory;

use IWD\JOBINTERVIEW\Domain\Model\Question\NumericQuestion;
use IWD\JOBINTERVIEW\Domain\Model\Survey;
use IWD\JOBINTERVIEW\Factory\QuestionFactory;
use IWD\JOBINTERVIEW\Persistence\Repository\Json\AnswerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

class AnswerRepositoryTest extends TestCase
{
    /** @var MockObject $serializer */
    protected $serializer;

    /** @var MockObject $factory */
    protected $factory;

    /** @var string $storagePath */
    protected $storagePath = __DIR__ .'/data';

    /** @var AnswerRepository $baseRepository */
    protected $repository;

    public function setUp()
    {
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->factory = $this->createMock(QuestionFactory::class);
    }

    public function testGetAllBySurveyCode()
    {
        $this->serializer->expects($this->any())
            ->method('deserialize')
            ->willReturn($this->getSurvey());

        $this->factory->expects($this->any())
            ->method('createQuestion')
            ->willReturn($this->getNumericQuestion());

        $this->repository = new AnswerRepository($this->serializer, $this->factory, $this->storagePath);
        $answers = $this->repository->getAllBySurveyCode('XX1');
        $expected = [
            'qcm' => [],
            'number' => 10,
            'dates' => []
        ];

        $this->assertEquals($expected, $answers);
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
