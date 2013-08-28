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
        $signal->setBuy(1);
        $signal->setOpen(1.23);
        $signal->setTakeprofit(1.23);
        $signal->setStoploss(1.23);
        $signal->setClose(1.23);
        $signal->setProfit(0);
        $signal->setDescription('Tryout');
        $signal->setStatus(1);

        $date = new \DateTime('NOW');

        $signal->setOpened($date);
        $signal->setOpenExpire($date);

        $dateClose = new \DateTime('NOW + 1hour');
        $signal->setClosed($dateClose);
        $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default')));
        $signal->setQuote($manager->merge($this->getReference('quote.apple')));

        $manager->persist($signal);
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}