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
                ->select('s, t')
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
    
    public function getAnalystEstimationRangeByTicker($analyst, $ticker)
    {
        $query = $this->createQueryBuilder('s')
                ->select('MIN(s.date) as min_date, MAX(s.date) as max_date')
                ->leftJoin('s.ticker', 't')
                ->where('t.symbol = :ticker')
                ->andWhere('s.analyst = :analyst')
                ->setParameter('ticker', $ticker)
                ->setParameter('analyst', $analyst)
                ->getQuery();
        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        
    }
    
    public function getAllByAnalystAndTickerForGraph($analyst, $ticker)
    {
        $query = $this->createQueryBuilder('s')
                ->select('s, t')
                ->leftJoin('s.ticker', 't')
                ->where('t.symbol = :ticker')
                ->andWhere('s.analyst = :analyst')
                ->setParameter('ticker', $ticker)
                ->setParameter('analyst', $analyst)
                ->getQuery();
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        
    }
    
    public function findOneBySymbolAndAnalystAndDate($symbol, $analyst, $date)
    {
        $query = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.ticker = :symbol')
                ->andWhere('s.analyst = :analyst')
                ->andWhere('s.date LIKE :date')
                ->setParameter('symbol', $symbol)
                ->setParameter('analyst', $analyst)
                ->setParameter('date', '%'.$date.'%')
                ->getQuery();
        
        
        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function getAllByAnalystAndTicker($analyst, $ticker, $perPage, $page)
    {
        $query = $this->createQueryBuilder('s')
                ->select('s, t')
                ->leftJoin('s.ticker', 't')
                ->where('t.symbol = :ticker')
                ->andWhere('s.analyst = :analyst')
                ->setParameter('ticker', $ticker)
                ->setParameter('analyst', $analyst)
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
                ->select('s')
                ->where('s.analyst = :analyst')
                ->setParameter('analyst', $analyst)
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