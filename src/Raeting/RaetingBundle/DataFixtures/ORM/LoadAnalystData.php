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
        $entity->setName('Misek');
        $entity->setSlug('misek');
        $entity->setCompany('Jeferies');
        $entity->setImportSlug('Jeferies (Misek)');

        $manager->persist($entity);
        //----------------------------------
        $entity = $analystService->getNew();
        $entity->setName('Reitzes');
        $entity->setSlug('reitzes');
        $entity->setCompany('Barclays');
        $entity->setImportSlug('Barclays (Reitzes)');

        $manager->persist($entity);
        //----------------------------------
        $entity = $analystService->getNew();
        $entity->setName('Munster');
        $entity->setSlug('munster');
        $entity->setCompany('Piper Jaffray');
        $entity->setImportSlug('Piper Jaffray (Munster)');

        $manager->persist($entity);
        //----------------------------------
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}