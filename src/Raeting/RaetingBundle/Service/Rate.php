<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

class Rate
{
    
    private $pointsInGraph = 500;

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
        $query = 'INSERT INTO symbol_'.strtolower($rate->getSymbol()->getSymbol()). '(symbol_id, bid, ask, high, low, created, source_time, source_date)
                    VALUES ("'.$rate->getSymbol()->getId().'","'.$rate->getBid().'","'.$rate->getAsk().'","'.$rate->getHigh().'","'.$rate->getLow().'","'.$rate->getCreated()->format('Y-m-d H:i:s').'","'.$rate->getSourceTime()->format('Y-m-d H:i:s').'","'.$rate->getSourceDate()->format('Y-m-d').'")';
        
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
                    $rateToInsert->setHigh((string)$rate->$mappingArray['high']);
                    $rateToInsert->setLow((string)$rate->$mappingArray['low']);
                    $rateToInsert->setSourceTime($date);
                    $rateToInsert->setSourceDate($date);
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
                            $rateToInsert->setHigh($row[$mappingArray['high']]);
                            $rateToInsert->setLow($row[$mappingArray['low']]);
                            $rateToInsert->setSourceTime($date);
                            $rateToInsert->setSourceDate($date);
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
        $data['symbol'] = strtolower($data['symbol']);
        $symbol = $this->symbolService->getBySymbol($data['symbol']);
        if(!empty($symbol)){
            $rate = $this->findOneBySymbolAndDate($symbol, date('Y-m-d H:i', strtotime($data['date'])));
            
            $data['time'] = $data['date'];
            $data['date'] = date('Y-m-d', strtotime($data['date']));
            
            if(empty($rate)){
                $query = 'INSERT INTO symbol_'.$data['symbol'].' (bid, ask, high, low, created, source_time, source_date, symbol_id) 
                    VALUES ("'.$data['bid'].'","'.$data['ask'].'","'.$data['high'].'","'.$data['low'].'","'.date('Y-m-d').'","'.$data['time'].'","'.$data['date'].'",'.$symbol->getId().');'."\n";
            }else{
                $query = 'UPDATE symbol_'.$data['symbol'].' 
                    SET bid="'.$data['bid'].'",ask="'.$data['ask'].'",high="'.$data['high'].'",low="'.$data['low'].'",created="'.date('Y-m-d').'",source_time="'.$data['time'].'",source_date="'.$data['date'].'",symbol_id='.$symbol->getId().' 
                    WHERE id = '.$rate['id'].";\n";
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
    
    public function findAllBySymbolInRangeByDay($symbol, $rangeFrom, $rangeTo)
    {
        return $this->findAllBySymbol($symbol, $rangeFrom, $rangeTo, true);
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
    
    private function getStmt($query)
    {
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    private function fetchAll($query)
    {
        return $this->getStmt($query)->fetchAll();
    }
    
    private function fetch($query)
    {
        return $this->getStmt($query)->fetch();
    }
    
    
    public function findAllBySymbolForGraph($symbol, $rangeFrom = null, $rangeTo = null, $buy = 1)
    {
        $countQuery = 'SELECT count(id) as counter
                    FROM symbol_'.strtolower($symbol->getSymbol()).'
                    WHERE source_time >= "'.$rangeFrom.'" 
                    AND source_time <= "'.$rangeTo.'"';
        $totalRows = $this->fetch($countQuery);
        $totalRows = $totalRows['counter'];
        if($totalRows > $this->pointsInGraph*2){
            $nth = ' AND rownum % '.(int)floor($totalRows / $this->pointsInGraph).' = 1';
        }else{
            $nth = '';
        }
        if($buy == 0){
            $rateSelect = 'ask as rate';
        }else{
            $rateSelect = 'bid as rate';
        }
        $query = 'SELECT '.$rateSelect.', source_time
                    FROM ( 
                        SELECT 
                            @row := @row +1 AS rownum, symbol_'.strtolower($symbol->getSymbol()).'.*
                        FROM ( 
                            SELECT @row :=0) r, symbol_'.strtolower($symbol->getSymbol()).'
                        ) ranked 
                        WHERE source_time >= "'.$rangeFrom.'" 
                        AND source_time <= "'.$rangeTo.'"
                        '.$nth.'
                        ORDER BY source_time ASC';
        $symbols = $this->fetchAll($query);
        
        return $symbols;
        
    }
    
    public function findAllBySymbol($symbol, $rangeFrom = null, $rangeTo = null, $groupByDay = false)
    {
        $query = 'SELECT * 
                    FROM symbol_'.strtolower($symbol->getSymbol()).'
                    WHERE 1=1';
        
        if($rangeFrom != null){
            $query .= ' AND source_time >= "'.$rangeFrom.'"';
        }
        
        if($rangeTo != null){
            $query .= ' AND source_time <= "'.$rangeTo.'"';
        }
        
        if($groupByDay != false){
            $query .= ' GROUP BY source_date';
        }
        
        $symbols = $this->fetchAll($query);
        
        return $symbols;
        
    }
    
    public function findOneBySymbolAndDate($symbol, $datetime)
    {
        $query = 'SELECT * 
                    FROM symbol_'.strtolower($symbol->getSymbol()). ' 
                    WHERE source_time LIKE "%'.$datetime.'%" 
                    AND high IS NOT NULL';
        
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $symbol = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $symbol;
    }
    
    private function divideInterval($interval, $number = 2)
    {
        $seconds =  $interval->y     * 31556926 
                + $interval->m  * 2629743
                + $interval->d  * 86400
                + $interval->h  * 3600
                + $interval->i  * 60
                + $interval->s;
        
        $seconds = floor($seconds/$number);
        
        return $this->formatDateIntervalFromSeconds($seconds);
    }
    
    private function formatDateIntervalFromSeconds($seconds) 
      { 
        $interval = new \DateInterval('PT3600S');
        $interval->y = floor($seconds/31556926); 
        $seconds -= $interval->y * 31556926; 
        $interval->m = floor($seconds/2629743); 
        $seconds -= $interval->m * 2629743; 
        $interval->d = floor($seconds/86400); 
        $seconds -= $interval->d * 86400; 
        $interval->h = floor($seconds/3600); 
        $seconds -= $interval->h * 3600; 
        $interval->i = floor($seconds/60); 
        $seconds -= $interval->i * 60; 
        $interval->s = $seconds; 
        return $interval;
      } 
      
      private function diffDate($date, $interval, $sign)
      {
          return date('Y-m-d H:i:s', strtotime($date->format('Y-m-d H:i:s').$interval->format($sign.'%y YEARS '.$sign.'%m MONTHS '.$sign.'%d DAYS '.$sign.'%h HOURS '.$sign.'%i MINUTES '.$sign.'%s SECONDS')));
      }
    
    public function calculateGraphRanges($entity)
    {
        if($entity->getClosePrice()){
            $diff = $entity->getClosed()->diff($entity->getCreated());
            $diff = $this->divideInterval($diff);
            
            $dateFrom = $this->diffDate($entity->getCreated(), $diff, '-');
            $dateTo = $this->diffDate($entity->getClosed(), $diff, '+');
        }else{
            $dateTo = new \DateTime();
            $diff = $dateTo->diff($entity->getCreated());
            $diff = $this->divideInterval($diff);
            
            $dateFrom = $this->diffDate($entity->getCreated(), $diff, '-');
            $dateTo = $dateTo->format('Y-m-d H:i:s');
        }
        return array('from' => $dateFrom, 'to' => $dateTo);
    }
}
