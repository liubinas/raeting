<?php

namespace Raeting\RaetingBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class DividendRepository extends EntityRepository
{
    public function getSumByInterval($ticker, $dateFrom, $dateTo)
    {
        $query = $this->createQueryBuilder('d')
                ->select('sum(d.amount) as total')
                ->leftJoin('d.ticker', 't')
                ->where('t.symbol = :ticker')
                ->andWhere('d.date >= :dateFrom')
                ->andWhere('d.date < = :dateTo')
                ->setParameter('ticker', $ticker)
                ->setParameter('dateFrom', $dateFrom)
                ->setParameter('dateTo', $dateTo)
                ->getQuery();
        
        try {
            $result =  $query->getSingleResult();
            return $result['total'];
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}