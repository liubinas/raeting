<?php

namespace EstinaCMF\UserBundle\Tests\Security;

use EstinaCMF\UserBundle\Security\User;

use Estina\Tests;

/**
 * UserTest 
 */
class UserTest extends \Estina\Tests\TestCase {

    /**
     * testGetRoles 
     */
    public function testGetRoles()
    {
        $user = new User('pawka', '', 'admin');
        $this->assertEquals(array('ROLE_ADMIN'), $user->getRoles());


        $user = new User('wsuff', '', 'customer');
        $this->assertEquals(array('ROLE_CUSTOMER'), $user->getRoles());
    }

}
