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
    
    public function getAll($analyst = null, $search = null, $ticker = null, $perPage = null, $page = null, $order = 'desc')
    {
        $query = $this->createQueryBuilder('s')
                ->select('s, t')
                ->leftJoin('s.ticker', 't')
                ->leftJoin('s.analyst', 'a');
        
        if($analyst != null){
            $query->andWhere('s.analyst = :analyst')
                ->setParameter('analyst', $analyst);
        }
        
        if($search != null){
            $query->andWhere('t.title LIKE :search OR a.name LIKE :search')
                ->setParameter('search', '%'.$search.'%');
        }
        
        if($ticker != null){
            $query->andWhere('t.symbol = :ticker')
                ->setParameter('ticker', $ticker);
        }
        
        if($perPage != null && $page != null){
            $query = $this->addLimits($query, $perPage, $page);
        }
        
        $query = $query->orderBy('s.date', $order)
                ->getQuery();
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        
    }
    
    public function getAllByAnalystAndQuery($analyst, $query, $perPage, $page)
    {
        return $this->getAll($analyst, $query, null, $perPage, $page);
        
    }
    
    public function getAllByQuery($query, $perPage, $page)
    {
        return $this->getAll(null, $query, null, $perPage, $page);
    }
    
    public function getAllByTickerWithPaging($ticker, $perPage, $page)
    {
        return $this->getAll(null, null, $ticker, $perPage, $page);
    }
    
    public function getAllByTickerWithPagingByQuery($ticker, $perPage, $page, $query)
    {
        return $this->getAll(null, $query, $ticker, $perPage, $page);
    }
    
    public function getAllWithPaging($perPage, $page)
    {
        return $this->getAll(null, null, null, $perPage, $page);
    }
    
    public function getAllByAnalyst($analyst, $perPage, $page)
    {
        return $this->getAll($analyst, null, null, $perPage, $page);
    }
    
    public function getAllByAnalystAndTicker($analyst, $ticker, $perPage, $page, $order)
    {
        return $this->getAll($analyst, null, $ticker, $perPage, $page, $order);
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
                ->orderBy('s.date', 'asc')
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
    
    public function getLastSymbolsByAnalyst($analyst, $amount)
    {
        $query = $this->createQueryBuilder('s')
                ->select('s')
                ->andWhere('s.analyst = :analyst')
                ->orderBy('s.date', 'desc')
                ->setParameter('analyst', $analyst)
                ->groupBy('s.ticker')
                ->setMaxResults($amount)
                ->getQuery();
        
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function getLastDateByAnalyst($analyst)
    {
        $query = $this->createQueryBuilder('s')
                ->select('s')
                ->andWhere('s.analyst = :analyst')
                ->orderBy('s.date', 'desc')
                ->setParameter('analyst', $analyst)
                ->setMaxResults(1)
                ->getQuery();
        
        
        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function countAll($analyst = null, $search = null, $ticker = null)
    {
        $query = $this->createQueryBuilder('a')
                ->select('count(a.id) counter')
                ->leftJoin('a.ticker', 't');
        
        if($analyst != null){
            $query->andWhere('a.analyst = :analyst')
                ->setParameter('analyst', $analyst);
        }
        if($search != null){
            $query->andWhere('t.title LIKE :search')
                ->setParameter('search', '%'.$search.'%');
        }
        
        if($ticker != null){
            $query->andWhere('t.symbol = :ticker')
                ->setParameter('ticker', $ticker);
        }
        
        $query = $query->getQuery();
        
        try {
            $result =  $query->getSingleResult();
            return $result['counter'];
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function countAllByAnalystAndQuery($analyst, $query)
    {
        return $this->countAll($analyst, $query);
    }

    public function countAllByAnalyst($analyst)
    {
        return $this->countAll($analyst);
    }
    
    public function countAllByQuery($query)
    {
        return $this->countAll(null, $query);
    }
    
    public function countAllByTicker($ticker)
    {
        return $this->countAll(null, null, $ticker);
    }
    
    public function countAllByTickerAndQuery($ticker, $query)
    {
        return $this->countAll(null, $query, $ticker);
    }
    
    public function getAnalystTickers($analyst)
    {
        $query = $this->createQueryBuilder('s')
                ->select('t.id, t.symbol')
                ->leftJoin('s.ticker', 't')
                ->andWhere('s.analyst = :analyst')
                ->groupBy('t.id')
                ->setParameter('analyst', $analyst)
                ->getQuery();
        
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}