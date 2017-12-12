<?php

namespace EstinaCMF\UserBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
/**
 * UserHelper
 */
class UserHelper extends Helper
{
    //@todo use Service\User instead.
    protected $securityContext;


    public function __construct($securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * Return if user is fully authenticated.
     * 
     * @return bool
     */
    public function isAuthenticated()
    {
        return $this->securityContext->isGranted('IS_AUTHENTICATED_FULLY');
    }

    /**
     * Return currently logged in user
     *
     * @return EstinaCMF\UserBundle\Entity\User
     */
    public function getCurrent()
    {
        if ($this->isAuthenticated()) {
            return $this->securityContext->getToken()->getUser();
        }
    }

    public function getName()
    {
        return 'user';
    }
}
