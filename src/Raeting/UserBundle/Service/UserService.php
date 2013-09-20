<?php

namespace Raeting\UserBundle\Service;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

use Doctrine\ORM\EntityManager;
use Raeting\UserBundle\Entity\User;

use EstinaCMF\UserBundle\Service\UserService as BaseService;

class UserService extends BaseService
{
    public $defaultLimit = 10;
    
    public $defaultOffset = 0;
    
    protected function getRepository()
    {
        return $this->em->getRepository('RaetingUserBundle:User');
    }
    
    public function updateUser()
    {
        return $this->em->flush();
    }
    
    public function createUser()
    {
        return new User();
    }
    
    public function insertUser($user)
    {
        $this->em->persist($user);
        return $this->em->flush();;
    }
    
    private function getQueryByRequest($request)
    {
        $query = $this->getRepository()->createQueryBuilder('u')
                ->select('u');
        
        if($request->get('q')){
            $query->where('u.firstname LIKE :q')
            ->orWhere('u.lastname LIKE :q')
            ->setParameter('q', '%'.$request->get('q').'%');
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
    
    public function getTradersByRequest($request)
    {
        $query = $this->getQueryByRequest($request);
        return $query->getQuery()
                ->getResult();
    }
    
    public function getTradersCountByRequest($request)
    {
        $query = $this->getQueryByRequest($request);
        $query->select('count(u.id) counter');
        $query->setMaxResults(null);
        $query->setFirstResult(null);
        
        $result = $query->getQuery()
                ->getSingleResult();
        
        return $result['counter'];
    }

    public function getBySlug($slug)
    {
        return $this->getRepository()->findOneBy(array('slug'=>$slug));
    }
    
    public function createSlug($name, $surname)
    {
        $i = 0;
        $found = false;
        while($found == false){
            if($i == 0){
                $slug = strtolower($name.'_'.$surname);
            }else{
                $slug = strtolower($name.'_'.$surname.$i);
            }
            $user = $this->getBySlug($slug);
            if(empty($user)){
                $found = true;
            }
            $i++;
        }
        return $slug;
    }
    
    public function countAll()
    {
        $result = $this->getRepository()->createQueryBuilder('u')
                ->select('count(u.id) counter')
                ->getQuery()
                ->getSingleResult();
        
        return $result['counter'];
    }
    
    private function addLimits($query, $perPage, $page)
    {
        $query->setMaxResults((int)$perPage);
        $query->setFirstResult((int)($page-1)*$perPage);
        
        return $query;
    }
    
    public function getAllWithPaging($perPage, $page)
    {
        $query = $this->em->createQuery(
            'SELECT u.id, u.firstname, u.lastname, u.fbname, u.slug, u.createDate, sum(s.pips) pips, sum(s.profit) profit, sum(s.totalSignals) signals
            FROM RaetingUserBundle:User u,
                 RaetingUserBundle:UserStats s
            WHERE u.id = s.userid
            GROUP BY u.id'
                
        );
        
        $query = $this->addLimits($query, $perPage, $page);
        
        return $query->getResult();
    }
}
