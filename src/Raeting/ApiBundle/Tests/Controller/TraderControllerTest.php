<?php

namespace Raeting\ApiBundle\Tests\Controller;

use Raeting\ApiBundle\Tests\Controller\EntityCheck;

/*
 *
 */
class ApiTraderControllerTest extends EntityCheck
{
    public function testIndexJson()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'api/traders.json');
        $response = $client->getResponse();
        $content = $response->getContent();
        
        $this->checkTraderJson($content);
        
        $this->assertResponse($response, 200, 'application/json');

    }

    public function testIndexXml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'api/traders.xml');
        
        $response = $client->getResponse();
        $content = $response->getContent();
        
        $this->checkTraderXml($content);
        
        $this->assertResponse($response, 200, 'text/xml; charset=UTF-8');

    }
    
    public function testShowJson()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'api/traders/fixture.json');

        $response = $client->getResponse();
        $content = $response->getContent();
        
        $this->checkTraderJson($content);
        
        $this->assertResponse($response, 200, 'application/json');

    }

    public function testShowXml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'api/traders/fixture.xml');

        $response = $client->getResponse();
        $content = $response->getContent();
        
        $this->checkTraderXml($content);
        
        $this->assertResponse($response, 200, 'text/xml; charset=UTF-8');

    }
    
    public function testTraderSignalsJson()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'api/traders/fixture/signals.json');

        $response = $client->getResponse();
        $content = $response->getContent();
        
        $this->checkSignalJson($content);
        
        $this->assertResponse($response, 200, 'application/json');

    }

    public function testTraderSignalsXml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'api/traders/fixture/signals.xml');

        $response = $client->getResponse();
        $content = $response->getContent();
        
        $this->checkSignalXml($content);
        
        $this->assertResponse($response, 200, 'text/xml; charset=UTF-8');

    }
}
