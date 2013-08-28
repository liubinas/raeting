<?php

namespace Raeting\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Signal sample data fixtures.
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $userService = $this->container->get('user.service.userem');

        $user = $userService->getNew();
        
        $user->setEmail('estina@estina.lt');
        $user->setUsergroup('customer');
        $user->setPassword('5fb3760172db1462dcb9d34cd1e24a226ec8a86d'); //labadiena
        $user->setFirstname('labadiena');
        $user->setLastname('labadiena');
        $user->setStreet('labadiena');
        $user->setState('labadiena');
        $user->setPostalcode('labadiena');

        $date = new \DateTime('NOW');
        $user->setCreatedon($date);
        $user->setFacebook('labadiena');
        $user->setLinkedin('labadiena');

        $this->addReference('user.default', $user);

        $manager->persist($user);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}