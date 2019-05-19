<?php

namespace Client\Webapp\Tests;

use Silex\WebTestCase;

define('ROOT_PATH', realpath('.'));

class AppTest extends WebTestCase
{

    public function createApplication()
    {
        return require ROOT_PATH . '/src/Client/Webapp/app.php';
    }

    public function testApiRoot()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $response = $client->getResponse();

        $this->assertTrue($response->isOk());
        $this->assertEquals('Status OK', $response->getContent());
    }

    public function testApiRead()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/read');
        $response = $client->getResponse();

        $this->assertTrue($response->isOk());
        $this->assertEquals('[{"name":"Chartres","code":"XX2"},{"name":"Paris","code":"XX1"},{"name":"Melun","code":"XX3"}]', $response->getContent());
    }

    /**
     *  @dataProvider apiAggregateDataProvider
     *
     *  @param String $surveyCode
     *  @param String $output
     */
    public function testApiAggregate(string $surveyCode, string $output)
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/aggregate/' . $surveyCode);
        $response = $client->getResponse();

        $this->assertTrue($response->isOk());
        $this->assertEquals($output, $response->getContent());
    }

    /**
     *  @return array
     */
    public function apiAggregateDataProvider(): array
    {
        return [
            [
                'surveyCode' => 'XX1',
                'output' => '[{"label":"What best sellers are available in your store?","answers":{"Product 1":0,"Product 2":2,"Product 3":1,"Product 4":0,"Product 5":4,"Product 6":0}},{"label":"Number of products?","answers":697},{"label":"What is the visit date?","answers":["2017-09-14T09:45:00.000Z","2017-06-09T00:00:00.000Z","2016-03-29T11:04:50.000Z","2016-04-29T11:04:50.000Z","2016-02-28T11:04:50.000Z"]}]',
            ],
            [
                'surveyCode' => 'XX4',
                'output' => '["This survey doesnt exist: XX4"]',
            ],
        ];
    }
}