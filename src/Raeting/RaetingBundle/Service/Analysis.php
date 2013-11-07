<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

use Raeting\RaetingBundle\Service\SymbolService;

class Analysis
{

    public function __construct(EntityManager $em, Symbol $symbolService)
    {
        $this->em = $em;
        $this->symbolService = $symbolService;
    }

    public function getNew()
    {
        return new Entity\Analysis();
    }

    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function save(Entity\Analysis $entity)
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
        return $this->em->getRepository('RaetingRaetingBundle:Analysis');
    }
    
    public function getAllByAnalyst($analyst, $perPage, $page)
    {
        return $this->getRepository()->getAllByAnalyst($analyst, $perPage, $page);
    }
    
    public function getAllByQuery($query, $perPage, $page)
    {
        return $this->getRepository()->getAllByQuery($query, $perPage, $page);
    }
    
    public function getAllWithPaging($perPage, $page)
    {
        return $this->getRepository()->getAllWithPaging($perPage, $page);
    }
    
    public function getAllByAnalystAndTicker($analyst, $ticker, $perPage, $page)
    {
        return $this->getRepository()->getAllByAnalystAndTicker($analyst, $ticker, $perPage, $page);
    }
    
    public function getAllByAnalystAndTickerForGraph($analyst, $ticker)
    {
        return $this->getRepository()->getAllByAnalystAndTickerForGraph($analyst, $ticker);
    }
    
    public function getAnalystEstimationRangeByTicker($analyst, $ticker)
    {
        return $this->getRepository()->getAnalystEstimationRangeByTicker($analyst, $ticker);
    }
    
    public function getAllByAnalystAndQuery($analyst, $query, $perPage, $page)
    {
        return $this->getRepository()->getAllByAnalystAndQuery($analyst, $query, $perPage, $page);
    }
    
    public function countAllByAnalyst($analyst)
    {
        return $this->getRepository()->countAllByAnalyst($analyst);
    }
    
    public function countAll()
    {
        return $this->getRepository()->countAll();
    }
    
    public function countAllByAnalystAndQuery($analyst, $query)
    {
        return $this->getRepository()->countAllByAnalystAndQuery($analyst, $query);
    }
    
    public function countAllByQuery($query)
    {
        return $this->getRepository()->countAllByQuery($query);
    }
    
    private function formatRecommendation($recommendation)
    {
        if($recommendation == 'overweight'){
            $recommendation = Entity\Analysis::RECOMMENDATION_BUY;
        }elseif($recommendation == 'overwt/neutral'){
            $recommendation = Entity\Analysis::RECOMMENDATION_BUY;
        }elseif($recommendation == 'overwt/positive'){
            $recommendation = Entity\Analysis::RECOMMENDATION_BUY;
        }
        if(in_array($recommendation, array(Entity\Analysis::RECOMMENDATION_BUY, Entity\Analysis::RECOMMENDATION_HOLD, Entity\Analysis::RECOMMENDATION_SELL))){
            return $recommendation;
        }
        return null;
    }
    
    public function insertData($data, $analyst)
    {
        $symbol = $this->symbolService->getBySymbol($data['ticker']);
        if(!empty($analyst) && !empty($symbol)){
            $analysis = $this->getRepository()->findOneBySymbolAndAnalystAndDate($symbol, $analyst, date('Y-m-d', strtotime($data['date'])));
            if(empty($analysis)){
                $analysis = $this->getNew();
                $analysis->setTicker($symbol);
                $analysis->setAnalyst($analyst);
                $return = 1;
            }else{
                $return = 0;
            }
            $analysis->setRecommendation($data['recommendation']);
            $analysis->setEstimation($data['estimation']);
            $analysis->setDate(new \DateTime($data['date']));
            $analysis->setPeriod($data['period']);
            $this->save($analysis);
            return $return;
        }
        return 0;
    }
    
    public function getLastDateByAnalyst($analyst)
    {
        return $this->getRepository()->getLastDateByAnalyst($analyst);
    }
}
