<?php

namespace Raeting\RaetingBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class SignalsRepository extends EntityRepository
{
    public function getAllWithPaging($perPage, $page)
    {
        $query = $this->createQueryBuilder('s')
                ->select('s')
                ->getQuery();
        
        $query = $this->addLimits($query, $perPage, $page);
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    private function addLimits($query, $perPage, $page)
    {
        $query->setMaxResults((int)$perPage);
        $query->setFirstResult((int)($page-1)*$perPage);
        
        return $query;
    }
    
    public function getAllByQuery($query, $perPage, $page)
    {
        $query = $this->createQueryBuilder('s')
                ->select('s', 'u', 'q')
                ->leftJoin('s.user', 'u')
                ->leftJoin('s.symbol', 'q')
                ->where('q.title LIKE :query')
                ->orWhere('u.firstname LIKE :query')
                ->orWhere('u.lastname LIKE :query')
                ->setParameter('query', '%'.$query.'%')
                ->getQuery();
        
        $query = $this->addLimits($query, $perPage, $page);
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        
    }
    
    public function getAllByQueryAndUser($query, $user, $perPage, $page)
    {
        $query = $this->createQueryBuilder('s')
                ->select('s', 'u', 'q')
                ->leftJoin('s.user', 'u')
                ->leftJoin('s.symbol', 'q')
                ->where('q.title LIKE :query')
                ->andWhere('u.id LIKE :user')
                ->setParameter('query', '%'.$query.'%')
                ->setParameter('user', '%'.$user.'%')
                ->getQuery();
        
        $query = $this->addLimits($query, $perPage, $page);
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function getAllByUserForChart($user)
    {
        $query = $this->createQueryBuilder('s')
                ->select('s.pips')
                ->andWhere('s.user = :user')
                ->setParameter('user', $user)
                ->getQuery();
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function countByQueryAndUser($query, $user)
    {
        $query = $this->createQueryBuilder('s')
                ->select('count(s.id) counter')
                ->leftJoin('s.user', 'u')
                ->leftJoin('s.symbol', 'q')
                ->where('q.title LIKE :query')
                ->andWhere('u.id LIKE :user')
                ->setParameter('query', '%'.$query.'%')
                ->setParameter('user', '%'.$user.'%')
                ->getQuery();
        
        try {
            $result =  $query->getSingleResult();
            return $result['counter'];
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function getAllByTrader($user, $perPage, $page)
    {
        $query = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.user = :user')
                ->setParameter('user', $user)
                ->getQuery();
        
        $query = $this->addLimits($query, $perPage, $page);
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function countByTrader($user)
    {
        $query = $this->createQueryBuilder('s')
                ->select('count(s.id) counter')
                ->where('s.user = :user')
                ->setParameter('user', $user)
                ->getQuery();
        
        try {
            $result =  $query->getSingleResult();
            return $result['counter'];
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function countByQuery($query)
    {
        $query = $this->createQueryBuilder('s')
                ->select('count(s.id) counter')
                ->leftJoin('s.user', 'u')
                ->leftJoin('s.symbol', 'q')
                ->where('q.title LIKE :query')
                ->orWhere('u.firstname LIKE :query')
                ->orWhere('u.lastname LIKE :query')
                ->setParameter('query', '%'.$query.'%')
                ->getQuery();
        
        try {
            $result =  $query->getSingleResult();
            return $result['counter'];
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function countAll()
    {
        $query = $this->createQueryBuilder('s')
                ->select('count(s.id) counter')
                ->getQuery();
        
        try {
            $result =  $query->getSingleResult();
            return $result['counter'];
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    private function getQueryByRequest($request)
    {
        $query = $this->createQueryBuilder('s')
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
        }
        
        if($request->get('offset')){
            $query->setFirstResult((int)$request->get('offset'));
        }
        return $query;
    }
    
    public function getAllSignalsByRequest($request)
    {
        $query = $this->getQueryByRequest($request)->getQuery();
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function getAllSignalsByRequestAndTraderSlug($request, $slug)
    {
        $query = $this->getQueryByRequest($request);
        $query = $query->andWhere('u.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery();
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function CountSignalsByRequest($request)
    {
        $query = $this->getQueryByRequest($request);
        $query->select('count(s.id) counter');
        $query->setMaxResults(null);
        $query->setFirstResult(null);
        
        $query = $query->getQuery();
        
        try {
            $result =  $query->getSingleResult();
            return $result['counter'];
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function getLatest()
    {
        $query = $this->createQueryBuilder('s')
                ->select('s')
                ->orderBy('s.created', 'desc')
                ->setMaxResults(1)
                ->getQuery();
        
        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}