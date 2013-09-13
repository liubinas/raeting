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
}
