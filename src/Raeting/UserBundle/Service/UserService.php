<?php

namespace Raeting\UserBundle\Service;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

use Doctrine\ORM\EntityManager;
use Raeting\UserBundle\Entity\User;

class UserService
{
    public $defaultLimit = 10;
    
    public $defaultOffset = 0;

    public function __construct($em, $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }
    
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
    
    public function toAscii($str, $replace=array()) {
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}

	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

	return $clean;
}
    
    public function createSlug($name, $surname)
    {
        $i = 0;
        $found = false;
        while($found == false){
            $asciiSlug = $this->toAscii($name.'-'.$surname);
            if($i == 0){
                $slug = $asciiSlug;
            }else{
                $slug = $asciiSlug.$i;
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
            'SELECT u.id, u.firstname, u.lastname, u.fbname, u.company, u.slug, u.createDate, sum(us.pips) pips, sum(us.totalSignals) signals
            FROM RaetingUserBundle:User u
            LEFT JOIN RaetingUserBundle:UserStats us
            WITH u.id = us.userid
            WHERE (SELECT count(s.id) 
                   FROM RaetingRaetingBundle:Signals s
                   WHERE s.user = u.id) > 0
            GROUP BY u.id'
                
        );
        
        $query = $this->addLimits($query, $perPage, $page);
        
        return $query->getResult();
    }
    
    public function traderToArray($trader)
    {
        $traderArr = array(
            'slug'=>$trader->getSlug(),
            'firstName'=>$trader->getFirstname(),
            'lastName'=>$trader->getLastname(),
            'company'=>$trader->getCompany(),
            'about'=>$trader->getAbout(),
        );
        return $traderArr;
    }
    
    public function getLatest()
    {
        $query = $this->getRepository()->createQueryBuilder('u')
                ->select('u')
                ->orderBy('u.createDate', 'desc')
                ->setMaxResults(1);
        
        return $query->getQuery()->getSingleResult();;
    }
}
