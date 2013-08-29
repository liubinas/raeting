<?php

namespace Raeting\RaetingBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;
use Raeting\UserBundle\Entity\User;

class Signals
{

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
        
    public function getNew()
    {        
        return new Entity\Signals();
    }

    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }
    
    public function getBy($query)
    {
        return $result = $this->getRepository()->createQueryBuilder('a')
                ->select('s', 'u', 'q')
                ->from('Raeting\RaetingBundle\Entity\Signals', 's')
                ->leftJoin('s.user', 'u')
                ->leftJoin('s.quote', 'q')
                ->where('q.title LIKE :query')
                ->orWhere('u.firstname LIKE :query')
                ->orWhere('u.lastname LIKE :query')
                ->setParameter('query', '%'.$query.'%')
                ->getQuery()
                ->getResult();
    }

    public function save(Entity\Signals $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
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
    
    public function getRepository() 
    {
        return $this->em->getRepository('RaetingRaetingBundle:Signals');
    }
}
