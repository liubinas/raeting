<?php

namespace Raeting\RaetingBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class SymbolRepository extends EntityRepository
{
    public function findSymbolsByKeyword($keyword, $limit)
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.symbol LIKE :keyword')
            ->setParameter('keyword', '%'.$keyword.'%')
            ->setMaxResults($limit)
            ->getQuery();
        
        return $query->getResult();
    }
    
    public function findtickersByKeyword($keyword, $limit)
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.symbol LIKE :keyword')
            ->andWhere('p.type = :type')
            ->setParameter('keyword', '%'.$keyword.'%')
            ->setParameter('type', Entity\Symbol::TYPE_TICKER)
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }
    
    public function getSymbolsForStockImport($em)
    {
        $query = $em->createQuery('SELECT sy FROM RaetingRaetingBundle:Symbol sy 
                                   WHERE EXISTS 
                                        (SELECT si.id FROM RaetingRaetingBundle:Signals si WHERE si.symbol = sy.id) 
                                        AND sy.type = :type');
        
        try {
            return $query->setParameter('type', 'ticker')->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}