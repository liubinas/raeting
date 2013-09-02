<?php

namespace Raeting\UserBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\UserBundle\Entity;

class UserEm
{

    public $defaultLimit = 10;
    
    public $defaultOffset = 0;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getNew()
    {
        return new Entity\User();
    }

    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function save(Entity\User $entity)
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
        return $this->em->getRepository('RaetingUserBundle:User');
    }
    
    private function getQueryByRequest($request)
    {
        $query = $this->getRepository()->createQueryBuilder('u')
                ->select('u');
        
        if($request->get('q')){
            $query->where('u.firstname LIKE :q')
            ->orWhere('u.lastname LIKE :q')
            ->setParameter('q', '%'.$request->get('q').'%');
        }
        
        if($request->get('limit')){
            $query->setMaxResults((int)$request->get('limit'));
        }else{
            $query->setMaxResults($this->defaultLimit);
        }
        
        if($request->get('offset')){
            $query->setFirstResult((int)$request->get('offset'));
        }
        return $query;
    }
    
    public function getTradersByRequest($request)
    {
        $query = $this->getQueryByRequest($request);
        return $query->getQuery()
                ->getResult();
    }
    
    public function getTradersCountByRequest($request)
    {
        $query = $this->getQueryByRequest($request);
        $query->select('count(u.id) counter');
        $query->setMaxResults(null);
        $query->setFirstResult(null);
        
        $result = $query->getQuery()
                ->getSingleResult();
        
        return $result['counter'];
    }
    
    public function getBySlug($slug)
    {
        return $this->getRepository()->findOneBySlug($slug);
    }
}
