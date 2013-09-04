<?php

namespace Raeting\UserBundle\Service;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

use Doctrine\ORM\EntityManager;
use Raeting\UserBundle\Entity\User;

use EstinaCMF\UserBundle\Service\UserService as BaseService;

class UserService extends BaseService
{
    protected function getRepository()
    {
        return $this->em->getRepository('RaetingUserBundle:User');
    }
    
    public function updateUser()
    {
        return $this->em->flush();
    }
    
    public function createUser()
    {
        return new User();
    }
    
    public function insertUser($user)
    {
        $this->em->persist($user);
        return $this->em->flush();;
    }
}
