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
class LoadAnalystData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $analystService = $this->container->get('raetingraeting.service.analyst');

        $entity = $analystService->getNew();
        $entity->setName('Jeferies (Misek)');
        $entity->setSlug('misek');

        $manager->persist($entity);
        //----------------------------------
        $entity = $analystService->getNew();
        $entity->setName('Barclays (Reitzes)');
        $entity->setSlug('reitzes');

        $manager->persist($entity);
        //----------------------------------
        $entity = $analystService->getNew();
        $entity->setName('Piper Jaffray (Munster)');
        $entity->setSlug('munster');

        $manager->persist($entity);
        //----------------------------------
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}