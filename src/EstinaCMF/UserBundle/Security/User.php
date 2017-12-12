<?php

namespace EstinaCMF\UserBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User instance for Security authentication
 */
class User implements UserInterface
{

    protected $username;
    protected $password;
    protected $role;
    protected $salt;
    protected $id;

    protected $roleMap = array(
        'admin'    => 'ROLE_ADMIN',
        'user' => 'ROLE_USER',
    );

    public function __construct($username = null, $password = null, $role = null, $id = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->id = $id;
        $this->salt = '';
    }

    /**
     * @see UserInterface
     */
    public function getRoles()
    {
        return array($this->roleMap[$this->role]);
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @see UserInterface
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        //Nothing is here until we are not storing sensitive data in plain text.
    }

    /**
     * @see UserInterface
     */
    public function equals(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }
        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }
}
