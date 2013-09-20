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
        $this->assertContains('"firstName":"admin"', $content);
        $this->assertContains('"lastName":"admin"', $content);
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
        $this->assertContains('"uuid":"1"', $content);
        $this->assertContains('"type":"Buy"', $content);
        $this->assertContains('"symbol":"EUR\/USD"', $content);
        $this->assertContains('"open":"1.328800"', $content);
        $this->assertContains('"takeProfit":"1.327900"', $content);
        $this->assertContains('"stopLoss":"1.378800"', $content);
        $this->assertContains('"profit":', $content);
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
        $this->assertContains('<uuid>1</uuid>', $content);
        $this->assertContains('<type>Buy</type>', $content);
        $this->assertContains('<symbol>EUR/USD</symbol>', $content);
        $this->assertContains('<open>1.328800</open>', $content);
        $this->assertContains('<takeProfit>1.327900</takeProfit>', $content);
        $this->assertContains('<stopLoss>1.378800</stopLoss>', $content);
        $this->assertContains('<profit>', $content);
        $this->assertContains('<description>fixture</description>', $content);
        $this->assertContains('<status>', $content);
        $this->assertContains('<dateCreated>', $content);
        $this->assertContains('<dateOpened>', $content);
        $this->assertContains('<dateClosed>', $content);
    }
    
    public function checkTraderXml($content)
    {
        $this->assertContains('<firstName>admin</firstName>', $content);
        $this->assertContains('<lastName>admin</lastName>', $content);
        $this->assertContains('<company/>', $content);
        $this->assertContains('<about/>', $content);
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
