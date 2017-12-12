<?php

namespace EstinaCMF\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use EstinaCMF\UserBundle\Entity\User;

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
        // $userService = $this->container->get('estinacmf_user.service.user');

        // $user = $userService->getNew();

        // $user->setEmail('estina@estina.lt');
        // $user->setRole(User::ROLE_ADMIN);
        // $user->setFirstname('admin');
        // $user->setLastname('admin');
        // $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        // $user->setPassword($encoder->encodePassword('labadiena', $user->getSalt()));

        // $date = new \DateTime('NOW');
        // $user->setCreateDate($date);

        // $this->addReference('user.default', $user);

        // $manager->persist($user);
        // $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}