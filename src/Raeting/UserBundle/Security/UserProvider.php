<?php
namespace Raeting\UserBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

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
        $userData = $this->userService->getByEmail($username);

        if ($userData) {
            $username = $userData['email'];
            $password = $userData['password'];

            $this->userService->update(array('id' => $userData['id'], 'last_login' => date("Y-m-d H:i:s")));

            return new User($username, $password, $userData['usergroup'], $userData['id']);
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
        return $class === 'Raeting\UserBundle\Security\User';
    }
}
