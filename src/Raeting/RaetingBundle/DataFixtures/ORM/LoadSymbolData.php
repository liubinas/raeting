<?php

namespace Raeting\RaetingBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Symbol sample data fixtures.
 */
class LoadSymbolData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $symbolService = $this->container->get('raetingraeting.service.symbol');

        $entity = $symbolService->getNew(); 
        $entity->setSymbol('EURUSD'); $entity->setTitle('EUR/USD'); $entity->setPipsPosition(4); $entity->setMarket($manager->merge($this->getReference('market.forex')));
        $entity->setType($entity::TYPE_QUOTE);
        $this->addReference('quote.eurusd', $entity);
        $manager->persist($entity);$manager->flush();
        
        $entity = $symbolService->getNew(); 
        $entity->setSymbol('GBPUSD'); $entity->setTitle('GBP/USD'); $entity->setPipsPosition(4); $entity->setMarket($manager->merge($this->getReference('market.forex')));
        $entity->setType($entity::TYPE_QUOTE);
        $this->addReference('quote.gbpusd', $entity);
        $manager->persist($entity);$manager->flush();
        
        $entity = $symbolService->getNew(); 
        $entity->setSymbol('AUDNZD'); $entity->setTitle('AUD/NZD'); $entity->setPipsPosition(4); $entity->setMarket($manager->merge($this->getReference('market.forex')));
        $entity->setType($entity::TYPE_QUOTE);
        $this->addReference('quote.audnzd', $entity);
        $manager->persist($entity);$manager->flush();
        
        $entity = $symbolService->getNew(); 
        $entity->setSymbol('EURJPY'); $entity->setTitle('EUR/JPY'); $entity->setPipsPosition(2); $entity->setMarket($manager->merge($this->getReference('market.forex')));
        $entity->setType($entity::TYPE_QUOTE);
        $this->addReference('quote.eurjpy', $entity);
        $manager->persist($entity);$manager->flush();
        
        $entity = $symbolService->getNew(); 
        $entity->setSymbol('EURCHF'); $entity->setTitle('EUR/CHF'); $entity->setPipsPosition(4); $entity->setMarket($manager->merge($this->getReference('market.forex')));
        $entity->setType($entity::TYPE_QUOTE);
        $this->addReference('quote.eurchf', $entity);
        $manager->persist($entity);$manager->flush();
        
        $entity = $symbolService->getNew(); 
        $entity->setSymbol('EURNZD'); $entity->setTitle('EUR/NZD'); $entity->setPipsPosition(4); $entity->setMarket($manager->merge($this->getReference('market.forex')));
        $entity->setType($entity::TYPE_QUOTE);
        $this->addReference('quote.eurnzd', $entity);
        $manager->persist($entity);$manager->flush();
        
        $entity = $symbolService->getNew(); 
        $entity->setSymbol('APPL'); $entity->setTitle('Apple'); $entity->setPipsPosition(0); $entity->setMarket($manager->merge($this->getReference('market.forex')));
        $entity->setType($entity::TYPE_TICKER);
        $this->addReference('ticker.apple', $entity);
        $manager->persist($entity);$manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}