<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

use Raeting\RaetingBundle\Service\Rate;
use Raeting\RaetingBundle\Service\Symbol;

class Aggregation
{

    public function __construct(EntityManager $em, Rate $rateService)
    {
        $this->em = $em;
        $this->rateService = $rateService;
    }
    
    private function calculateRateValues($rates, $type)
    {
        $result = array('bid' => null, 'ask' => null, 'high' => null, 'low' => null, 'query' => null);
        if(!empty($rates)){
            $query = '';
            $totalBid = $totalAsk = 0;
            $high = $low = $rates[0]->getBid();
            $totalRates = count($rates);
            
            foreach($rates as $rate){
                $totalBid += $rate->getBid();
                $totalAsk += $rate->getAsk();
                if($rate->getBid() > $high){
                    $high = $rate->getBid();
                }
                if($rate->getAsk() > $high){
                    $high = $rate->getAsk();
                }
                if($rate->getBid() < $low){
                    $low = $rate->getBid();
                }
                if($rate->getAsk() < $low){
                    $low = $rate->getAsk();
                }
                $query .= 'DELETE FROM '.$type.'_rate WHERE id = '.$rate->getId().";\n";
            }
            
            $result['bid'] = $totalBid/$totalRates;
            $result['ask'] = $totalAsk/$totalRates;
            $result['high'] = $high;
            $result['low'] = $low;
            $result['query'] = $query;
        }
        return $result;
    }

    private function aggregate($type, $service)
    {
        $date = date('Y-m-d', strtotime(date('Y-m-d') . ' - 1 DAY'));
        $rates = $service->findAllForAggregation($date);
        $symbolsUpdated = 0;
        if(!empty($rates)){
            $conn = $this->em->getConnection();
            foreach($rates as $rate){
                $ratesBySymbolAndDate = $service->getRatesBySymbolAndDate($rate['id'], $rate['source_date']);
                $aggregatedValues = $this->calculateRateValues($ratesBySymbolAndDate, $type);
                $query = 'INSERT INTO '.$type.'_rate ('.$type.'_id, bid, ask, high, low, created, source_time) 
                    VALUES ('.$rate['id'].','.$aggregatedValues['bid'].','.$aggregatedValues['ask'].','.$aggregatedValues['high'].','.$aggregatedValues['low'].',"'.date('Y-m-d H:i:s').'","'.$rate['source_date'].'");'."\n";
                $query .= $aggregatedValues['query'];
                $conn->exec($query);
                $symbolsUpdated++;
            }
        }
        return $symbolsUpdated;
    }
    
    public function aggregateTickerRates()
    {
        return $this->aggregate('ticker', $this->rateService);
    }
    
    public function aggregateCurrencyRates()
    {
        return $this->aggregate('currency', $this->rateService);
    }
}
