<?php

namespace Raeting\RaetingBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Quote sample data fixtures.
 */
class LoadQuoteData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $quoteService = $this->container->get('raetingraeting.service.quote');

        $entity = $quoteService->getNew();

        $entity->setTitle('Apple');
        $entity->setMarket($manager->merge($this->getReference('market.forex')));

        $this->addReference('quote.apple', $entity);

        $manager->persist($entity);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}