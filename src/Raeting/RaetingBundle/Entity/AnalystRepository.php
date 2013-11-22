<?php

namespace Raeting\RaetingBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class AnalystRepository extends EntityRepository
{
    
    private function addLimits($query, $perPage, $page)
    {
        $query->setMaxResults((int)$perPage);
        $query->setFirstResult((int)($page-1)*$perPage);
        
        return $query;
    }
    
    public function getAllWithPaging($perPage, $page, $search = null, $sort = null)
    {
        return $this->getAllAnalysts($perPage, $page, $search, $sort);
    }
    
    public function getAllAnalysts($perPage = null, $page = null, $search = null, $sort = null)
    {
        $query = $this->createQueryBuilder('a')
                ->select('a')
                ->leftJoin('a.totalReturn', 't');
        
        if(!$search != null){
            $query->andWhere('a.name LIKE :search OR a.company LIKE :search')
                    ->setParameter('search', '%'.$search.'%');
        }
        
        if($perPage != null && $page != null){
            $query = $this->addLimits($query, $perPage, $page);
        }
        
        if($sort != null){
            $query->orderBy('t.value', $sort);
        }else{
            $query->orderBy('a.rank', 'asc');
        }
        
        $query = $query->getQuery();
        
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function countAll($search = null, $search = null)
    {
        $query = $this->createQueryBuilder('a')
                ->select('count(a.id) counter')
                ->join('a.totalReturn', 't');
        
        if(!$search != null){
            $query->andWhere('a.name LIKE :search OR a.company LIKE :search')
                    ->setParameter('search', '%'.$search.'%');
        }
        
        $query= $query->getQuery();
        
        try {
            $result =  $query->getSingleResult();
            return $result['counter'];
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function getAllSortedByTotalReturn($sort)
    {
        return $this->getAllAnalysts(null, null, null, $sort);
    }
    
    public function getAllWithPagingByQuery($perPage, $page, $query)
    {
        return $this->getAllWithPaging($perPage, $page, $query);
    }
    
    public function countAllByQuery($query)
    {
        return $this->countAll($query);
    }
    
    public function getTopAnalyst()
    {
        $query = $this->createQueryBuilder('a')
                ->select('a.name, a.company, sum(t.value) as amount')
                ->leftJoin('a.totalReturn', 't')
                ->orderBy('amount', 'desc')
                ->groupBy('t.analyst')
                ->setMaxResults(1)
                ->getQuery();
        
        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}