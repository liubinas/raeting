<?php

namespace Raeting\RaetingBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;
use Raeting\UserBundle\Service\UserService;

class Signals
{
    
    public function __construct(EntityManager $em, UserService $userService, $defaultLimit)
    {
        $this->em = $em;
        $this->userService = $userService;
        $this->defaultLimit = $defaultLimit;
    }
        
    public function getNew()
    {        
        return new Entity\Signals();
    }

    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }
    
    public function getAllWithPaging($perPage, $page)
    {
        return $this->getRepository()->getAllWithPaging($perPage, $page);
    }
    
    public function getAllNew()
    {
        return $this->getRepository()->findBy(array('status' => Entity\Signals::STATUS_NEW));
    }
    
    public function createEntity($entity, $user, $id)
    {
        $entity->setUser($user);
        $entity->setUuid(md5($id.$id));
        $now = new \DateTime('now');
        $entity->setCreated($now);
        $entity->setOpened($now);
        $entity->setOpenExpire($now);
        $entity->setClosed($now);
        $entity->setCloseExpire($now);
        $this->save($entity);
    }
    
    public function getAllByQuery($query, $perPage, $page)
    {
        return $this->getRepository()->getAllByQuery($query, $perPage, $page);
    }
    
    public function getAllByQueryAndUser($query, $user, $perPage, $page)
    {
        return $this->getRepository()->getAllByQueryAndUser($query, $user, $perPage, $page);
    }
    
    public function getAllByUserForChart($user)
    {
        return $this->getRepository()->getAllByUserForChart($user);
    }
    
    public function getAllByTrader($user, $perPage, $page)
    {
        return $this->getRepository()->getAllByTrader($user, $perPage, $page);
    }
    
    public function getAllSignalsByRequest($request)
    {
        if(!$request->get('limit')){
            $request->query->set('limit', $this->defaultLimit);
        }
        return $this->getRepository()->getAllSignalsByRequest($request);
    }
    
    public function getAllSignalsByRequestAndTraderSlug($request, $slug)
    {
        if(!$request->get('limit')){
            $request->query->set('limit', $this->defaultLimit);
        }
        return $this->getRepository()->getAllSignalsByRequestAndTraderSlug($request, $slug);
    }
    
    public function countSignalsByRequest($request)
    {
        return $this->getRepository()->countSignalsByRequest($request);
    }
    
    public function countByQueryAndUser($query, $user)
    {
        return $this->getRepository()->countByQueryAndUser($query, $user);
    }
    
    public function countByTrader($user)
    {
        return $this->getRepository()->countByTrader($user);
    }
    
    public function countByQuery($query)
    {
        return $this->getRepository()->countByQuery($query);
    }

    public function countAll()
    {
        return $this->getRepository()->countAll();
    }
    
    public function save(Entity\Signals $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
    
    public function delete($param)
    {
        if (is_int($param)) {
            $entity = $this->get($param);
        } else {
            $entity = $param;
        }

        $this->em->remove($entity);
        $this->em->flush();
    }
    
    public function getRepository() 
    {
        return $this->em->getRepository('RaetingRaetingBundle:Signals');
    }
    
    public function getByUuid($id)
    {
        return $this->getRepository()->findOneByUuid($id);
    }
    
    public function countPips($to, $from, $pipsPosition)
    {
        $result = $from - $to;
        $integerLength = strlen(floor($result));
        $result = round($result, 6) * pow(10, $pipsPosition);
        return $result;
    }
    
    public function countPipsAndSave($signal)
    {
        if($signal->getBuy() == 0){
            $pips = $this->countPips($signal->getTakeProfit(), $signal->getOpen(), $signal->getSymbol()->getPipsPosition());
        }else{
            $pips = $this->countPips($signal->getOpen(), $signal->getTakeProfit(), $signal->getSymbol()->getPipsPosition());
        }
        $signal->setPips($pips);
        $this->em->flush();
    }
    
    public function signalToArray($signal)
    {
        $signalArr = array(
            'uuid'=>$signal->getUuid(),
            'type'=>$signal->getBuyValue(),
            'symbol'=>$signal->getSymbol()->getTitle(),
            'open'=>$signal->getOpen(),
            'takeProfit'=>$signal->getTakeprofit(),
            'stopLoss'=>$signal->getStoploss(),
            'profit'=>$signal->getProfit(),
            'description'=>$signal->getDescription(),
            'status'=>$signal->getStatus(),
            'dateCreated'=>$signal->getCreated(),
            'dateOpened'=>$signal->getOpened(),
            'dateClosed'=>$signal->getClosed(),
            'trader'=> $this->userService->traderToArray($signal->getUser())
        );
        return $signalArr;
    }
}
