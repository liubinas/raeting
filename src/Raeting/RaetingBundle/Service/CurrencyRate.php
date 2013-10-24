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
                    if(isset($mappingArray['high'])){
                        $rateToInsert->setHigh((string)$rate->$mappingArray['high']);
                    }
                    if(isset($mappingArray['low'])){
                        $rateToInsert->setLow((string)$rate->$mappingArray['low']);
                    }
                    $rateToInsert->setSourceTime($date);
                    $rateToInsert->setCreated(new \DateTime());
                    $this->save($rateToInsert);
                    $inserts++;
                }
            }
        }
        return $inserts;
    }
    
    private function importCsv($csv, $mappingArray = array('ticker' => 0, 'ask' => 1, 'bid' => 1, 'created' => null), $gmt = '')
    {
        $inserts = 0;
        $rows = explode("\n", $csv);
        if(!empty($rows)){
            foreach($rows as $row){
                $row = explode(",", $row);
                if(!empty($row[0])){
                    $intValue = (int)($row[$mappingArray['ask']]);
                    if(!empty($intValue)){
                        if($ticker = $this->symbolService->getBySymbol(str_replace('"', '', $row[$mappingArray['ticker']]))){

                            if($mappingArray['created'] !== null){
                                $date = new \DateTime($row[$mappingArray['created']].' '.$gmt);
                                $date->setTimezone( new \DateTimeZone('Europe/Vilnius') );
                            }else{
                                $date = new \DateTime();
                            }

                            $rateToInsert = $this->getNew();
                            $rateToInsert->setTicker($ticker);
                            $rateToInsert->setAsk($row[$mappingArray['ask']]);
                            $rateToInsert->setBid($row[$mappingArray['bid']]);
                            if(isset($mappingArray['high'])){
                                $rateToInsert->setHigh((string)$rate->$mappingArray['high']);
                            }
                            if(isset($mappingArray['low'])){
                                $rateToInsert->setLow((string)$rate->$mappingArray['low']);
                            }
                            $rateToInsert->setSourceTime($date);
                            $rateToInsert->setCreated(new \DateTime());
                            $this->save($rateToInsert);
                            $inserts++;
                        }
                    }
                }
            }
        }
        return $inserts;
    }
    
    
    public function importXmlFromFXCM($url)
    {
        $xml = simplexml_load_file(rawurlencode($url));
        return $this->importxml($xml->Rate, array('currency' => 'Symbol', 'ask' => 'Ask', 'bid' => 'Bid', 'high' => 'High', 'low' => 'Low', 'created' => 'Time'), '-4GMT');
    }
    
    public function getLastBySymbol($symbol)
    {
        return $this->getRepository()->findOneBy(array('currency' => $symbol));
    }
    
    public function findAllForAggregation($date)
    {
        return $this->getRepository()->findAllForAggregation($date);
    }
    
    public function getRatesBySymbolAndDate($symbolId, $date)
    {
        return $this->getRepository()->getRatesBySymbolAndDate($symbolId, $date);
    }
    
}
