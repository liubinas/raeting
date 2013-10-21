<?php

namespace Raeting\RaetingBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class AnalysisRepository extends EntityRepository
{
    
    private function addLimits($query, $perPage, $page)
    {
        $query->setMaxResults((int)$perPage);
        $query->setFirstResult((int)($page-1)*$perPage);
        
        return $query;
    }
    
    public function getAllByAnalystAndQuery($analyst, $query, $perPage, $page)
    {
        $query = $this->createQueryBuilder('s')
                ->select('t')
                ->leftJoin('s.ticker', 't')
                ->where('t.title LIKE :query')
                ->setParameter('query', '%'.$query.'%')
                ->getQuery();
        
        $query = $this->addLimits($query, $perPage, $page);
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        
    }
    
    public function getAllByAnalyst($analyst, $perPage, $page)
    {
        $query = $this->createQueryBuilder('s')
                ->getQuery();
        
        $query = $this->addLimits($query, $perPage, $page);
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        
    }
    
    public function countAllByAnalystAndQuery($analyst, $query)
    {
        $query = $this->createQueryBuilder('a')
                ->select('count(a.id) counter')
                ->leftJoin('a.ticker', 't')
                ->where('t.title LIKE :query')
                ->andWhere('a.analyst = :analyst')
                ->setParameter('query', '%'.$query.'%')
                ->setParameter('analyst', $analyst)
                ->getQuery();
        
        try {
            $result =  $query->getSingleResult();
            return $result['counter'];
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function countAllByAnalyst($analyst)
    {
        $query = $this->createQueryBuilder('a')
                ->select('count(a.id) counter')
                ->where('a.analyst = :analyst')
                ->setParameter('analyst', $analyst)
                ->getQuery();
        
        try {
            $result =  $query->getSingleResult();
            return $result['counter'];
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}