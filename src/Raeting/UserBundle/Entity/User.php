<?php

namespace Raeting\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EstinaCMF\UserBundle\Entity\User as UserBase;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Raeting\UserBundle\Entity\UserRepository")
 */
class User extends UserBase
{
    /**
     * @var string
     *
     * @ORM\Column(name="facebookId", type="string", length=255, nullable=true)
     */
    private $facebookId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="fbname", type="string", length=255, nullable=true)
     */
    private $fbname;
    
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    public function serialize()
    {
        return serialize(array($this->facebookId, parent::serialize()));
    }

    public function unserialize($data)
    {
        list($this->facebookId, $parentData) = unserialize($data);
        parent::unserialize($parentData);
    }

    /**
     * Get the full name of the user (first + last name)
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    /**
     * @param string $facebookId
     * @return void
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }
    
    /**
     * @param string $fbname
     * @return void
     */
    public function setFbname($fbname)
    {
        $this->fbname = $fbname;
    }

    /**
     * @return string
     */
    public function getFbname()
    {
        return $this->fbname;
    }
    
    /**
     * @param string $slug
     * @return void
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param Array
     */
    public function setFBData($fbdata)
    {
        if (isset($fbdata['id'])) {
            $this->setFacebookId($fbdata['id']);
        }
        if (isset($fbdata['username'])) {
            $this->setFbname($fbdata['username']);
        }
        if (isset($fbdata['first_name'])) {
            $this->setFirstname($fbdata['first_name']);
        }
        if (isset($fbdata['last_name'])) {
            $this->setLastname($fbdata['last_name']);
        }
        if (isset($fbdata['email'])) {
            $this->setEmail($fbdata['email']);
        }
    }
    public function __toString()
    {
        return $this->getSlug();
    }
}