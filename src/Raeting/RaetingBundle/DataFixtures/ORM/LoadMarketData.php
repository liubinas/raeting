<?php

namespace Raeting\RaetingBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Market sample data fixtures.
 */
class LoadMarketData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $marketService = $this->container->get('raetingraeting.service.market');

        $entity = $marketService->getNew();
        $entity->setTitle('forex');
        $this->addReference('market.forex', $entity);

        $manager->persist($entity);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}