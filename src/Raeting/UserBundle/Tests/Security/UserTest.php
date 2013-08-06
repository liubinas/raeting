<?php

namespace Raeting\UserBundle\Tests\Security;

use Raeting\CoreBundle\Tests\TestCase;
use Raeting\UserBundle\Security\User;

/**
 * UserTest 
 */
class UserTest extends TestCase {

    /**
     * testGetRoles 
     */
    public function testGetRoles()
    {
        $user = new User('pawka', '', 'admin');
        $this->assertEquals(array('ROLE_ADMIN'), $user->getRoles());

        $user = new User('pawka', '', 'merchant');
        $this->assertEquals(array('ROLE_MERCHANT'), $user->getRoles());

        $user = new User('pawka', '', 'customer');
        $this->assertEquals(array('ROLE_CUSTOMER'), $user->getRoles());
    }

}
