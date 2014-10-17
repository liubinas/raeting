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
class LoadDividendData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        /*
        $dividendService = $this->container->get('raetingraeting.service.dividend');

        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2013-11-14'));
        $entity->setTicker($this->getReference('ticker.apple'));
        $entity->setAmount(3.05);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2013-08-15'));
        $entity->setTicker($this->getReference('ticker.apple'));
        $entity->setAmount(3.05);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2013-05-16'));
        $entity->setTicker($this->getReference('ticker.apple'));
        $entity->setAmount(3.05);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2013-02-14'));
        $entity->setTicker($this->getReference('ticker.apple'));
        $entity->setAmount(2.65);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2012-11-15'));
        $entity->setTicker($this->getReference('ticker.apple'));
        $entity->setAmount(2.65);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2012-08-16'));
        $entity->setTicker($this->getReference('ticker.apple'));
        $entity->setAmount(2.65);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2013-12-16'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.81);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2013-09-17'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.77);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2013-06-17'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.77);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2013-03-15'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.77);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2012-12-17'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.77);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2012-09-18'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.7);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2012-06-15'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.7);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2012-03-15'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.7);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2011-12-15'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.7);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2011-09-16'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.61);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2011-06-15'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.61);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2011-03-15'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.61);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2010-12-15'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.61);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2010-09-16'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.55);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2010-06-15'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.55);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2010-03-15'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.55);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2009-12-15'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.55);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2009-09-15'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.5);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2009-06-22'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.5);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2009-03-16'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.5);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2008-12-15'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.5);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2008-09-16'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.375);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2008-06-23'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.375);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2008-03-17'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.375);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2007-12-03'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(1.5);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2006-12-01'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(1);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2005-12-01'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.67);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2004-12-01'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.55);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2003-12-01'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.4);

        $manager->persist($entity);
        //----------------------------------
        $entity = $dividendService->getNew();
        $entity->setDate(new \DateTime('2002-12-02'));
        $entity->setTicker($this->getReference('ticker.mcd'));
        $entity->setAmount(0.235);

        $manager->persist($entity);
        //----------------------------------
        $manager->flush();
         */
    }

    public function getOrder()
    {
        return 3;
    }
}