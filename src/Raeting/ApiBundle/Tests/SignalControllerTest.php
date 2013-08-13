<?php

namespace Raeting\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testIndexJson()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/signals.json');

        //$this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);


        $response = $client->getResponse();
        $this->assertResponse($response, 200, 'application/json');

    }

    public function testIndexXml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/signals.xml');

        //$this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);

        $response = $client->getResponse();
        $this->assertResponse($response, 200, 'application/xml');

    }
    public function testShowJson()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/signal/1.json');

        //$this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);

        $response = $client->getResponse();
        $this->assertResponse($response, 200, 'application/json');

    }

    public function testShowXml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/signal/1.xml');

        //$this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);

        $response = $client->getResponse();
        $this->assertResponse($response, 200, 'application/xml');

    }

    protected function assertResponse($response, $statusCode = 200, $contentType = 'application/json')
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', $contentType),
            $response->headers
        );
    }

    public function tearDown()
    {
        parent::tearDown();

        // workaround for https://github.com/symfony/symfony/issues/2531
        if (ob_get_length() == 0 ) {
            ob_start();
        }
    }
}
