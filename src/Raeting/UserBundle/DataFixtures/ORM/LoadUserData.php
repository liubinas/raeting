<?php

namespace Raeting\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Raeting\UserBundle\Entity\User;

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
        $userService = $this->container->get('user.service.user');

        $user = $userService->getByEmail('estina@estina.lt');
        $user->setSlug('estina_estina');
        
        $manager->flush();
        
        $user = $userService->createUser();
        
        $user->setEmail('marius.b@estina.lt');
        $user->setRole(\Raeting\UserBundle\Entity\User::ROLE_ADMIN);
        $user->setFirstname('Jonas');
        $user->setLastname('Jonaitis');
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $user->setPassword($encoder->encodePassword('labadiena', $user->getSalt()));
        $user->setSlug('fixture');

        $date = new \DateTime('NOW');
        $user->setCreateDate($date);

        $this->addReference('user.default.raeting', $user);

        $manager->persist($user);
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}