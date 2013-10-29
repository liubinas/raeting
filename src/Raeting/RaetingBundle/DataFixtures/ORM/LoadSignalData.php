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
        
        $date = new \DateTime('NOW');
        $dateClose = new \DateTime('NOW + 1hour'); 
        
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(1); $signal->setBuy(0); $signal->setOpen(1.3288); $signal->setTakeprofit(1.3279);
        $signal->setStoploss(1.3788); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurusd')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.32643); $signal->setTakeprofit(1.322);
        $signal->setStoploss(1.37645); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurusd')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.32432); $signal->setTakeprofit(1.322);
        $signal->setStoploss(1.37431); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurusd')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.32431); $signal->setTakeprofit(1.322);
        $signal->setStoploss(1.37435); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurusd')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.58093); $signal->setTakeprofit(1.578);
        $signal->setStoploss(1.63097); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.gbpusd')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.57617); $signal->setTakeprofit(1.575);
        $signal->setStoploss(1.62622); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.gbpusd')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.57465); $signal->setTakeprofit(1.572);
        $signal->setStoploss(1.62465); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.gbpusd')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.57005); $signal->setTakeprofit(1.568);
        $signal->setStoploss(1.62005); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.gbpusd')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(1); $signal->setOpen(1.13581); $signal->setTakeprofit(1.18588);
        $signal->setStoploss(1.08588); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.audnzd')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.5811); $signal->setTakeprofit(1.578);
        $signal->setStoploss(1.63112); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.gbpusd')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.56439); $signal->setTakeprofit(1.56);
        $signal->setStoploss(1.61439); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.gbpusd')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(1); $signal->setOpen(131.414); $signal->setTakeprofit(132.059);
        $signal->setStoploss(130.414); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurjpy')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.23486); $signal->setTakeprofit(1.23473);
        $signal->setStoploss(1.23499); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurchf')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(129.643); $signal->setTakeprofit(129.618);
        $signal->setStoploss(129.675); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurjpy')));

        $manager->persist($signal); $manager->flush();
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.66439); $signal->setTakeprofit(1.66250);
        $signal->setStoploss(1.66653); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurnzd')));

        $manager->persist($signal); $manager->flush();
     //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(520); $signal->setTakeprofit(550);
        $signal->setStoploss(500); $signal->setStatus('new'); $signal->setDescription('fixture');

        $signal->setCreated($date); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed($dateClose); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('ticker.apple')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.321); $signal->setTakeprofit(1.313);
        $signal->setStoploss(1.326); $signal->setStatus('closed');

        $signal->setCreated(new \DateTime('2013-09-05')); $signal->setOpened($date); $signal->setOpenExpire($date);

        $signal->setClosed(new \DateTime('2013-09-05')); $signal->setCloseExpire($dateClose);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurnzd')));

        $manager->persist($signal); $manager->flush();
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}