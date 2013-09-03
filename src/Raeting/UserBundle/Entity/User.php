<?php

namespace Raeting\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use EstinaCMF\UserBundle\Entity\User as UserBase;
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends UserBase
{
}