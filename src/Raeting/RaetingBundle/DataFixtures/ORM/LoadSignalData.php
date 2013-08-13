<?php

namespace Raeting\RaetingBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Signal sample data fixtures.
 */
class LoadSignalData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $signalService = $this->container->get('raetingraeting.service.signals');

        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000));
        $signal->setQuote()

        $manager->persist($signal);
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}