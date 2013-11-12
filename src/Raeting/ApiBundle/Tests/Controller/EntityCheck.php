<?php

namespace Raeting\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/*
 *
 */
class EntityCheck extends WebTestCase
{
    public function checkTraderJson($content)
    {
        $this->assertContains('"firstName":"Jonas"', $content);
        $this->assertContains('"lastName":"Jonaitis"', $content);
        $this->assertContains('"company":', $content);
        $this->assertContains('"about":', $content);
        $this->assertContains('"slug":"fixture"', $content);
    }
    
    public function checkSignalWithTraderJson($content)
    {
        $this->checkSignalJson($content);
        $this->assertContains('"trader":{"slug":"fixture"', $content);
    }
    
    public function checkSignalJson($content)
    {
        $this->assertContains('"type"', $content);
        $this->assertContains('"symbol":"EURUSD"', $content);
        $this->assertContains('"open"', $content);
        $this->assertContains('"takeProfit"', $content);
        $this->assertContains('"stopLoss"', $content);
        $this->assertContains('"description":"fixture"', $content);
        $this->assertContains('"status":', $content);
        $this->assertContains('"dateCreated":', $content);
        $this->assertContains('"dateOpened":', $content);
        $this->assertContains('"dateClosed":', $content);
    }
    
    public function checkSignalWithTraderXml($content)
    {
        $this->checkSignalXml($content);
        $this->assertContains('<trader><slug>fixture</slug>', $content);
    }
    
    public function checkSignalXml($content)
    {
        $this->assertContains('<type>', $content);
        $this->assertContains('<symbol>EURUSD</symbol>', $content);
        $this->assertContains('<open>', $content);
        $this->assertContains('<takeProfit>', $content);
        $this->assertContains('<stopLoss>', $content);
        $this->assertContains('<description>fixture</description>', $content);
        $this->assertContains('<status>', $content);
        $this->assertContains('<dateCreated>', $content);
        $this->assertContains('<dateOpened>', $content);
        $this->assertContains('<dateClosed>', $content);
    }
    
    public function checkTraderXml($content)
    {
        $this->assertContains('<firstName>Jonas</firstName>', $content);
        $this->assertContains('<lastName>Jonaitis</lastName>', $content);
        $this->assertContains('<company', $content);
        $this->assertContains('<about', $content);
        $this->assertContains('<slug>fixture</slug>', $content);
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
