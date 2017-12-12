<?php

namespace EstinaCMF\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use EstinaCMF\UserBundle\Entity\User;

/**
 * UserRegisteredEvent
 *
 */
class UserRegisteredEvent extends Event
{
    const NAME = 'estinacmf_user.event.registered';

    /**
     * @var \EstinaCMF\UserBundle\Entity\User
     */
    protected $user;

    /**
     * @param User     $user
     * @param Response $response
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}