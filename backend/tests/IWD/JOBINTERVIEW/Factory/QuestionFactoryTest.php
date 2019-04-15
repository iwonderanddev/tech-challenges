<?php
namespace IWD\JOBINTERVIEW\Tests\Factory;

use IWD\JOBINTERVIEW\Domain\Model\Question\DateQuestion;
use IWD\JOBINTERVIEW\Domain\Model\Question\NumericQuestion;
use IWD\JOBINTERVIEW\Domain\Model\Question\QcmQuestion;
use IWD\JOBINTERVIEW\Factory\QuestionFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class QuestionFactoryTest extends TestCase
{
    /** @var SerializerInterface $serializer */
    protected $serializer;

    /** @var QuestionFactory $serializer */
    protected $factory;

    public function setUp()
    {
        $propertyInfo = new \Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor();

        $normalizers = [
            new ArrayDenormalizer(),
            new ObjectNormalizer(null, null, null, $propertyInfo),
        ];

        $encoders = [
            new JsonEncoder()
        ];

        $this->serializer = new Serializer($normalizers, $encoders);
        $this->factory = new QuestionFactory($this->serializer);
    }

    public function testCreateQuestionWithNonExistantType()
    {
        $type = 'invalid';
        $json = '{}';
        $question = $this->factory->createQuestion($type, $json);

        $this->assertNull($question);
    }

    /**
     * @param $type
     * @param $json
     * @param $class
     */
    public function testCreateQuestionWithExistantType($type, $json, $class)
    {
        $question = $this->factory->createQuestion($type, $json);

        $this->assertInstanceOf($class, $question);
    }

    public function questionDataProvider()
    {
        return [
            'QCM type' => [
                'type' => QcmQuestion::QUESTION_TYPE,
                'json' => '{"type": "qcm", "label": 
                    "What best sellers are available in your store?",
                    "options": ["Product 1", "Product 2", "Product 3", "Product 4", "Product 5", "Product 6"],
                    "answer": [true, true, true, true, true, true]
                }',
                'return' => QcmQuestion::class,
            ],
            'Numeric type' => [
                'type' => NumericQuestion::QUESTION_TYPE,
                'json' => '{
                    "type": "numeric",
                    "label": "Number of products?",
                    "options": null,
                    "answer": 6200
                }',
                'return' => NumericQuestion::class,
            ],
            'Date type' => [
                'type' => DateQuestion::QUESTION_TYPE,
                'json' => '{
                    "type": "date",
                    "label": "What is the visit date?",
                    "options": null,
                    "answer": "2017-09-25T12:04:50.000Z"
                }',
                'return' => DateQuestion::class
            ],
        ];
    }
}
