<?php

namespace EstinaCMF\UserBundle\Service;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

use Doctrine\ORM\EntityManager;
use EstinaCMF\UserBundle\Entity\User;

class UserService
{
    protected $em;
    protected $encoderFactory;
    protected $securityContext;

    public function __construct(
        EntityManager $em,
        EncoderFactory $encoderFactory
    )
    {
        $this->em = $em;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @return User
     */
    public function register(User $user)
    {
        $user->setCreateDate(new \DateTime());
        $user->setRole(User::ROLE_USER);
        $user->setSalt(md5(time() . ' robotuku armija'));
        $user->setPassword($this->encodePassword($user->getPassword(), $user->getSalt()));

        $this->save($user);

        return $user;
    }

    public function getNew()
    {
        return new User();
    }

    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getByEmail($email)
    {
        return $this->getRepository()->findOneBy(array('email'=>$email));
    }
    
    public function getBy($params)
    {
        return $this->getRepository()->findOneBy($params);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function delete($param)
    {
        if (is_int($param)) {
            $entity = $this->get($param);
        } else {
            $entity = $param;
        }

        $this->em->remove($entity);
        $this->em->flush();
    }

    public function save(User $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function encodePassword($password, $salt = null)
    {
        $user = new User();
        if (null !== $salt) {
            $user->setSalt($salt);
        }

        $encoder = $this->encoderFactory->getEncoder($user);
        $password = $encoder->encodePassword($password, $user->getSalt());

        return $password;
    }

    public function changePassword($request)
    {
        $user = $this->getByEmail($request['email']);
        if (false === $user) {
            throw $this->createNotFoundException('Unable to find required User.');
        } else {
            if ($request['hash'] === $user->getRecoveryHash()) {
                $salt = strtolower($this->generateHash($request['email']));
                $user->setSalt($salt);
                $user->setPassword($this->encodePassword($request['password'], $user->getSalt()));

                $user->setRecoveryHash(null);
                $this->em->persist($user);
                $this->em->flush();
            }
        }
        return $user;
    }

    public function createUserHash($email)
    {
        $user = $this->getByEmail($email);

        $hash = $this->generateHash($email);
        $user->setRecoveryHash($hash);
        $this->em->persist($user);
        $this->em->flush($user);

        return $hash;
    }

    protected function generateHash($email)
    {
        $string = $this->encodePassword(rand() . $email . time());

        return strtoupper(substr($string, 0, 16));
    }

    protected function getRepository()
    {
        return $this->em->getRepository('EstinaCMFUserBundle:User');
    }


}
