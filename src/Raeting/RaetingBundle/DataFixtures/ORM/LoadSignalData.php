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
        /*
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
         */
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.321); $signal->setTakeprofit(1.313);
        $signal->setStoploss(1.326); $signal->setStatus('closed');

        $signal->setCreated(new \DateTime('2013-09-05')); $signal->setOpened(new \DateTime('2013-09-05 12:32')); $signal->setOpenExpire($date);

        $signal->setClosed(new \DateTime('2013-09-05 14:56')); $signal->setCloseExpire($date);
        $signal->setOpenPrice(1.321);
        $signal->setClosePrice(1.313);

        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurusd')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.312); $signal->setTakeprofit(1.304);
        $signal->setStoploss(1.315); $signal->setStatus('closed');

        $signal->setCreated(new \DateTime('2013-09-06')); $signal->setOpened(new \DateTime('2013-09-06 02:41')); $signal->setOpenExpire($date);

        $signal->setClosed(new \DateTime('2013-09-06 14:35')); $signal->setCloseExpire($date);
        $signal->setOpenPrice(1.312);
        $signal->setClosePrice(1.315);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurusd')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(1); $signal->setOpen(1.582); $signal->setTakeprofit(1.6);
        $signal->setStoploss(1.575); $signal->setStatus('closed');

        $signal->setCreated(new \DateTime('2013-09-11')); $signal->setOpened(new \DateTime('2013-09-11 19:29')); $signal->setOpenExpire($date);

        $signal->setClosed(new \DateTime('2013-09-18 20:01')); $signal->setCloseExpire($date);
        $signal->setOpenPrice(1.582);
        $signal->setClosePrice(1.6);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.gbpusd')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.58); $signal->setTakeprofit(1.575);
        $signal->setStoploss(1.5826); $signal->setStatus('closed');

        $signal->setCreated(new \DateTime('2013-09-12')); $signal->setOpened(new \DateTime('2013-09-12 09:13')); $signal->setOpenExpire($date);

        $signal->setClosed(new \DateTime('2013-09-12 16:30')); $signal->setCloseExpire($date);
        $signal->setOpenPrice(1.58);
        $signal->setClosePrice(1.5826);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.gbpusd')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(1); $signal->setOpen(1.355); $signal->setTakeprofit(1.37);
        $signal->setStoploss(1.345); $signal->setStatus('closed');

        $signal->setCreated(new \DateTime('2013-09-19')); $signal->setOpened(new \DateTime('2013-09-19 10:01')); $signal->setOpenExpire($date);

        $signal->setClosed(new \DateTime('2013-10-18 12:27')); $signal->setCloseExpire($date);
        $signal->setOpenPrice(1.355);
        $signal->setClosePrice(1.37);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurusd')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(1); $signal->setOpen(134.3); $signal->setTakeprofit(136);
        $signal->setStoploss(133.7); $signal->setStatus('closed');

        $signal->setCreated(new \DateTime('2013-09-20')); $signal->setOpened(new \DateTime('2013-09-20 12:01')); $signal->setOpenExpire($date);

        $signal->setClosed(new \DateTime('2013-09-23 09:44')); $signal->setCloseExpire($date);
        $signal->setOpenPrice(134.3);
        $signal->setClosePrice(133.7);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurjpy')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(1); $signal->setOpen(1.347); $signal->setTakeprofit(1.356);
        $signal->setStoploss(1.3435); $signal->setStatus('closed');

        $signal->setCreated(new \DateTime('2013-09-24')); $signal->setOpened(new \DateTime('2013-09-24 12:32')); $signal->setOpenExpire($date);

        $signal->setClosed(new \DateTime('2013-09-27 16:09')); $signal->setCloseExpire($date);
        $signal->setOpenPrice(1.347);
        $signal->setClosePrice(1.356);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurusd')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(1); $signal->setOpen(1.3503); $signal->setTakeprofit(1.3536);
        $signal->setStoploss(1.3458); $signal->setStatus('closed');

        $signal->setCreated(new \DateTime('2013-09-27')); $signal->setOpened(new \DateTime('2013-09-27 10:55')); $signal->setOpenExpire($date);

        $signal->setClosed(new \DateTime('2013-09-27 13:57')); $signal->setCloseExpire($date);
        $signal->setOpenPrice(1.3503);
        $signal->setClosePrice(1.3536);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurusd')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(1); $signal->setOpen(1.356); $signal->setTakeprofit(1.362);
        $signal->setStoploss(1.3535); $signal->setStatus('new');

        $signal->setCreated(new \DateTime('2013-10-02')); $signal->setOpenExpire($date);

        $signal->setCloseExpire($date);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurusd')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.604); $signal->setTakeprofit(1.6023);
        $signal->setStoploss(1.6077); $signal->setStatus('closed');

        $signal->setCreated(new \DateTime('2013-10-04')); $signal->setOpened(new \DateTime('2013-10-04 13:30')); $signal->setOpenExpire($date);

        $signal->setClosed(new \DateTime('2013-10-04 21:31')); $signal->setCloseExpire($date);
        $signal->setOpenPrice(1.604);
        $signal->setClosePrice(1.6023);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.gbpusd')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(1); $signal->setOpen(1.352); $signal->setTakeprofit(1.3544);
        $signal->setStoploss(1.3507); $signal->setStatus('closed');

        $signal->setCreated(new \DateTime('2013-10-09')); $signal->setOpened(new \DateTime('2013-10-09 09:38')); $signal->setOpenExpire($date);

        $signal->setClosed(new \DateTime('2013-10-09 14:03')); $signal->setCloseExpire($date);
        $signal->setOpenPrice(1.352);
        $signal->setClosePrice(1.3507);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurusd')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.3585); $signal->setTakeprofit(1.3546);
        $signal->setStoploss(1.3593); $signal->setStatus('closed');

        $signal->setCreated(new \DateTime('2013-10-11')); $signal->setOpened(new \DateTime('2013-10-14 14:40')); $signal->setOpenExpire($date);

        $signal->setClosed(new \DateTime('2013-10-15 11:00')); $signal->setCloseExpire($date);
        $signal->setOpenPrice(1.3585);
        $signal->setClosePrice(1.3546);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurusd')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(0); $signal->setOpen(1.3585); $signal->setTakeprofit(1.348);
        $signal->setStoploss(1.362); $signal->setStatus('new');

        $signal->setCreated(new \DateTime('2013-09-05')); $signal->setOpenExpire($date);

        $signal->setCloseExpire($date);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurusd')));

        $manager->persist($signal);
        //---------------------------------
        $signal = $signalService->getNew();
        $signal->setUuid(rand(0,1000)); $signal->setBuy(1); $signal->setOpen(134); $signal->setTakeprofit(134.74);
        $signal->setStoploss(133.55); $signal->setStatus('closed');

        $signal->setCreated(new \DateTime('2013-10-23')); $signal->setOpened(new \DateTime('2013-10-23 06:33')); $signal->setOpenExpire($date);

        $signal->setClosed(new \DateTime('2013-10-24 08:02')); $signal->setCloseExpire($date);
        $signal->setOpenPrice(134);
        $signal->setClosePrice(134.74);


        $signal->setUser($manager->merge($this->getReference('user.default.raeting')));
        $signal->setSymbol($manager->merge($this->getReference('quote.eurjpy')));

        $manager->persist($signal);
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}