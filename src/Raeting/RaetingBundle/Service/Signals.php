<?php

namespace Raeting\RaetingBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;
use Raeting\UserBundle\Entity\User;

class Signals
{
    public $defaultLimit = 10;
    public $defaultOffset = 0;

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
        return $result = $this->getRepository()->createQueryBuilder('s')
                ->select('s', 'u', 'q')
                ->leftJoin('s.user', 'u')
                ->leftJoin('s.quote', 'q')
                ->where('q.title LIKE :query')
                ->orWhere('u.firstname LIKE :query')
                ->orWhere('u.lastname LIKE :query')
                ->setParameter('query', '%'.$query.'%')
                ->getQuery()
                ->getResult();
    }
    
    public function getByTrader($user)
    {
        return $result = $this->getRepository()->createQueryBuilder('s')
                ->select('s')
                ->where('s.user = :user')
                 ->setParameter('user', $user)
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
    
    private function getQueryByRequest($request)
    {
        $query = $this->getRepository()->createQueryBuilder('s')
                ->select('s', 'u', 'q')
                ->leftJoin('s.user', 'u')
                ->leftJoin('s.quote', 'q');
        
        if($request->get('type') == 'buy'){
            $query->andWhere('s.buy = 1');
        }elseif($request->get('type') == 'sell'){
            $query->andWhere('s.buy = 0');
        }
        
        if($request->get('quote')){
            $query->andWhere('q.title LIKE :quote')
            ->setParameter('quote', '%'.$request->get('quote').'%');
        }
        
        if($request->get('trader')){
            $query->andWhere('u.slug LIKE :trader')
            ->setParameter('trader', '%'.$request->get('trader').'%');
        }
        
        if($request->get('status')){
            $query->andWhere('s.status = :status')
            ->setParameter('status', $request->get('status'));
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
    
    public function getSignalsByRequest($request)
    {
        $query = $this->getQueryByRequest($request);
        return $query->getQuery()
                ->getResult();
    }
    
    public function getSignalsByRequestAndTraderSlug($request, $slug)
    {
        $query = $this->getQueryByRequest($request);
        $query->andWhere('u.slug = :slug')
            ->setParameter('slug', $slug);
        
        return $query->getQuery()
                ->getResult();
    }
    
    public function getSignalsCountByRequest($request)
    {
        $query = $this->getQueryByRequest($request);
        $query->select('count(s.id) counter');
        $query->setMaxResults(null);
        $query->setFirstResult(null);
        
        $result = $query->getQuery()
                ->getSingleResult();
        
        return $result['counter'];
    }
    
    public function getByUuid($id)
    {
        return $this->getRepository()->findOneByUuid($id);
    }
}
