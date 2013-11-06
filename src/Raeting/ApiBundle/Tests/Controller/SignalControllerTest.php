<?php

namespace Raeting\ApiBundle\Tests\Controller;

use Raeting\ApiBundle\Tests\Controller\EntityCheck;

/*
 *
 */
class ApiSignalControllerTest extends EntityCheck
{
    /*
     * Test list json
     */
    public function testIndexJson()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'api/signals.json');

        $response = $client->getResponse();
        $content = $response->getContent();
        
        $this->checkSignalJson($content);
        
        $this->assertResponse($response, 200, 'application/json');

    }
    /*
     * Test list xml
     */
    public function testIndexXml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'api/signals.xml');

        $response = $client->getResponse();
        $content = $response->getContent();
        
        $this->checkSignalXml($content);
        
        $this->assertResponse($response, 200, 'text/xml; charset=UTF-8');

    }
    /*
     * Test show json
     */
    public function testShowJson()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'api/signals/527a49841050a.json');

        $response = $client->getResponse();
        $content = $response->getContent();
        
        $this->checkSignalWithTraderJson($content);
        
        $this->assertResponse($response, 200, 'application/json');

    }
    /*
     * Test show xml
     */
    public function testShowXml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'api/signals/527a49841050a.xml');

        $response = $client->getResponse();
        $content = $response->getContent();
        
        $this->checkSignalWithTraderXml($content);
        
        $this->assertResponse($response, 200, 'text/xml; charset=UTF-8');

    }
}
