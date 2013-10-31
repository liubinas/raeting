<?php

namespace Raeting\RaetingBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;
use Raeting\UserBundle\Service\UserService;
use Raeting\RaetingBundle\Service\Rate;

class Signals
{
    private $rateService;
    
    
    public function __construct(EntityManager $em, UserService $userService, $defaultLimit, Rate $rateService)
    {
        $this->em = $em;
        $this->userService = $userService;
        $this->defaultLimit = $defaultLimit;
        $this->rateService = $rateService;
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
    
    public function getAllOpened()
    {
        return $this->getRepository()->findBy(array('status' => Entity\Signals::STATUS_OPENED));
    }
    
    public function getAllNotCalculated()
    {
        return $this->getRepository()->findBy(array('status' => Entity\Signals::STATUS_CLOSED, 'pips' => null));
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
    
    private function inRangeForSell($signal, $rate)
    {
        if($signal->getTakeProfit() <= $rate && $signal->getStopLoss() >= $rate){
            return false;
        }
        return true;
    }
    
    private function inRangeForBuy($signal, $rate)
    {
        if($signal->getTakeProfit() >= $rate && $signal->getStopLoss() <= $rate){
            return false;
        }
        return true;
    }
    
    public function updateNewStatusesAndPrices($signal)
    {
        $rate = $this->rateService->getLastBySymbol($signal->getSymbol()->getId());
        if(!$rate){
            return;
        }
        if(($signal->getBuy() == 1 && $rate->getBid() <= $signal->getOpen()) ||
                ($signal->getBuy() == 0 && $rate->getAsk() >= $signal->getOpen())){
            
            $signal->setStatus(Entity\Signals::STATUS_OPENED);
            
            if($signal->getBuy() == 1){
                $signal->setOpenPrice($rate->getBid());
            }else{
                $signal->setOpenPrice($rate->getAsk());
            }
            $this->em->flush();
        }
    }
    
    public function updateOpenedStatusesAndPrices($signal)
    {
        $this->setRateService($signal);
        $rate = $this->rateService->getLastBySymbol($signal->getSymbol()->getId());
        if(!$rate){
            return;
        }
        if(($signal->getBuy() == 0 && $this->inRangeForSell($signal, $rate->getAsk())) || 
                ($signal->getBuy() == 1 && $this->inRangeForBuy($signal, $rate->getBid()))){
            $signal->setStatus(Entity\Signals::STATUS_CLOSED);
            
            if($signal->getBuy() == 1){
                $signal->setClosePrice($rate->getBid());
            }else{
                $signal->setClosePrice($rate->getAsk());
            }
            $this->em->flush();
        }
    }
    
    public function countPipsAndSave($signal)
    {
        $pips = null;
        if($signal->getBuy() == 1){
            $pips = $this->countPips($signal->getOpenPrice(), $signal->getClosePrice(), $signal->getSymbol()->getPipsPosition());
        }else{
            $pips = $this->countPips($signal->getClosePrice(), $signal->getOpenPrice(), $signal->getSymbol()->getPipsPosition());
        }
        if($pips !== null){
            $signal->setPips($pips);
            $this->em->flush();
        }
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
