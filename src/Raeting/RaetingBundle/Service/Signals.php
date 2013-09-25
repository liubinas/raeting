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
    
    public function getAllWithPaging($perPage, $page)
    {
        $query = $this->getRepository()->createQueryBuilder('s')
                ->select('s')
                ->getQuery();
        
        $query = $this->addLimits($query, $perPage, $page);
        
        return $query->getResult();
    }
    
    public function getAllNew()
    {
        return $this->getRepository()->findBy(array('status' => Entity\Signals::STATUS_NEW));
    }
    
    private function addLimits($query, $perPage, $page)
    {
        $query->setMaxResults((int)$perPage);
        $query->setFirstResult((int)($page-1)*$perPage);
        
        return $query;
    }
    
    public function getBy($query, $perPage, $page)
    {
        $query = $this->getRepository()->createQueryBuilder('s')
                ->select('s', 'u', 'q')
                ->leftJoin('s.user', 'u')
                ->leftJoin('s.symbol', 'q')
                ->where('q.title LIKE :query')
                ->orWhere('u.firstname LIKE :query')
                ->orWhere('u.lastname LIKE :query')
                ->setParameter('query', '%'.$query.'%')
                ->getQuery();
        
        $query = $this->addLimits($query, $perPage, $page);
        
        return $query->getResult();
        
    }
    
    public function getByQueryAndUser($query, $user, $perPage, $page)
    {
        $query = $this->getRepository()->createQueryBuilder('s')
                ->select('s', 'u', 'q')
                ->leftJoin('s.user', 'u')
                ->leftJoin('s.symbol', 'q')
                ->where('q.title LIKE :query')
                ->andWhere('u.id LIKE :user')
                ->setParameter('query', '%'.$query.'%')
                ->setParameter('user', '%'.$user.'%')
                ->getQuery();
        
        $query = $this->addLimits($query, $perPage, $page);
        
        return $query->getResult();
    }
    
    public function getByUserForChart($user)
    {
        $query = $this->getRepository()->createQueryBuilder('s')
                ->select('s.pips')
                ->andWhere('s.user = :user')
                ->setParameter('user', $user)
                ->getQuery();
        
        return $query->getResult();
    }
    
    public function countByQueryAndUser($query, $user)
    {
        $result = $this->getRepository()->createQueryBuilder('s')
                ->select('count(s.id) counter')
                ->leftJoin('s.user', 'u')
                ->leftJoin('s.symbol', 'q')
                ->where('q.title LIKE :query')
                ->andWhere('u.id LIKE :user')
                ->setParameter('query', '%'.$query.'%')
                ->setParameter('user', '%'.$user.'%')
                ->getQuery()
                ->getSingleResult();
        
        return $result['counter'];
    }
    
    public function getByTrader($user, $perPage, $page)
    {
        $query = $this->getRepository()->createQueryBuilder('s')
                ->select('s')
                ->where('s.user = :user')
                ->setParameter('user', $user)
                ->getQuery();
        
        $query = $this->addLimits($query, $perPage, $page);
        
        return $query->getResult();
    }
    
    public function countByTrader($user)
    {
        $result = $this->getRepository()->createQueryBuilder('s')
                ->select('count(s.id) counter')
                ->where('s.user = :user')
                ->setParameter('user', $user)
                ->getQuery()
                ->getSingleResult();
        
        return $result['counter'];
    }
    
    public function countByQuery($query)
    {
        $result = $this->getRepository()->createQueryBuilder('s')
                ->select('count(s.id) counter')
                ->leftJoin('s.user', 'u')
                ->leftJoin('s.symbol', 'q')
                ->where('q.title LIKE :query')
                ->orWhere('u.firstname LIKE :query')
                ->orWhere('u.lastname LIKE :query')
                ->setParameter('query', '%'.$query.'%')
                ->getQuery()
                ->getSingleResult();
        
        return $result['counter'];
    }

    public function countAll()
    {
        $result = $this->getRepository()->createQueryBuilder('s')
                ->select('count(s.id) counter')
                ->getQuery()
                ->getSingleResult();
        
        return $result['counter'];
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
                ->leftJoin('s.symbol', 'q');
        
        if($request->get('type') == 'buy'){
            $query->andWhere('s.buy = 1');
        }elseif($request->get('type') == 'sell'){
            $query->andWhere('s.buy = 0');
        }
        
        if($request->get('symbol')){
            $query->andWhere('q.title LIKE :symbol')
            ->setParameter('symbol', '%'.$request->get('symbol').'%');
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
    
    public function countPips($to, $from, $pipsPosition)
    {
        $result = $from - $to;
        $integerLength = strlen(floor($result));
        $result = round($result, 6) * pow(10, $pipsPosition);
        return $result;
    }
    
    public function countPipsAndSave($signal)
    {
        if($signal->getBuy() == 0){
            $pips = $this->countPips($signal->getTakeProfit(), $signal->getOpen(), $signal->getSymbol()->getPipsPosition());
        }else{
            $pips = $this->countPips($signal->getOpen(), $signal->getTakeProfit(), $signal->getSymbol()->getPipsPosition());
        }
        $signal->setPips($pips);
        $this->em->flush();
    }
}
