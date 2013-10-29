<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

class Rate
{

    public function __construct(EntityManager $em, Symbol $symbolService)
    {
        $this->em = $em;
        $this->symbolService = $symbolService;
    }

    public function getNew()
    {
        return new Entity\Rate();
    }

    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function save(Entity\Rate $rate)
    {
        $query = 'INSERT INTO symbol_'.strtolower($rate->getSymbol()->getSymbol()). '(symbol_id, bid, ask, high, low, created, source_time)
                    VALUES ("'.$rate->getSymbol()->getId().'","'.$rate->getBid().'","'.$rate->getAsk().'","'.$rate->getHigh().'","'.$rate->getLow().'","'.$rate->getCreated()->format('Y-m-d H:i:s').'","'.$rate->getSourceTime()->format('Y-m-d H:i:s').'")';
        
        $conn = $this->em->getConnection();
        $conn->exec($query);
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
        return $this->em->getRepository('RaetingRaetingBundle:Rate');
    }
    
    private function importxml($xml, $mappingArray = array('symbol' => 'symbol', 'ask' => 'ask', 'bid' => 'bid', 'created' => 'created'), $gmt = '')
    {
        $inserts = 0;
        if(!empty($xml)){
            foreach($xml as $rate){
                if($symbol = $this->symbolService->getBySymbol((string)$rate->$mappingArray['symbol'])){
                    
                    $date = new \DateTime((string)$rate->$mappingArray['created'].' '.$gmt);
                    $date->setTimezone( new \DateTimeZone('Europe/Vilnius') );
                    
                    $rateToInsert = $this->getNew();
                    $rateToInsert->setSymbol($symbol);
                    $rateToInsert->setAsk((string)$rate->$mappingArray['ask']);
                    $rateToInsert->setBid((string)$rate->$mappingArray['bid']);
                    $rateToInsert->setSourceTime($date);
                    $rateToInsert->setCreated(new \DateTime());
                    $this->save($rateToInsert, $symbol->getSymbol());
                    $inserts++;
                }
            }
        }
        return $inserts;
    }
    
    private function importCsv($csv, $mappingArray = array('symbol' => 0, 'ask' => 1, 'bid' => 1, 'created' => null), $gmt = '')
    {
        $inserts = 0;
        $rows = explode("\n", $csv);
        if(!empty($rows)){
            foreach($rows as $row){
                $row = explode(",", $row);
                if(!empty($row[0])){
                    $intValue = (int)($row[$mappingArray['ask']]);
                    if(!empty($intValue)){
                        if($symbol = $this->symbolService->getBySymbol(str_replace('"', '', $row[$mappingArray['symbol']]))){

                            if($mappingArray['created'] !== null){
                                $date = new \DateTime($row[$mappingArray['created']].' '.$gmt);
                                $date->setTimezone( new \DateTimeZone('Europe/Vilnius') );
                            }else{
                                $date = new \DateTime();
                            }

                            $rateToInsert = $this->getNew();
                            $rateToInsert->setSymbol($symbol);
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
    
    public function getInsertDataQuery($data)
    {
        $symbol = $this->symbolService->getBySymbol($data['symbol']);
        if(!empty($symbol)){
            $rate = $this->findOneBySymbolAndDate($symbol, date('Y-m-d', strtotime($data['date'])));
            if(empty($rate)){
                $query = 'INSERT INTO symbol_'.$data['symbol'].' (bid, ask, high, low, created, source_time, symbol_id) 
                    VALUES ("'.$data['bid'].'","'.$data['ask'].'","'.$data['high'].'","'.$data['low'].'","'.date('Y-m-d').'","'.$data['date'].'",'.$symbol->getId().');'."\n";
            }else{
                $query = 'UPDATE symbol_'.$data['symbol'].' 
                    SET bid="'.$data['bid'].'",ask="'.$data['ask'].'",high="'.$data['high'].'",low="'.$data['low'].'",created="'.date('Y-m-d').'",source_time="'.$data['date'].'",symbol_id='.$symbol->getId().' 
                    WHERE id = '.$rate->getId().";\n";
            }
            return $query;
        }
        return null;
    }
    
    public function executeQuery($query)
    {
        $conn = $this->em->getConnection();
        return $conn->exec($query);
    }
    
    public function getLastBySymbol($symbol)
    {
        return $this->getRepository()->findOneBy(array('symbol' => $symbol));
    }
    
    public function findAllBySymbolInRange($symbol, $rangeFrom, $rangeTo)
    {
        return $this->findAllBySymbol($symbol, $rangeFrom, $rangeTo);
    }
    
    public function importCsvFromYahoo($url)
    {
        $csv = file_get_contents($url);
        return $this->importCsv($csv);
    }
    
    public function findAllForAggregation($date)
    {
        return $this->getRepository()->findAllForAggregation($date);
    }
    
    public function getRatesBySymbolAndDate($symbolId, $date)
    {
        return $this->getRepository()->getRatesBySymbolAndDate($symbolId, $date);
    }
    
    public function importXmlFromFXCM($url)
    {
        $xml = simplexml_load_file(rawurlencode($url));
        return $this->importxml($xml->Rate, array('symbol' => 'Symbol', 'ask' => 'Ask', 'bid' => 'Bid', 'high' => 'High', 'low' => 'Low', 'created' => 'Time'), '-4GMT');
    }
    
    public function findAllBySymbol($symbol, $rangeFrom = null, $rangeTo = null)
    {
        $query = 'SELECT * 
                    FROM symbol_'.$symbol->getSymbol().'
                    WHERE 1=1';
        
        if($rangeFrom != null){
            $query .= ' AND source_time >= "'.$rangeFrom.'"';
        }
        
        if($rangeTo != null){
            $query .= ' AND source_time <= "'.$rangeTo.'"';
        }
        
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $symbols = $stmt->fetchAll();
        
        return $symbols;
        
    }
    
    public function findOneBySymbolAndDate($symbol, $date)
    {
        $query = 'SELECT * 
                    FROM symbol_'.$symbol->getSymbol(). ' 
                    WHERE source_time LIKE "%'.$date.'%" 
                    AND high IS NOT NULL';
        
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $symbol = $stmt->fetch(\PDO::FETCH_COLUMN);
        
        return $symbol;
    }
}
