<?php

namespace Raeting\RaetingBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class TickerRateRepository extends EntityRepository
{
    
    public function findAllBySymbolInRange($symbol, $rangeFrom, $rangeTo)
    {
        $query = $this->createQueryBuilder('s')
                ->select('s, t')
                ->leftJoin('s.ticker', 't')
                ->where('t.symbol = :symbol')
                ->andWhere('s.sourceTime >= :rangeFrom')
                ->andWhere('s.sourceTime <= :rangeTo')
                ->setParameter('symbol', $symbol)
                ->setParameter('rangeFrom', $rangeFrom)
                ->setParameter('rangeTo', $rangeTo)
                ->getQuery();
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        
    }
    
    public function findOneByTickerAndDate($symbol, $date)
    {
        $query = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.ticker = :symbol')
                ->andWhere('s.sourceTime LIKE :date')
                ->andWhere('s.high IS NOT NULL')
                ->setParameter('symbol', $symbol)
                ->setParameter('date', '%'.$date.'%')
                ->getQuery();
        
        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function findAllForAggregation($date)
    {
        $query = $this->createQueryBuilder('s')
                ->select('t.id, SUBSTRING( s.sourceTime, 1, 10 ) source_date')
                ->leftJoin('s.ticker', 't')
                ->where('s.sourceTime < :date')
                ->groupBy('source_date, t.id HAVING count(s.id) > 1')
                ->setParameter('date', $date)
                ->getQuery();
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function getRatesBySymbolAndDate($symbolId, $date)
    {
        $query = $this->createQueryBuilder('s')
                ->select('s')
                ->leftJoin('s.ticker', 't')
                ->where('s.sourceTime LIKE :date')
                ->andWhere('t.id = :symbol')
                ->setParameter('date', '%'.$date.'%')
                ->setParameter('symbol', $symbolId)
                ->getQuery();
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}