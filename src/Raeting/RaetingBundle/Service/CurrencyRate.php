<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

class CurrencyRate
{

    public function __construct(EntityManager $em, Symbol $symbolService)
    {
        $this->em = $em;
        $this->symbolService = $symbolService;
    }

    public function getNew()
    {
        return new Entity\CurrencyRate();
    }

    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function save(Entity\CurrencyRate $entity)
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
        return $this->em->getRepository('RaetingRaetingBundle:CurrencyRate');
    }
    
    private function importxml($xml, $mappingArray = array('currency' => 'currency', 'ask' => 'ask', 'bid' => 'bid', 'created' => 'created'), $gmt = '')
    {
        $inserts = 0;
        if(!empty($xml)){
            foreach($xml as $rate){
                if($currency = $this->symbolService->getBySymbol((string)$rate->$mappingArray['currency'])){
                    
                    $date = new \DateTime((string)$rate->$mappingArray['created'].' '.$gmt);
                    $date->setTimezone( new \DateTimeZone('Europe/Vilnius') );
                    
                    $rateToInsert = $this->getNew();
                    $rateToInsert->setCurrency($currency);
                    $rateToInsert->setAsk((string)$rate->$mappingArray['ask']);
                    $rateToInsert->setBid((string)$rate->$mappingArray['bid']);
                    $rateToInsert->setSourceTime($date);
                    $rateToInsert->setCreated(new \DateTime());
                    $this->save($rateToInsert);
                    $inserts++;
                }
            }
        }
        return $inserts;
    }
    
    public function importXmlFromFXCM($url)
    {
        $xml = simplexml_load_file(rawurlencode($url));
        return $this->importxml($xml->Rate, array('currency' => 'Symbol', 'ask' => 'Ask', 'bid' => 'Bid', 'created' => 'Time'), '-4GMT');
    }
    
    public function getLastBySymbol($symbol)
    {
        return $this->getRepository()->findOneBy(array('currency' => $symbol));
    }
    
}
