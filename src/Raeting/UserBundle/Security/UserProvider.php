<?php
namespace Raeting\UserBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Raeting\UserBundle\Entity\User;

use EstinaCMF\UserBundle\Security\UserProvider as BaseProvider;

class UserProvider extends BaseProvider
{

    public function findUserBy($params)
    {
        $user = $this->userService->getBy($params);
        if ($user instanceof User) {

            return $user;
        } else {
            return null;
        }
    }
    
    public function updateUser()
    {
        return $this->userService->updateUser();
    }
    
    public function createUser()
    {
        return $this->userService->createUser();
    }
    
    public function insertUser($user)
    {
        return $this->userService->insertUser($user);
    }
}
