<?php

namespace Raeting\RaetingBundle\Tests\Service;

use Raeting\RaetingBundle\Service\Signals;
use Raeting\UserBundle\Service\UserService;
use Estina\Tests\TestCase;

class SignalsTest extends TestCase
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
        $this->em = $this->getPlainMock('\Doctrine\ORM\EntityManager');
        $this->userService = $this->getPlainMock('\Raeting\UserBundle\Service\UserService');
        $this->currencyRateService = $this->getPlainMock('\Raeting\RaetingBundle\Service\CurrencyRate');
    }

    /**
     * @dataProvider addData
     */
    public function testAdd($from, $to, $pipsPosition, $expectation)
    {
        $signalService = new Signals($this->em, $this->userService, 10, $this->currencyRateService);
        $result = $signalService->countPips($from, $to, $pipsPosition);

        $this->assertEquals($expectation, $result);
    }

    public function addData()
    {
        return array(
            array(1.35640, 1.35645, 4, 0.5),
            array(134.138, 134.095, 2, -4.3),
        );
    }
}