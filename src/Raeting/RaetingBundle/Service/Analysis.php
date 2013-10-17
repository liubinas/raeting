<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

use Raeting\RaetingBundle\Service\AnalystService;
use Raeting\RaetingBundle\Service\SymbolService;

class Analysis
{

    public function __construct(EntityManager $em, Analyst $analystService, Symbol $symbolService)
    {
        $this->em = $em;
        $this->analystService = $analystService;
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
    
    public function getAllByAnalyst($analyst)
    {
        return $this->getRepository()->findBy(array('analyst' => $analyst));
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
    
    public function insertData($data)
    {
        $analyst = $this->analystService->getByName($data['analyst']);
        $symbol = $this->symbolService->getBySymbol($data['ticker']);
        if(!empty($analyst) && !empty($symbol)){
            $analysis = $this->getNew();
            $analysis->setRecommendation($data['recommendation']);
            $analysis->setEstimation($data['estimation']);
            $analysis->setDate(new \DateTime($data['date']));
            $analysis->setPeriod($data['period']);
            $analysis->setAnalyst($analyst);
            $analysis->setTicker($symbol);
            $this->save($analysis);
            return 1;
        }
        return 0;
    }
}
