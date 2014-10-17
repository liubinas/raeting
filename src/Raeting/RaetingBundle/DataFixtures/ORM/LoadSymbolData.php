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
        $entity->setSymbol('AAPL');
        $entity->setTitle('Apple Inc');
        $entity->setPipsPosition(0);
        $entity->setMarket($manager->merge($this->getReference('market.nasdaq')));
        $entity->setType($entity::TYPE_TICKER);
        $entity->setCurrency('USD');
        $this->addReference('ticker.aapl', $entity);
        $manager->persist($entity);

        $entity = $symbolService->getNew();
        $entity->setSymbol('BBRY');
        $entity->setTitle('BlackBerry Limited');
        $entity->setPipsPosition(0);
        $entity->setMarket($manager->merge($this->getReference('market.nasdaq')));
        $entity->setType($entity::TYPE_TICKER);
        $entity->setCurrency('USD');
        $this->addReference('ticker.bbry', $entity);
        $manager->persist($entity);

        $entity = $symbolService->getNew();
        $entity->setSymbol('FB');
        $entity->setTitle('Facebook Inc');
        $entity->setPipsPosition(0);
        $entity->setMarket($manager->merge($this->getReference('market.nasdaq')));
        $entity->setType($entity::TYPE_TICKER);
        $entity->setCurrency('USD');
        $this->addReference('ticker.fb', $entity);
        $manager->persist($entity);

        $entity = $symbolService->getNew();
        $entity->setSymbol('GOOG');
        $entity->setTitle('Google Inc');
        $entity->setPipsPosition(0);
        $entity->setMarket($manager->merge($this->getReference('market.nasdaq')));
        $entity->setType($entity::TYPE_TICKER);
        $entity->setCurrency('USD');
        $this->addReference('ticker.goog', $entity);
        $manager->persist($entity);

        $entity = $symbolService->getNew();
        $entity->setSymbol('JNJ');
        $entity->setTitle('Johnson & Johnson');
        $entity->setPipsPosition(0);
        $entity->setMarket($manager->merge($this->getReference('market.nyse')));
        $entity->setType($entity::TYPE_TICKER);
        $entity->setCurrency('USD');
        $this->addReference('ticker.jnj', $entity);
        $manager->persist($entity);

        $entity = $symbolService->getNew();
        $entity->setSymbol('MSFT');
        $entity->setTitle('Microsoft Corporation');
        $entity->setPipsPosition(0);
        $entity->setMarket($manager->merge($this->getReference('market.nasdaq')));
        $entity->setType($entity::TYPE_TICKER);
        $entity->setCurrency('USD');
        $this->addReference('ticker.msft', $entity);
        $manager->persist($entity);

        $entity = $symbolService->getNew();
        $entity->setSymbol('WFC');
        $entity->setTitle('Wells Fargo & Co');
        $entity->setPipsPosition(0);
        $entity->setMarket($manager->merge($this->getReference('market.nyse')));
        $entity->setType($entity::TYPE_TICKER);
        $entity->setCurrency('USD');
        $this->addReference('ticker.wfc', $entity);
        $manager->persist($entity);

        $entity = $symbolService->getNew();
        $entity->setSymbol('XOM');
        $entity->setTitle('Exxon Mobil Corporation');
        $entity->setPipsPosition(0);
        $entity->setMarket($manager->merge($this->getReference('market.nyse')));
        $entity->setType($entity::TYPE_TICKER);
        $entity->setCurrency('USD');
        $this->addReference('ticker.xom', $entity);
        $manager->persist($entity);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}