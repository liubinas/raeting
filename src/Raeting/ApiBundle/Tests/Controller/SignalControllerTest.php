<?php

namespace Raeting\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/*
 *
 */
class ApiSignalControllerTest extends WebTestCase
{
    /*
     * Test list json
     */
    public function testIndexJson()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'api/signals.json');

        //$this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);

        $response = $client->getResponse();
        $this->assertResponse($response, 200, 'application/json');

    }
    /*
     * Test list xml
     */
    public function testIndexXml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'api/signals.xml');

        //$this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);

        $response = $client->getResponse();
        $this->assertResponse($response, 200, 'application/xml');

    }
    /*
     * Test show json
     */
    public function testShowJson()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'api/signal/1.json');

        //$this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);

        $response = $client->getResponse();
        $this->assertResponse($response, 200, 'application/json');

    }
    /*
     * Test show xml
     */
    public function testShowXml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'api/signal/1.xml');

        //$this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);

        $response = $client->getResponse();
        $this->assertResponse($response, 200, 'application/xml');

    }

    /**
     * Assert response code
     *
     * @param $response
     * @param int    $statusCode
     * @param string $contentType
     */
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

    /**
     * SF2/phpunit workaround bellow
     *
     */
    public function tearDown()
    {
        parent::tearDown();

        // workaround for https://github.com/symfony/symfony/issues/2531
        if (ob_get_length() == 0 ) {
            ob_start();
        }
    }
}
