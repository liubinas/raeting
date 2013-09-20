<?php

namespace Raeting\RaetingBundle\Tests\Utility;

use Raeting\RaetingBundle\Service\Signals;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PipsCalculatorTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }
    
    public function testAdd()
    {
        $signalService = new Signals($this->em);
        $result = $signalService->countPips(1.35640, 1.35645, 4);

        $this->assertEquals(0.5, $result);

        
        $result = $signalService->countPips(134.138, 134.095, 2);

        $this->assertEquals(-4.3, $result);
    }
}