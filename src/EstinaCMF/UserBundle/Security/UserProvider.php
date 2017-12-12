<?php
namespace EstinaCMF\UserBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use EstinaCMF\UserBundle\Entity\User;

class UserProvider implements UserProviderInterface
{

    protected $userService;

    public function __construct($userService)
    {
        $this->userService = $userService;
    }

    /**
     * @see UserProviderInterface
     */
    public function loadUserByUsername($username)
    {
        $user = $this->userService->getByEmail($username);
        if ($user instanceof User) {

            return $user;
        } else {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
    }

    /**
     * @see UserProviderInterface
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @see UserProviderInterface
     */
    public function supportsClass($class)
    {
        return $class === 'EstinaCMF\UserBundle\Security\User';
    }
}
