<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

class TickerRate
{

    public function __construct(EntityManager $em, Symbol $symbolService)
    {
        $this->em = $em;
        $this->symbolService = $symbolService;
    }

    public function getNew()
    {
        return new Entity\TickerRate();
    }

    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function save(Entity\TickerRate $entity)
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
        return $this->em->getRepository('RaetingRaetingBundle:TickerRate');
    }
    
    private function importxml($xml, $mappingArray = array('ticker' => 'ticker', 'ask' => 'ask', 'bid' => 'bid', 'created' => 'created'), $gmt = '')
    {
        $inserts = 0;
        if(!empty($xml)){
            foreach($xml as $rate){
                if($ticker = $this->symbolService->getBySymbol((string)$rate->$mappingArray['ticker'])){
                    
                    $date = new \DateTime((string)$rate->$mappingArray['created'].' '.$gmt);
                    $date->setTimezone( new \DateTimeZone('Europe/Vilnius') );
                    
                    $rateToInsert = $this->getNew();
                    $rateToInsert->setTicker($ticker);
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
    
    public function getLastBySymbol($symbol)
    {
        return $this->getRepository()->findOneBy(array('ticker' => $symbol));
    }
    
    public function importCsvFromYahoo($url)
    {
        $csv = file_get_contents($url);
        return $this->importCsv($csv);
    }
    
}
