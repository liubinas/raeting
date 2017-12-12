<?php

namespace EstinaCMF\UserBundle\Tests\Service;

use Estina\Tests;
use EstinaCMF\UserBundle\Service\User;

/**
 * User service test
 */
class UserTest extends \Estina\Tests\TestCase {

    /**
     * Create user service instance.
     * 
     * @return User
     */
    protected function getService()
    {
        $userModel = $this->getUserModelMock();
        $encoderFactory = $this->getEncoderFactoryMock();

        return new User($userModel, $encoderFactory);
    }

    /**
     * Return user model mock.
     * 
     * @return \Raeting\UserBundle\Model\User
     */
    protected function getUserModelMock()
    {
        return $this->getPlainMock('\EstinaCMF\UserBundle\Model\User');
    }

    /**
     * Return some password encoder mock.
     * 
     * @return Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder
     */
    protected function getEncoderMock()
    {
        return $this->getPlainMock('Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder');
    }

    /**
     * Return encoder factory mock.
     * 
     * @return Symfony\Component\Security\Core\Encoder\EncoderFactory
     */
    protected function getEncoderFactoryMock() {

        $encoder = $this->getEncoderMock();

        $factory = $this->getPlainMock('Symfony\Component\Security\Core\Encoder\EncoderFactory');
        $factory
            ->expects($this->any())
            ->method('getEncoder')
            ->will($this->returnValue($encoder));

        return $factory;
    }

    /**
     * testGetByEmail 
     */
    public function testGetByEmail()
    {
        $user = $this->getService();

        $userData = array(
            'id' => 31337,
            'email' => 'estina@estina.lt',
        );

        $userModel = $this->getUserModelMock();
        $userModel
            ->expects($this->once())
            ->method('getByEmail')
            ->with($userData['email'])
            ->will($this->returnValue($userData));

        $this->setHiddenProperty($user, 'userModel', $userModel);

        $this->assertSame($userData, $user->getByEmail($userData['email']));
    }

    /**
     * testRegister 
     */
    public function testRegister()
    {
        $user = $this->getService();

        $userModel = $this->getUserModelMock();
        $userModel
            ->expects($this->once())
            ->method('insert');

        $this->setHiddenProperty($user, 'userModel', $userModel);

        $userData = array(
            'firstname' => 'A',
            'lastname' => 'B',
            'email' => 'estina@estina.lt',
            'password' => 'labadiena'
        );

        //Everything is ok.
        $user->register($userData);

        $userModel
            ->expects($this->once())
            ->method('getByEmail')
            ->will($this->returnValue(array('firstname' => 'Existing User')));

        //User exist.
        try {
            $user->register($userData);
            $this->fail("\UnexpectedValueException must be thrown when user already exist.");
        } catch (\UnexpectedValueException $e) {
            //Exception must be thrown.
        }
    }



}
